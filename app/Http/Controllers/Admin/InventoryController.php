<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoriesExport;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('product');

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
        $inventory = Inventory::with(['product', 'stockMovements' => function($q) {
            $q->latest()->take(10);
        }])->findOrFail($id);

        return view('admin.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $inventory = Inventory::findOrFail($id);

        $oldQty = $inventory->quantity;
        $newQty = $request->quantity;
        $change = $newQty - $oldQty;

        $inventory->update([
            'quantity' => $newQty
        ]);

        if ($change != 0) {
            $type = $change > 0 ? 'import' : 'export';

            $inventory->stockMovements()->create([
                'type' => $type,
                'quantity' => abs($change),
                'note' => 'Cập nhật tồn kho thủ công'
            ]);
        }

        return redirect()->route('admin.inventories.index')
                        ->with('success', 'Cập nhật số lượng tồn kho thành công');
    }

    public function history($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);

        $movements = $inventory->stockMovements()
            ->latest()
            ->paginate(10);

        return view('admin.inventories.history', compact('inventory', 'movements'));
    }

    public function exportExcel()
    {
        return Excel::download(new InventoriesExport, 'inventories.xlsx');
    }

    // ==== Nhập kho ====
    public function import(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255'
        ]);

        $inventory->increment('quantity', $request->quantity);

        $inventory->stockMovements()->create([
            'type' => 'import',
            'quantity' => $request->quantity,
            'note' => $request->note ?? 'Nhập kho'
        ]);

        return back()->with('success', 'Nhập kho thành công');
    }

    // ==== Xuất kho ====
    public function export(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255'
        ]);

        if ($inventory->quantity < $request->quantity) {
            return back()->with('error', 'Số lượng tồn không đủ để xuất');
        }

        $inventory->decrement('quantity', $request->quantity);

        $inventory->stockMovements()->create([
            'type' => 'export',
            'quantity' => $request->quantity,
            'note' => $request->note ?? 'Xuất kho'
        ]);

        return back()->with('success', 'Xuất kho thành công');
    }
}