<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'import');

        $transactions = Transaction::with('details.inventory.product')
            ->where('type', $type)
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions', 'type'));
    }

    public function create()
    {
        $inventories = Inventory::with('product')->get();
        return view('admin.transactions.create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:import,export',
            'details' => 'required|array',
            'details.*.inventory_id' => 'required|exists:inventories,id',
            'details.*.quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        // Tạo phiếu nhập/xuất
        $transaction = Transaction::create([
            'type' => $request->type,
            'note' => $request->note,
        ]);

        foreach ($request->details as $detail) {
            $inventory = Inventory::with('product')->findOrFail($detail['inventory_id']);
            $quantity = $detail['quantity'];

            // Tạo chi tiết phiếu
            $transaction->details()->create([
                'inventory_id' => $inventory->id,
                'quantity' => $quantity,
            ]);

            // === Logic cập nhật tồn kho & sản phẩm ===
            if ($request->type === 'import') {
                // Nhập kho → tăng tồn + tăng số lượng sản phẩm
                $inventory->increment('quantity', $quantity);
                $inventory->product->increment('quantity', $quantity);
            } else {
                // Xuất kho → giảm tồn + giảm số lượng sản phẩm
                if ($inventory->quantity < $quantity) {
                    return back()->with('error', "Không đủ tồn kho cho sản phẩm {$inventory->product->name}");
                }

                $inventory->decrement('quantity', $quantity);
                $inventory->product->decrement('quantity', $quantity);
            }
        }

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Tạo phiếu ' . ($transaction->type === 'import' ? 'nhập' : 'xuất') . ' thành công');
    }

    public function show($id)
    {
        $transaction = Transaction::with('details.inventory.product')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }
}