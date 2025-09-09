@extends('admin.layout')

@section('title','Báo cáo thống kê')

@section('page-header')
    <p style="color:#555; font-size:0.95rem;">Tổng hợp số liệu bán hàng và hiệu suất hoạt động</p>
@endsection

@section('content')
    <style>
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px,1fr));
            gap: 24px;
        }
        .report-card {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            border: 1px solid rgba(122,47,59,0.08);
        }
        .report-card h3 {
            margin-bottom: 12px;
            font-size: 1.1rem;
            color: #7a2f3b;
            text-align: center;
        }
        canvas {
            width: 100% !important;
            height: 320px !important;
        }
        select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
    </style>

    <!-- Nút xuất PDF -->
    <form id="exportForm" action="{{ route('admin.reports.exportPdf') }}" method="POST">
        @csrf
        <input type="hidden" name="charts[]" id="chart_category">
        <input type="hidden" name="charts[]" id="chart_payment">
        <input type="hidden" name="charts[]" id="chart_period">
        <button type="button" onclick="exportCharts()" 
            style="margin-bottom:20px; padding:10px 16px; background:#7a2f3b; color:#fff; border:none; border-radius:6px; cursor:pointer;">
            📄 Xuất PDF
        </button>
    </form>

    <!-- Thống kê nhanh -->
    <div class="report-grid">
        <div class="report-card">
            <h3>Tổng số đơn hàng</h3>
            <div class="report-value" style="font-size:2rem; text-align:center; font-weight:bold; color:#333;">
                {{ $totalOrders ?? 0 }}
            </div>
        </div>
        <div class="report-card">
            <h3>Tổng số khách hàng</h3>
            <div class="report-value" style="font-size:2rem; text-align:center; font-weight:bold; color:#333;">
                {{ $totalCustomers ?? 0 }}
            </div>
        </div>
    </div>

    <!-- Các biểu đồ -->
    <div class="report-grid" style="margin-top:24px;">
        <div class="report-card">
            <h3>Doanh thu theo danh mục</h3>
            <canvas id="categoryRevenueChart"></canvas>
        </div>
        <div class="report-card">
            <h3>Doanh thu theo phương thức thanh toán</h3>
            <canvas id="revenueByPaymentMethodChart"></canvas>
        </div>
    </div>

    <!-- Biểu đồ doanh thu gộp (Ngày/Tháng/Năm) -->
    <div class="report-grid" style="margin-top:24px;">
        <div class="report-card">
            <h3>Doanh thu theo thời gian</h3>
            <select id="timeSelect">
                <option value="day">Theo ngày</option>
                <option value="month">Theo tháng</option>
                <option value="year">Theo năm</option>
            </select>
            <canvas id="revenueByPeriodChart"></canvas>
        </div>
    </div>

    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ==============================
        // Doanh thu theo danh mục (Bar)
        // ==============================
        const categoryChart = new Chart(document.getElementById('categoryRevenueChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueByCategory->pluck('category_name')) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($revenueByCategory->pluck('total_revenue')) !!},
                    backgroundColor: '#7a2f3b'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        // ==============================
        // Doanh thu theo phương thức thanh toán (Pie)
        // ==============================
        const paymentChart = new Chart(document.getElementById('revenueByPaymentMethodChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($revenueByPaymentMethod->pluck('payment_method')) !!},
                datasets: [{
                    data: {!! json_encode($revenueByPaymentMethod->pluck('total_revenue')) !!},
                    backgroundColor: ['#7a2f3b','#d67a8c','#f1b6b8','#8ec5fc','#aaa']
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        // ==============================
        // Doanh thu theo ngày / tháng / năm (chung 1 chart)
        // ==============================
        const ctxPeriod = document.getElementById('revenueByPeriodChart').getContext('2d');
        let periodChart; // chart toàn cục

        function renderPeriodChart(type) {
            // Nếu chart cũ tồn tại thì xóa đi
            if (periodChart) {
                periodChart.destroy();
            }

            let labels = [];
            let data = [];
            let chartType = 'bar';
            let label = '';
            let backgroundColor = '#7a2f3b';
            let borderColor = '#7a2f3b';

            if (type === 'day') {
                labels = {!! json_encode($dayLabels) !!};
                data = {!! json_encode($dayValues) !!};
                chartType = 'line';
                label = 'Doanh thu theo ngày';
                backgroundColor = 'rgba(122,47,59,0.2)';
                borderColor = '#7a2f3b';
            } else if (type === 'month') {
                labels = {!! json_encode($monthLabels) !!};
                data = {!! json_encode($monthValues) !!};
                chartType = 'bar';
                label = 'Doanh thu theo tháng';
                backgroundColor = '#8ec5fc';
            } else {
                labels = {!! json_encode($yearLabels) !!};
                data = {!! json_encode($yearValues) !!};
                chartType = 'bar';
                label = 'Doanh thu theo năm';
                backgroundColor = '#d67a8c';
            }

            periodChart = new Chart(ctxPeriod, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 2,
                        tension: 0.3 // chỉ áp dụng cho line
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } }
                }
            });
        }

        // Mặc định load theo ngày
        renderPeriodChart('day');

        // Khi select thay đổi thì render lại chart
        document.getElementById('timeSelect').addEventListener('change', function() {
            renderPeriodChart(this.value);
        });

            // Hàm cập nhật chart khi chọn Day/Month/Year
            document.getElementById('timeSelect').addEventListener('change', function() {
                let type = this.value;
                if (type === 'day') {
                    periodChart.data.labels = {!! json_encode($dayLabels) !!};
                    periodChart.data.datasets[0].data = {!! json_encode($dayValues) !!};
                    periodChart.data.datasets[0].label = 'Doanh thu theo ngày';
                    periodChart.data.datasets[0].backgroundColor = '#d67a8c';
                } else if (type === 'month') {
                    periodChart.data.labels = {!! json_encode($monthLabels) !!};
                    periodChart.data.datasets[0].data = {!! json_encode($monthValues) !!};
                    periodChart.data.datasets[0].label = 'Doanh thu theo tháng';
                    periodChart.data.datasets[0].backgroundColor = '#8ec5fc';
                } else {
                    periodChart.data.labels = {!! json_encode($yearLabels) !!};
                    periodChart.data.datasets[0].data = {!! json_encode($yearValues) !!};
                    periodChart.data.datasets[0].label = 'Doanh thu theo năm';
                    periodChart.data.datasets[0].backgroundColor = '#7a2f3b';
                }
                periodChart.update();
            });

        // ==============================
        // Xuất PDF
        // ==============================
        function exportCharts() {
            document.getElementById('chart_category').value = document.getElementById('categoryRevenueChart').toDataURL();
            document.getElementById('chart_payment').value = document.getElementById('revenueByPaymentMethodChart').toDataURL();
            document.getElementById('chart_period').value = document.getElementById('revenueByPeriodChart').toDataURL();

            document.getElementById('exportForm').submit();
        }
    </script>
@endsection
