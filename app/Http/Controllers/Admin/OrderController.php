<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));

            $query->where(function ($q) use ($keyword) {
                // Tìm theo mã đơn hàng (id)
                $q->where('id', $keyword)
                ->orWhere('id', 'like', "%{$keyword}%")

                // Tìm theo thông tin trực tiếp trong bảng orders
                ->orWhere('name', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        $orders = $query->paginate(6);

        return view('admin.orders.orders', compact('orders'));
    }


    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('admin.orders.orderdetail', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,packed,shipping,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Xác nhận đơn hàng
     */
    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'processing';
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận!');
    }

    /**
     * Hủy đơn hàng
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã bị hủy!');
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if ($order->items()->exists()) {
            $order->items()->delete();
        }

        $order->delete();

        return redirect()->route('admin.orders.orders')->with('success', 'Đã xóa đơn hàng thành công.');
    }

    /**
     * Xuất hóa đơn đơn hàng
     */
    public function invoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Tạo mã vận đơn (có thể sinh random hoặc lấy từ DB)
        $trackingCode = 'SPX' . strtoupper(uniqid());

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.invoice', compact('order', 'trackingCode'))->setPaper([0, 0, 288, 432], 'portrait'); 
        return $pdf->download("invoice-order-{$order->id}.pdf");
    }
}