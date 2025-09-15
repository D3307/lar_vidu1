<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('product');

        // Tìm kiếm trong bảng inventories
        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('id', 'like', "%{$keyword}%")
                    ->orWhereHas('product', function ($q2) use ($keyword) {
                        $q2->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $inventories = $query->paginate(10);

        return view('admin.inventories.index', compact('inventories'));
    }


    public function edit($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);
        return view('admin.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('admin.inventories.index')
                         ->with('success', 'Cập nhật số lượng tồn kho thành công');
    }
}