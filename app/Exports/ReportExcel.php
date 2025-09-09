<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;

class ReportExcel implements FromArray
{
    public function array(): array
    {
        $rows = [];

        // ================= SỐ LIỆU TỔNG QUAN =================
        $totalOrders    = Order::count();
        $totalCustomers = Order::distinct('user_id')->count('user_id');

        $rows[] = ['📌 Số liệu tổng quan'];
        $rows[] = ['Chỉ số', 'Giá trị'];
        $rows[] = ['Tổng số đơn hàng', $totalOrders];
        $rows[] = ['Tổng số khách hàng', $totalCustomers];
        $rows[] = []; // dòng trống


        // ================= DOANH THU THEO NGÀY =================
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

        $rows[] = ['📅 Doanh thu theo ngày (7 ngày gần nhất)'];
        $rows[] = ['Ngày', 'Doanh thu'];
        foreach ($days as $date => $revenue) {
            $rows[] = [$date, $revenue];
        }
        $rows[] = [];


        // ================= DOANH THU THEO THÁNG =================
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

        $rows[] = ['📆 Doanh thu theo tháng ('.now()->year.')'];
        $rows[] = ['Tháng', 'Doanh thu'];
        foreach ($months as $month => $revenue) {
            $rows[] = ['Tháng '.$month, $revenue];
        }
        $rows[] = [];


        // ================= DOANH THU THEO NĂM =================
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

        $rows[] = ['📊 Doanh thu theo năm'];
        $rows[] = ['Năm', 'Doanh thu'];
        foreach ($years as $year => $revenue) {
            $rows[] = [$year, $revenue];
        }
        $rows[] = [];


        // ================= DOANH THU THEO DANH MỤC =================
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

        $rows[] = ['📂 Doanh thu theo danh mục'];
        $rows[] = ['Danh mục', 'Doanh thu'];
        foreach ($revenueByCategory as $cat) {
            $rows[] = [$cat->category_name, $cat->total_revenue];
        }

        return $rows;
    }
}