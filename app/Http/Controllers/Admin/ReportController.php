<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Review;

class ReportController extends Controller
{
    //Báo cáo bằng biểu đồ
    public function index()
    {
        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng (distinct theo user_id)
        $totalCustomers = Order::distinct('user_id')->count('user_id');

        // Tổng số đánh giá
        $totalReviews = Review::count();

        // ==============================
        // Doanh thu theo danh mục (Bar)
        // ==============================
        $revenueByCategory = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('categories.name')
            ->get();

        // ==============================
        // Doanh thu theo ngày (Line)
        // ==============================
        $startDate = now()->subDays(6)->startOfDay();
        $endDate   = now()->endOfDay();

        $days = [];
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $days[$current->format('Y-m-d')] = 0;
            $current->addDay();
        }

        $revenueByDate = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total_revenue', 'date')
            ->toArray();

        foreach ($revenueByDate as $date => $revenue) {
            $days[$date] = $revenue;
        }

        $dayLabels = array_keys($days);
        $dayValues = array_values($days);

        // ==============================
        // Doanh thu theo tháng (Bar)
        // ==============================
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = 0;
        }

        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total_revenue', 'month')
            ->toArray();

        foreach ($revenueByMonth as $m => $revenue) {
            $months[(int)$m] = $revenue;
        }

        $monthLabels = array_map(fn($m) => 'Tháng ' . $m, array_keys($months));
        $monthValues = array_values($months);

        // ==============================
        // Doanh thu theo năm (Bar)
        // ==============================
        $firstYear = Order::select(DB::raw('MIN(YEAR(created_at)) as year'))->value('year') ?? now()->year;
        $lastYear  = now()->year;
        $years = [];
        for ($y = $firstYear; $y <= $lastYear; $y++) {
            $years[$y] = 0;
        }

        $revenueByYear = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('year')
            ->pluck('total_revenue', 'year')
            ->toArray();

        foreach ($revenueByYear as $y => $revenue) {
            $years[(int)$y] = $revenue;
        }

        $yearLabels = array_keys($years);
        $yearValues = array_values($years);

        // ==============================
        // Doanh thu theo phương thức thanh toán (Pie)
        // ==============================
        $revenueByPaymentMethod = Order::select(
                'payment_method',
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('payment_method')
            ->get();

        // ==============================
        // Trả dữ liệu cho view
        // ==============================
        return view('admin.reports.index', compact(
            'totalOrders',
            'totalCustomers',
            'totalReviews', // thêm biến này

            // Category revenue (Bar)
            'revenueByCategory',

            // Revenue by date (Line)
            'dayLabels', 'dayValues',

            // Revenue by month (Bar)
            'monthLabels', 'monthValues',

            // Revenue by year (Bar)
            'yearLabels', 'yearValues',

            // Revenue by payment method (Pie)
            'revenueByPaymentMethod'
        ));
    }


    //Báo cáo xuất Excel
    public function exportExcel()
    {
        return Excel::download(new ReportExcel, 'baocaodulieu.xlsx');
    }


    //Báo cáo xuất PDF
    public function exportPdf(Request $request)
    {
        $charts = $request->input('charts', []);
        $pdf = Pdf::loadView('admin.reports.exportPdf', compact('charts'));
        return $pdf->download('baocao-bieudo.pdf');
    }


    //Báo cáo bằng dữ liệu
    public function summary()
    {
        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = Order::distinct('user_id')->count('user_id');

        // Doanh thu theo danh mục
        $revenueByCategory = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('categories.name')
            ->get();

        // Doanh thu theo ngày (7 ngày gần nhất)
        $startDate = now()->subDays(6)->startOfDay();
        $endDate   = now()->endOfDay();

        $days = [];
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $days[$current->format('Y-m-d')] = 0;
            $current->addDay();
        }

        $revenueByDate = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total_revenue', 'date')
            ->toArray();

        foreach ($revenueByDate as $date => $revenue) {
            $days[$date] = $revenue;
        }

        $dayLabels = array_keys($days);
        $dayValues = array_values($days);

        // Doanh thu theo tháng (12 tháng gần nhất)
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = 0;
        }

        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total_revenue', 'month')
            ->toArray();

        foreach ($revenueByMonth as $m => $revenue) {
            $months[(int)$m] = $revenue;
        }

        $monthLabels = array_map(function($m) {
            return 'Tháng ' . $m;
        }, array_keys($months));
        $monthValues = array_values($months);

        // Doanh thu theo năm
        $firstYear = Order::select(DB::raw('MIN(YEAR(created_at)) as year'))->value('year') ?? now()->year;
        $lastYear  = now()->year;
        $years = [];
        for ($y = $firstYear; $y <= $lastYear; $y++) {
            $years[$y] = 0;
        }

        $revenueByYear = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('year')
            ->pluck('total_revenue', 'year')
            ->toArray();

        foreach ($revenueByYear as $y => $revenue) {
            $years[(int)$y] = $revenue;
        }

        $yearLabels = array_keys($years);
        $yearValues = array_values($years);

        // Trả về view summary (toàn bảng)
        return view('admin.reports.summary', compact(
            'totalOrders',
            'totalCustomers',
            'dayLabels','dayValues',
            'monthLabels','monthValues',
            'yearLabels','yearValues',
            'revenueByCategory'
        ));
    }
}
