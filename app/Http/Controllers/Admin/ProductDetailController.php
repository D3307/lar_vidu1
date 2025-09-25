<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductDetailController extends Controller
{
    public function addDetail(Request $request, Product $product) {
        $request->validate([
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'quantity' => 'required|integer|min:0'
        ]);

        $product->details()->create($request->only('color','size','quantity'));

        return response()->json(['success' => true, 'message' => 'Thêm chi tiết thành công!']);
    }

    public function updateDetail(Request $request, ProductDetail $detail) {
        $request->validate([
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'quantity' => 'required|integer|min:0'
        ]);

        $detail->update($request->only('color','size','quantity'));

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công!']);
    }

    public function deleteDetail(ProductDetail $detail) {
        $detail->delete();

        return response()->json(['success' => true, 'message' => 'Xóa thành công!']);
    }
}