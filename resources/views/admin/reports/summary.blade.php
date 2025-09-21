@extends('admin.layout')

@section('title','Báo cáo thống kê (chi tiết)')

@section('page-header')
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <p style="color:#555; font-size:0.95rem;">
                Danh sách số liệu tổng hợp theo ngày, tháng, năm và theo danh mục
            </p>
        </div>
        <div>
            <a href="{{ route('admin.reports.exportExcel') }}" 
               class="btn-export" 
               style="background:#7a2f3b; color:#fff; padding:10px 18px; border-radius:8px; text-decoration:none; font-size:0.95rem; font-weight:600;">
               <i class="fa fa-file-excel me-1"></i> Xuất file
            </a>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .btn-export:hover {
            background:#5a1f2b;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        }
        .report-table th, .report-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .report-table th {
            background: #7a2f3b;
            color: #fff;
            font-weight: 600;
        }
        .report-table tr:hover td {
            background: #fafafa;
        }
        .section-title {
            margin: 28px 0 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #7a2f3b;
        }
    </style>

    <!-- Số liệu tổng quan -->
    <h3 class="section-title">📌 Số liệu tổng quan</h3>
    <table class="report-table">
        <tr>
            <th>Chỉ số</th>
            <th>Giá trị</th>
        </tr>
        <tr>
            <td>Tổng số đơn hàng</td>
            <td>{{ $totalOrders ?? 0 }}</td>
        </tr>
        <tr>
            <td>Tổng số khách hàng</td>
            <td>{{ $totalCustomers ?? 0 }}</td>
        </tr>
    </table>

    <!-- Doanh thu theo ngày -->
    <h3 class="section-title">📅 Doanh thu theo ngày</h3>
    <table class="report-table">
        <tr>
            <th>Ngày</th>
            <th>Doanh thu</th>
        </tr>
        @foreach($dayLabels as $i => $day)
        <tr>
            <td>{{ $day }}</td>
            <td>{{ number_format($dayValues[$i]) }} đ</td>
        </tr>
        @endforeach
    </table>

    <!-- Doanh thu theo tháng -->
    <h3 class="section-title">📆 Doanh thu theo tháng</h3>
    <table class="report-table">
        <tr>
            <th>Tháng</th>
            <th>Doanh thu</th>
        </tr>
        @foreach($monthLabels as $i => $month)
        <tr>
            <td>{{ $month }}</td>
            <td>{{ number_format($monthValues[$i]) }} đ</td>
        </tr>
        @endforeach
    </table>

    <!-- Doanh thu theo năm -->
    <h3 class="section-title">📊 Doanh thu theo năm</h3>
    <table class="report-table">
        <tr>
            <th>Năm</th>
            <th>Doanh thu</th>
        </tr>
        @foreach($yearLabels as $i => $year)
        <tr>
            <td>{{ $year }}</td>
            <td>{{ number_format($yearValues[$i]) }} đ</td>
        </tr>
        @endforeach
    </table>

    <!-- Doanh thu theo danh mục -->
    <h3 class="section-title">📂 Doanh thu theo danh mục</h3>
    <table class="report-table">
        <tr>
            <th>Danh mục</th>
            <th>Doanh thu</th>
        </tr>
        @foreach($revenueByCategory as $cat)
        <tr>
            <td>{{ $cat->category_name }}</td>
            <td>{{ number_format($cat->total_revenue) }} đ</td>
        </tr>
        @endforeach
    </table>
@endsection
