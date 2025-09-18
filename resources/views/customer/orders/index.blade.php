@extends('layouts.app')

@section('title', 'Danh sách đơn hàng')

@section('content')
<!-- Hiển thị thông báo -->
    @if(session('success') || session('error'))
        <div id="toast-message" class="custom-toast {{ session('success') ? 'success' : 'error' }}">
            <span class="icon">{{ session('success') ? '✔' : '⚠' }}</span>
            <span class="message">
                {{ session('success') ?? session('error') }}
            </span>
            <button class="close-btn" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
    
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color:#e75480;font-weight:700">Danh sách đơn hàng</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        @php
            // Các trạng thái + nhãn + màu
            $statuses = [
                'pending' => ['label' => 'Chờ xử lý', 'color' => '#f0ad4e'],   // vàng cam
                'processing' => ['label' => 'Đang xử lý', 'color' => '#0275d8'], // xanh dương
                'shipping' => ['label' => 'Đang giao', 'color' => '#6f42c1'],   // tím
                'delivered' => ['label' => 'Đã giao', 'color' => '#5cb85c'],   // xanh lá
                'cancelled' => ['label' => 'Đã hủy', 'color' => '#d9534f'],    // đỏ
            ];

            // Dùng allOrders nếu controller đã gửi (để tab/count dùng toàn bộ dữ liệu),
            // ngược lại dùng $orders (get() hoặc paginated collection).
            $sourceOrders = $allOrders ?? $orders;
            $groupedOrders = $sourceOrders->groupBy(fn($order) => $order->status ?? 'pending');
        @endphp

        <!-- Tabs trạng thái -->
        <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
            @foreach($statuses as $key => $data)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($loop->first) active @endif"
                            id="{{ $key }}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $key }}"
                            type="button"
                            role="tab"
                            aria-controls="{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $data['label'] }}
                        <span class="badge" style="background:{{ $data['color'] }};">
                            {{ count($groupedOrders[$key] ?? []) }}
                        </span>
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Nội dung các tab -->
        <div class="tab-content" id="orderTabsContent">
            @foreach($statuses as $key => $data)
                <div class="tab-pane fade @if($loop->first) show active @endif"
                    id="{{ $key }}"
                    role="tabpanel"
                    aria-labelledby="{{ $key }}-tab">

                    @if(empty($groupedOrders[$key]) || count($groupedOrders[$key]) === 0)
                        <div class="alert alert-light text-center">
                            Không có đơn hàng {{ strtolower($data['label']) }}.
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($groupedOrders[$key] as $order)
                                <div class="col-12">
                                    <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">
                                        <div class="card shadow-sm"
                                            style="border-left:6px solid {{ $data['color'] }}; border-radius:10px;">
                                            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                                                <div>
                                                    <div style="font-weight:700;color:#333;">#{{ $order->id }}</div>
                                                    <div class="text-muted" style="font-size:13px;">
                                                        Ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                    <div class="mt-1" style="font-size:13px;color:#666;">
                                                        Phương thức: <strong>{{ $order->payment_method ?? 'N/A' }}</strong>
                                                        &nbsp;·&nbsp;
                                                        Trạng thái:
                                                        <span style="font-weight:700; color:{{ $data['color'] }}">
                                                            {{ $data['label'] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="text-end ms-auto">
                                                    <div style="font-weight:800;font-size:18px;color:#222;">
                                                        {{ number_format($order->final_total ?? 0,0,',','.') }} đ
                                                    </div>

                                                    <div class="mt-2 d-flex flex-wrap gap-2 justify-content-end">
                                                        <span class="badge"
                                                            style="background:{{ $data['color'] }}20;
                                                                    color:{{ $data['color'] }};
                                                                    font-weight:700;
                                                                    padding:10px 10px;
                                                                    height: 35px;
                                                                    font-size:14px;
                                                                    border-radius:8px;">
                                                            Xem chi tiết →
                                                        </span>

                                                        @if(in_array($order->status, ['pending','processing']))
                                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng #{{ $order->id }} không?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn-cancel-order">
                                                                    Hủy đơn
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Phân trang -->
        @if($orders->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links('vendor.pagination.custom') }}
        </div>
        @endif
    @endif
</div>

<style>
    .custom-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ff6b88;
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-weight: 600;
        z-index: 9999;
        animation: slideIn 0.4s ease, fadeOut 0.5s ease 3s forwards;
    }
    .custom-toast .icon { font-size: 18px; }
    .custom-toast .message { flex-grow: 1; }
    .custom-toast .close-btn {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }
    .custom-toast.error { background: #d9534f; }

    @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes fadeOut { to { opacity: 0; transform: translateX(120%); } }
    .card:hover { transform: translateY(-4px); transition: .12s ease; }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #555;
    }
    .nav-tabs .nav-link.active {
        background: #e75480;
        color: #fff;
        border-radius: 8px 8px 0 0;
    }
    .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .pagination li { display: inline-block; }
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 6px 10px;
        min-width: 40px;
        text-align: center;
        border-radius: 8px;
        background: #fff;
        color: #333;
        border: 1px solid #eee;
        font-size: 14px;
        line-height: 1;
        box-sizing: border-box;
        white-space: nowrap;
    }
    .pagination li a:hover { background: rgba(231,84,128,0.06); }
    .pagination li.active span {
        background: #e75480;
        color: #fff;
        border-color: #e75480;
    }
    .pagination li.disabled span {
        opacity: 0.6;
        cursor: default;
    }
    .pagination li a .page-icon,
    .pagination li span .page-icon {
        width: 14px;
        height: 14px;
        display: inline-block;
        vertical-align: middle;
    }
    /* Nút Đánh giá */
    .btn-review {
        background: #e75480;
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-review:hover {
        background: #d9436e;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Nút Đã đánh giá */
    .btn-reviewed {
        background: #5cb85c;
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 8px;
        opacity: 0.85;
        cursor: default;
    }
    .btn-cancel-order {
        background: #d9534f;
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-cancel-order:hover {
        background: #c9302c;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('toast-message');
        if (toast) {
            setTimeout(() => {
                toast.remove();
            }, 3500);
        }
    });
</script>
@endpush