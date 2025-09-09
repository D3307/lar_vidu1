@extends('admin.layout')

@section('title','Dashboard')

@section('content')
<style>
    .stats-card {
        background: linear-gradient(135deg, #fff, #f9f9ff);
        border: 1px solid #e5e5e5;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        transition: 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stats-card h3 {
        font-size: 18px;
        margin-bottom: 6px;
        color: #666;
    }
    .stats-card p {
        font-size: 26px;
        font-weight: bold;
        color: #2c2c54;
    }
    .stats-card .icon {
        font-size: 30px;
        margin-bottom: 8px;
    }
    .chart-box {
        background: #fff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        margin-top: 25px;
    }
</style>

<div class="grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
    <div class="stats-card">
        <div class="icon">👥</div>
        <h3>Người dùng</h3>
        <p>1,245</p>
    </div>
    <div class="stats-card">
        <div class="icon">📦</div>
        <h3>Đơn hàng</h3>
        <p>350</p>
    </div>
    <div class="stats-card">
        <div class="icon">💰</div>
        <h3>Doanh thu</h3>
        <p>120,500,000đ</p>
    </div>
    <div class="stats-card">
        <div class="icon">📊</div>
        <h3>Thống kê</h3>
        <p>72%</p>
    </div>
</div>

<div class="chart-box">
    <h3 style="margin-bottom:15px; font-weight:bold; color:#444;">Biểu đồ doanh thu</h3>
    {{-- Gọi view chứa biểu đồ (chỉ body, không layout) --}}
    <div>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4"],
                datasets: [{
                    label: 'Doanh thu',
                    data: [12000000, 15000000, 18000000, 22000000],
                    borderColor: '#e63946',
                    backgroundColor: 'rgba(230,57,70,0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true, position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</div>
@endsection
