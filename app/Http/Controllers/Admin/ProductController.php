<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        $products = $query->paginate(10);

        if ($request->ajax()) {
            return view('admin.products.partials', compact('products'))->render();
        }

        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Vui lòng tạo ít nhất 1 danh mục trước khi thêm sản phẩm.');
        }

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer|min:0',
            'size' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:150',
            'color' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Lấy tên file gốc và thêm timestamp để tránh trùng
            $originalName = $request->file('image')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        $data['quantity'] = $data['quantity'] ?? 0;
        $data['category_id'] = (int) $data['category_id'];

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer|min:0',
            'size' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:150',
            'color' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // Lấy tên file gốc và thêm timestamp để tránh trùng
            $originalName = $request->file('image')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        $data['quantity'] = $data['quantity'] ?? ($product->quantity ?? 0);
        if (isset($data['category_id'])) {
            $data['category_id'] = (int) $data['category_id'];
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy(Product $product)
    {
        // Xóa ảnh kèm theo (nếu có)
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
