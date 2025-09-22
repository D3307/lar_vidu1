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
            'items' => 'required|array|min:1', // Đổi từ details thành items
            'items.*.inventory_id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Tạo phiếu nhập/xuất
            $transaction = Transaction::create([
                'type' => $request->type,
                'note' => $request->note,
            ]);

            foreach ($request->items as $item) { // Đổi từ details thành items
                $inventory = Inventory::with('product')->findOrFail($item['inventory_id']);
                $quantity = $item['quantity'];

                // Kiểm tra tồn kho trước khi xuất
                if ($request->type === 'export' && $inventory->quantity < $quantity) {
                    throw new \Exception("Không đủ tồn kho cho sản phẩm {$inventory->product->name}. Tồn: {$inventory->quantity}, yêu cầu: {$quantity}");
                }

                // Tạo chi tiết phiếu
                $transaction->details()->create([
                    'inventory_id' => $inventory->id,
                    'quantity' => $quantity,
                ]);

                // Cập nhật tồn kho
                if ($request->type === 'import') {
                    $inventory->increment('quantity', $quantity);
                    $inventory->product->increment('quantity', $quantity);
                } else {
                    $inventory->decrement('quantity', $quantity);
                    $inventory->product->decrement('quantity', $quantity);
                }
            }

            DB::commit();
            return redirect()->route('admin.transactions.index', ['type' => $request->type])
                ->with('success', 'Tạo phiếu ' . ($transaction->type === 'import' ? 'nhập' : 'xuất') . ' thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with('details.inventory.product')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }
}