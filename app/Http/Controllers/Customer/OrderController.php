<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserHistory;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.orders.show', compact('order'));
    }

    // Hiển thị form checkout (GET)
    public function showCheckoutForm(Request $request)
{
    $sessionCart = session('cart', []);
    $selectedKeys = $request->query('selected', []);
    $buyNow = session('buy_now', null);

    if ($buyNow) {
        $cart = ['buy_now' => $buyNow];
        $selected = ['buy_now'];
    } elseif (!empty($selectedKeys)) {
        $cart = [];
        foreach ($selectedKeys as $key) {
            if (isset($sessionCart[$key])) $cart[$key] = $sessionCart[$key];
        }
        $selected = $selectedKeys;
    } else {
        $cart = $sessionCart;
        $selected = array_keys($sessionCart);
    }

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
    }

    $total = collect($cart)->sum(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 0));
    $user = auth()->user();

    $coupons = Coupon::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

    // Xử lý coupon giống checkout cũ
    $discount = 0;
    $couponId = $request->input('coupon_id');
    if ($couponId) {
        $coupon = Coupon::find($couponId);
        if ($coupon && $total >= $coupon->min_order_value) {
            if ($coupon->discount_type === 'percent') {
                $discount = (int) round($total * ($coupon->discount / 100));
            } else {
                $discount = $coupon->discount;
            }
            $discount = min($discount, $total); // không để âm
        }
    }

    $finalTotal = $total - $discount;

    return view('customer.cart.checkout', compact(
        'cart', 'total', 'user', 'selected', 'coupons', 'discount', 'finalTotal', 'couponId'
    ));
}


    // POST: tạo order
    public function checkout(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'payment'  => 'required|string|in:cod,momo',
            'selected' => 'nullable|array',
            'coupon_id'=> 'nullable|exists:coupons,id',
        ]);

        $sessionCart = session('cart', []);
        $selected = $request->input('selected', []);
        $buyNow = session('buy_now', null);

        // chuẩn hóa $cartItems => luôn là mảng chỉ số [item, item, ...]
        if ($buyNow) {
            $cartItems = [$buyNow];
        } elseif (!empty($selected)) {
            $cartItems = [];
            foreach ($selected as $key) {
                if (isset($sessionCart[$key])) {
                    $cartItems[] = $sessionCart[$key];
                }
            }
            if (empty($cartItems)) return redirect()->back()->with('error','Không có sản phẩm hợp lệ để đặt hàng.');
        } else {
            $cartItems = array_values($sessionCart);
            if (empty($cartItems)) return redirect()->route('cart.index')->with('error','Giỏ hàng trống!');
        }

        // tính tổng
        $total = collect($cartItems)->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1));

        // xử lý coupon (chỉ đọc ở đây, sẽ kiểm tra và cập nhật lại trong transaction)
        $couponId = $request->input('coupon_id');
        $coupon   = $couponId ? Coupon::find($couponId) : null;
        $discount = 0;

        if ($coupon) {
            if ($coupon->discount_type === 'percent') {
                $discount = (int) round($total * ($coupon->discount / 100));
            } else {
                $discount = $coupon->discount;
            }
            $discount = min($discount, $total);
        }


        $finalTotal = $total - $discount;

        DB::beginTransaction();
        try {
            // tạo order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'name'           => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'total'          => $total,
                'discount'       => $discount,
                'final_total'    => $finalTotal,
                'status'         => 'pending',
                'payment_method' => $request->payment,
                'payment_status' => 'unpaid',
                'coupon_id'      => $coupon?->id,
            ]);

            // duyệt item: kiểm tra stock (lock), tạo OrderItem và trừ stock
            foreach ($cartItems as $item) {
                $productId = $item['id'] ?? null;
                $qty = max(1, (int) ($item['quantity'] ?? 1));
                if ($productId) {
                    // khóa hàng để tránh race condition
                    $product = Product::lockForUpdate()->find($productId);
                    if (!$product) {
                        throw new \Exception("Sản phẩm không tồn tại (ID: {$productId}).");
                    }
                    if ($product->quantity < $qty) {
                        throw new \Exception("Sản phẩm \"{$product->name}\" chỉ còn {$product->quantity} trong kho. Vui lòng điều chỉnh số lượng.");
                    }

                    // tạo order item (lưu giá hiện tại của product)
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $qty,
                        'price'      => $item['price'] ?? $product->price,
                        'color'      => $item['color'] ?? null,
                        'size'       => $item['size'] ?? null,
                    ]);

                    // trừ stock (dùng decrement để đơn giản)
                    $product->decrement('quantity', $qty);
                } else {
                    // Nếu item không có product id (không hợp lệ) — có thể skip hoặc throw
                    throw new \Exception("Một sản phẩm trong giỏ không hợp lệ.");
                }

                // Lưu lịch sử mua sản phẩm
                UserHistory::create([
                    'user_id'    => Auth::id(),
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'action_type'=> 'buy_product',
                    'used_at'    => now(),
                ]);
            }

            // cập nhật coupon.used_count & tạo lịch sử dùng coupon
            if ($coupon) {
                // Lưu lịch sử dùng coupon
                UserHistory::create([
                    'user_id'   => Auth::id(),
                    'order_id'  => $order->id,
                    'coupon_id' => $coupon->id,
                    'discount'  => $discount,
                    'action_type' => 'use_coupon',
                    'used_at'   => now(),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        // clear giỏ hàng (sau commit)
        if ($buyNow) {
            session()->forget('buy_now');
        } elseif (!empty($selected)) {
            foreach ($selected as $key) {
                if (isset($sessionCart[$key])) unset($sessionCart[$key]);
            }
            session(['cart' => $sessionCart]);
        } else {
            session()->forget('cart');
        }

        if ($request->payment === 'cod') {
            return redirect()->route('orders.index')
                ->with('success', 'Đặt hàng thành công! Vui lòng thanh toán khi nhận hàng.');
        } else {
            return redirect()->route('payment.momo', ['order' => $order->id]);
        }
    }

    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'image' => $product->image ?? '',
        ];

        session(['buy_now' => $item]);

        return redirect()->route('checkout.form');
    }

    public function codPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->update([
            'payment_method' => 'cod',
            'payment_status' => 'unpaid', // vẫn để unpaid cho COD
            'status' => 'processing',
        ]);

        return view('customer.success', compact('order'));
    }

    public function index()
    {
        $allOrders = Order::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        $perPage = 5;
        $page = request()->get('page', 1);
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $allOrders->forPage($page, $perPage),
            $allOrders->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // truyền cả $orders (phân trang) và $allOrders (dùng để group/count cho tab)
        return view('customer.orders.index', [
            'orders' => $orders,
            'allOrders' => $allOrders,
        ]);
    }

    //Hủy đơn hàng
    public function cancel($id) {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        DB::beginTransaction();
        try {
            // Trả lại stock
            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            // Nếu có coupon, giảm used_count (không để âm)
            if ($order->coupon_id) {
                $coupon = Coupon::lockForUpdate()->find($order->coupon_id);
                if ($coupon && $coupon->used_count > 0) {
                    $coupon->decrement('used_count');
                }
            }

            $order->update(['status' => 'canceled']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không thể hủy đơn: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    //Lịch sử mua hàng
    public function history() {
        $histories = \App\Models\UserHistory::where('user_id', auth()->id())
            ->whereNotNull('order_id') // Chỉ lấy lịch sử có mã đơn hàng
            ->with(['product', 'order', 'coupon'])
            ->orderByDesc('used_at')
            ->paginate(10);

        return view('customer.history.index', compact('histories'));
    }
}