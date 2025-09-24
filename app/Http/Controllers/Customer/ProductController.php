<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\UserHistory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('reviews', 'details');

        // Nếu lọc theo danh mục
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo giá
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(6)->withQueryString();
        $categories = Category::all();

        return view('customer.products', compact('products', 'categories'))
            ->with('category', null);
    }

    public function show($id)
    {
        $product = Product::with('details')->findOrFail($id);

        // Lưu lịch sử duyệt sản phẩm nếu user đăng nhập
        if (auth()->check()) {
            UserHistory::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'action_type'     => 'view_product',
                'used_at'    => now(),
            ]);
        }

        // Biến thể
        $totalQuantity = $product->details->sum('quantity');
        $sizes = $product->details->pluck('size')->unique()->toArray();
        $colors = $product->details->pluck('color')->unique()->toArray();
        
        // Lấy danh sách biến thể (chi tiết sản phẩm)
        $variants = $product->details; // quan hệ hasMany trong model Product

        return view('customer.product_detail', compact('product', 'variants', 'totalQuantity', 'sizes', 'colors'));
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