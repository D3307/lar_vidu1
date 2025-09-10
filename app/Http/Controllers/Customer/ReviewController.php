<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id'=> 'required|exists:orders,id'
        ]);

        // kiểm tra đơn hàng có thuộc về user và đã giao chưa
        $order = Order::where('id', $request->order_id)
                      ->where('user_id', auth()->id())
                      ->where('status', 'delivered') // chỉ khi đã giao
                      ->first();

        if (!$order) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã được giao.');
        }

        Review::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'order_id'   => $order->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        // trả về trang đơn hàng
        return redirect()->route('customer.orders.index', $order->id) ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');    
    }
}