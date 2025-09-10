<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Danh sách đánh giá
    public function index()
    {
        $reviews = Review::with(['user','product','order'])->latest()->paginate(6);
        return view('admin.reviews.index', compact('reviews'));
    }

    // Chi tiết đánh giá
    public function show($id)
    {
        $review = Review::with(['user','product','order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    // Chỉnh sửa đánh giá (nếu cần)
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->only('rating','comment'));
        return redirect()->route('admin.reviews.index')->with('success','Cập nhật đánh giá thành công!');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success','Xóa đánh giá thành công!');
    }
}