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
use App\Models\ProductDetail;

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

    // Hiển thị form checkout
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

        // Xử lý coupon
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
                $discount = min($discount, $total);
            }
        }

        $finalTotal = $total - $discount;

        return view('customer.cart.checkout', compact(
            'cart', 'total', 'user', 'selected', 'coupons', 'discount', 'finalTotal', 'couponId'
        ));
    }

    // Xử lý checkout
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

        // Chuẩn hóa cartItems
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

        // Tính tổng
        $total = collect($cartItems)->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1));

        // Coupon
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
            // Tạo order
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total' => $finalTotal,
                'payment_method' => $request->payment,
                'payment_status' => $request->payment === 'cod' ? 'unpaid' : 'pending',
                'status' => 'pending',
                'coupon_id' => $coupon->id ?? null,
                'discount' => $discount,
            ]);

            // Tạo order items
foreach ($cartItems as $item) {
    // Luôn ưu tiên lấy theo product_detail_id đã có trong giỏ
    if (empty($item['product_detail_id'])) {
        throw new \Exception("Thiếu thông tin chi tiết sản phẩm cho {$item['name']}");
    }

    $detail = ProductDetail::find($item['product_detail_id']);

    if (!$detail) {
        throw new \Exception("Không tìm thấy chi tiết sản phẩm cho {$item['name']} (Size: {$item['size']}, Color: {$item['color']})");
    }

    // Kiểm tra tồn kho
    if ($detail->quantity < $item['quantity']) {
        throw new \Exception("Sản phẩm {$item['name']} (Size: {$item['size']}, Color: {$item['color']}) không đủ số lượng tồn kho.");
    }

    // Tạo order item
    OrderItem::create([
        'order_id'          => $order->id,
        'product_id'        => $item['id'],
        'product_detail_id' => $detail->id,
        'quantity'          => $item['quantity'],
        'price'             => $item['price'],
    ]);

    // Trừ tồn kho
    $detail->decrement('quantity', $item['quantity']);
}


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        // Xóa giỏ hàng
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

        // Thanh toán
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

        $detailId = $request->input('product_detail_id'); // 🔑 đồng bộ với cart
        $detail   = $detailId ? ProductDetail::find($detailId) : null;

        $item = [
            'id'                => $product->id,
            'product_detail_id' => $detail?->id,
            'name'              => $product->name,
            'price'             => $detail?->price ?? $product->price,
            'quantity'          => $quantity,
            'color'             => $detail?->color,
            'size'              => $detail?->size,
            'material'          => $product->material,
            'image'             => $product->image ?? '',
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
            'payment_status' => 'unpaid',
            'status' => 'processing',
        ]);

        return view('customer.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('customer.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function cancel($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        DB::beginTransaction();
        try {
            foreach ($order->items as $item) {
                if ($item->product_detail_id) {
                    $detail = ProductDetail::lockForUpdate()->find($item->product_detail_id);
                    if ($detail) {
                        $detail->increment('quantity', $item->quantity);
                    }
                }
            }

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

    public function history()
    {
        $histories = UserHistory::where('user_id', auth()->id())
            ->whereNotNull('order_id')
            ->with(['product', 'order', 'coupon'])
            ->orderByDesc('used_at')
            ->paginate(10);

        return view('customer.history.index', compact('histories'));
    }
}