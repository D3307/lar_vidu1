<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        //Lấy tất cả sản phẩm
        $products = Product::paginate(6);

        //Lấy tất cả danh mục sản phẩm
        $categories = Category::all();

        // Giả sử view hiển thị danh sách sản phẩm là resources/views/customer/products.blade.php
        return view('customer.products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Tách dữ liệu từ chuỗi trong DB thành mảng
        $sizes     = $product->size ? explode(',', $product->size) : [];
        $colors    = $product->color ? explode(',', $product->color) : [];
        $materials = $product->material ? explode(',', $product->material) : [];

        return view('customer.product_detail', compact('product', 'sizes', 'colors', 'materials'));
    }

    // Lọc sản phẩm theo category_id
    public function category($id)
    {
        $categories = Category::all();

        $category = Category::findOrFail($id);

        $products = Product::where('category_id', $id)->paginate(3);

        return view('customer.products', compact('products', 'categories', 'category'));
    }

    //Tìm  kiếm sản phẩm theo tên
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        $products = Product::query()
            ->where('name', 'LIKE', "%{$keyword}%")
            ->get();

        return view('customer.search', compact('products', 'keyword'));
    }
}