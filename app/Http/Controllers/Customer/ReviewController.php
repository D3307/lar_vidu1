<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // Hiển thị form đánh giá
    public function create(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            return redirect()->route('orders.index')
                ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã được giao.');
        }

        // Lấy danh sách sản phẩm và ảnh đầu tiên của sản phẩm
        $items = $order->items()->with('product')->get();

        return view('customer.review', compact('order', 'items'));
    }

    // ✅ Lưu đánh giá, kèm upload ảnh và video
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            return redirect()->route('orders.index')
                ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã được giao.');
        }

        $data = $request->input('reviews', []);

        foreach ($data as $productId => $reviewData) {
            if (empty($reviewData['rating'])) {
                continue;
            }

            // ✅ Lưu hoặc cập nhật đánh giá
            $review = Review::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'user_id' => auth()->id(),
                ],
                [
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'] ?? null,
                ]
            );

            // ✅ Xử lý upload file (ảnh hoặc video)
            if ($request->hasFile("reviews.$productId.media")) {
                foreach ($request->file("reviews.$productId.media") as $file) {
                    if ($file->isValid()) {
                        // Lưu file vào thư mục storage/app/public/reviews
                        $path = $file->store('reviews', 'public');

                        // Lưu đường dẫn file vào cột media (JSON)
                        $existingMedia = $review->media ? json_decode($review->media, true) : [];
                        $existingMedia[] = Storage::url($path);
                        $review->media = json_encode($existingMedia);
                        $review->save();
                    }
                }
            }
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Cảm ơn bạn đã đánh giá các sản phẩm!');
    }
}