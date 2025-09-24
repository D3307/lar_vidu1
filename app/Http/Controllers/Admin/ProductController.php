<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy cả inventory kèm category
        $query = Product::with(['category', 'inventory']);

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
            'name'        => 'required|string|max:255',
            'price'       => 'nullable|numeric',
            'material'    => 'nullable|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
        ]);

        // Upload ảnh
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        $product = Product::create($data);

        // Inventory mặc định
        Inventory::create([
            'product_id' => $product->id,
            'quantity'   => $request->quantity ?? 0,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Sản phẩm đã được tạo.',
                'data'    => $product->load('category', 'inventory')
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo.');
    }

    public function show(Product $product)
    {
        $product->load('inventory');
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('inventory')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('inventory')->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'material' => 'nullable|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'quantity' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        $product->update($data);

        if ($product->inventory) {
            $product->inventory->update(['quantity' => $data['quantity'] ?? $product->inventory->quantity]);
        } else {
            Inventory::create([
                'product_id' => $product->id,
                'quantity'   => $data['quantity'] ?? 0,
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Sản phẩm đã được cập nhật.',
                'data'    => $product->load('category', 'inventory')
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy(Product $product, Request $request)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->inventory) {
            $product->inventory->delete();
        }

        $product->delete();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Xóa sản phẩm thành công.'
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}