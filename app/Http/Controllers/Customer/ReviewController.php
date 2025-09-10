<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    // Hiển thị form đánh giá
    public function create(Order $order)
    {
        // Chỉ cho phép xem form khi đơn hàng thuộc về user và đã giao
        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            return redirect()->route('orders.index')
                             ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã được giao.');
        }

        return view('customer.review', compact('order'));
    }

    // Lưu đánh giá
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra đơn hàng hợp lệ
        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            return redirect()->route('orders.index')
                             ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã được giao.');
        }

        // Với mỗi sản phẩm trong đơn hàng có thể đánh giá (giả sử đơn hàng có nhiều sản phẩm)
        foreach ($order->products as $product) {
            Review::create([
                'product_id' => $product->id,
                'user_id'    => auth()->id(),
                'order_id'   => $order->id,
                'rating'     => $request->rating,
                'comment'    => $request->comment,
            ]);
        }

        return redirect()->route('orders.index')
                         ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}