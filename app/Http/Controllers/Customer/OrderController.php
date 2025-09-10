<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // nếu bạn có model Product
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Kiểm tra quyền xem đơn hàng
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.orders.show', compact('order'));
    }

    // Hiển thị form checkout (GET)
    public function showCheckoutForm(Request $request)
    {
        $sessionCart = session('cart', []);
        $selectedKeys = $request->query('selected', []); // từ cart index gửi bằng GET
        $buyNow = session('buy_now', null);

        if ($buyNow) {
            // mua ngay: chỉ 1 item từ session
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

        return view('customer.cart.checkout', compact('cart', 'total', 'user', 'selected'));
    }

    // POST: tạo order từ các item được chọn hoặc buy_now
    public function checkout(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'payment'  => 'required|string|in:cod,momo',
            'selected' => 'nullable|array',
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

        $order = Order::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'total'   => $total,
            'status'  => 'pending',
            'payment_method' => $request->payment,
            'payment_status' => 'pending'
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
        }

        // Xóa item đã đặt: nếu mua ngay thì forget buy_now, nếu selected thì unset keys từ session cart, nếu không thì forget cart
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
            $order->update(['payment_method' => 'cod','payment_status' => 'paid','status'=>'Processing']);
            return view('customer.success', compact('order'));
        } else {
            // momo xử lý chuyển tiếp tới thanh toán momo
            return redirect()->route('payment.momo', ['order' => $order->id]);
        }
    }

    // Mua ngay: lưu item vào session 'buy_now' rồi chuyển tới checkout form
    public function buyNow(Request $request, $id)
    {
        // ví dụ lấy product từ DB
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'image' => $product->image ?? '',
            // thêm color/size nếu có
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
            'payment_status' => 'paid',
            'status' => 'Processing',
        ]);

        return view('customer.success', compact('order'));
    }

    public function index()
    {
        // Lấy các đơn của user hiện tại, mới nhất trước, phân trang
        $orders = Order::where('user_id', auth()->id())->orderByDesc('created_at')->paginate(5);

        return view('customer.orders.index', compact('orders'));
    }
}
