<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'color' => 'required|string|max:100',
            'size' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        // Thêm product_id từ URL parameter
        $data['product_id'] = $product->id;

        $detail = ProductDetail::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm chi tiết sản phẩm!',
            'data' => $detail
        ]);
    }

    public function addDetail(Request $request, Product $product)
    {
        try {
            $request->validate([
                'color' => 'required|string|max:255',
                'size' => 'required|string|max:10',
                'quantity' => 'required|integer|min:0'
            ]);

            $product->details()->create([
                'color' => $request->color,
                'size' => $request->size,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thêm chi tiết thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, ProductDetail $detail)
    {
        $data = $request->validate([
            'color' => 'required|string|max:100',
            'size' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        $detail->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật chi tiết sản phẩm.',
            'detail' => $detail
        ]);
    }

    public function updateDetail(Request $request, ProductDetail $detail)
    {
        try {
            $request->validate([
                'color' => 'required|string|max:255',
                'size' => 'required|string|max:10',
                'quantity' => 'required|integer|min:0'
            ]);

            $detail->update([
                'color' => $request->color,
                'size' => $request->size,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(ProductDetail $detail)
    {
        $detail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa chi tiết sản phẩm.'
        ]);
    }

    public function deleteDetail(ProductDetail $detail)
    {
        try {
            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}