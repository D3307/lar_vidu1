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
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'size' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:150',
            'color' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'quantity' => 'nullable|integer|min:0',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        $data['category_id'] = (int) $data['category_id'];

        // Tạo sản phẩm
        $product = Product::create($data);

        // Tạo inventory kèm theo
        Inventory::create([
            'product_id' => $product->id,
            'quantity'   => $data['quantity'] ?? 0,
            'location'   => null,
        ]);

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
            'size' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:150',
            'color' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'quantity' => 'nullable|integer|min:0',
        ]);

        // Cập nhật ảnh
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $originalName = $request->file('image')->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'public');
        }

        if (isset($data['category_id'])) {
            $data['category_id'] = (int) $data['category_id'];
        }

        // Cập nhật sản phẩm
        $product->update($data);

        // Cập nhật inventory
        if ($product->inventory) {
            $product->inventory->update([
                'quantity' => $data['quantity'] ?? $product->inventory->quantity,
            ]);
        } else {
            // Nếu chưa có thì tạo mới
            Inventory::create([
                'product_id' => $product->id,
                'quantity'   => $data['quantity'] ?? 0,
                'location'   => null,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy(Product $product)
    {
        // Xóa ảnh
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Xóa inventory kèm theo
        if ($product->inventory) {
            $product->inventory->delete();
        }

        // Xóa sản phẩm
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}