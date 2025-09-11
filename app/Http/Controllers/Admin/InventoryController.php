<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('product')->paginate(6);
        return view('admin.inventories.index', compact('inventories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        Inventory::create($request->all());
        return redirect()->route('admin.inventories.index')->with('success', 'Thêm tồn kho thành công');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $products = Product::all();
        return view('admin.inventories.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());

        return redirect()->route('admin.inventories.index')->with('success', 'Cập nhật tồn kho thành công');
    }

    public function destroy($id)
    {
        Inventory::destroy($id);
        return redirect()->route('admin.inventories.index')->with('success', 'Xóa tồn kho thành công');
    }
}