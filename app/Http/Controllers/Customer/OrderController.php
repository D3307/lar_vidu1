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

        $discount = session('discount', 0);
        $finalTotal = $total - $discount;

        return view('customer.cart.checkout', compact('cart', 'total', 'user', 'selected', 'coupons', 'discount', 'finalTotal'));
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
            'coupon_id'=> 'nullable|exists:coupons,id'
        ]);

        $sessionCart = session('cart', []);
        $selected = $request->input('selected', []);
        $buyNow = session('buy_now', null);

        if ($buyNow) {
            $cartItems = ['buy_now' => $buyNow];
        } elseif (!empty($selected)) {
            $cartItems = [];
            foreach ($selected as $key) {
                if (isset($sessionCart[$key])) $cartItems[$key] = $sessionCart[$key];
            }
            if (empty($cartItems)) return redirect()->back()->with('error','Không có sản phẩm hợp lệ để đặt hàng.');
        } else {
            $cartItems = $sessionCart;
            if (empty($cartItems)) return redirect()->route('cart.index')->with('error','Giỏ hàng trống!');
        }

        $total = collect($cartItems)->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1));

        // xử lý coupon
        $coupon = null;
        $discount = 0;
        if ($request->filled('coupon_id')) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon) {
                $discount = $coupon->value ?? 0;
            }
        }

        $finalTotal = $total - $discount;

        $order = Order::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'total'   => $finalTotal,
            'status'  => 'pending', // luôn bắt đầu bằng pending
            'payment_method' => $request->payment,
            'payment_status' => 'pending',
            'coupon_id' => $coupon?->id
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'] ?? null,
                'quantity'   => $item['quantity'] ?? 1,
                'price'      => $item['price'] ?? 0,
                'color'      => $item['color'] ?? null,
                'size'       => $item['size'] ?? null,
            ]);

            // Lưu lịch sử mua sản phẩm
            UserHistory::create([
                'user_id'    => Auth::id(),
                'order_id'   => $order->id,
                'product_id' => $item['id'] ?? null,
                'action_type'=> 'buy_product',
                'used_at'    => now(),
            ]);
        }

        // Lưu lịch sử dùng coupon (nếu có)
        if ($coupon) {
            UserHistory::create([
                'user_id'   => Auth::id(),
                'order_id'  => $order->id,
                'coupon_id' => $coupon->id,
                'discount'  => $discount,
                'used_at'   => now(),
            ]);
        }

        // clear giỏ hàng
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
            // Chỉ tạo đơn, chưa đánh dấu paid
            return redirect()->route('orders.index')
                ->with('success', 'Đặt hàng thành công! Vui lòng thanh toán khi nhận hàng.');
        } else {
            // Thanh toán qua Momo
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
            'payment_status' => 'pending', // vẫn để pending cho COD
            'status' => 'processing',
        ]);

        return view('customer.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->orderByDesc('created_at')->paginate(5);

        return view('customer.orders.index', compact('orders'));
    }

    //Hủy đơn hàng
    public function cancel($id) {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        $order->update(['status' => 'canceled']);

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    //Lịch sử mua hàng
    public function history() {
        $histories = \App\Models\UserHistory::where('user_id', auth()->id())
            ->with(['product', 'order', 'coupon'])
            ->orderByDesc('used_at')
            ->paginate(10);

        return view('customer.history.index', compact('histories'));
    }
}