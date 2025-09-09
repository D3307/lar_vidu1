@extends('layouts.app')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color:#e75480;font-weight:700">Danh sách đơn hàng</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
                <div class="col-12">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">
                        <div class="card shadow-sm" style="border-left:6px solid rgba(231,84,128,0.12); border-radius:10px;">
                            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                                <div>
                                    <div style="font-weight:700;color:#333;">#{{ $order->id }}</div>
                                    <div class="text-muted" style="font-size:13px;">Ngày: {{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="mt-1" style="font-size:13px;color:#666;">
                                        Phương thức: <strong>{{ $order->payment_method ?? 'N/A' }}</strong>
                                        &nbsp;·&nbsp;
                                        Trạng thái:
                                        <span style="font-weight:700;color:#7a2130;">
                                            {{ $order->payment_status ?? $order->status ?? 'pending' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end ms-auto">
                                    <div style="font-weight:800;font-size:18px;color:#222;">
                                        {{ number_format($order->total ?? 0,0,',','.') }} đ
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge" style="background:#f6e8ea;color:#7a2130;font-weight:700;padding:6px 10px;border-radius:8px;">
                                            Xem chi tiết →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if($orders->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{-- gọi view phân trang custom của bạn --}}
            {{ $orders->links('vendor.pagination.custom') }}
        </div>
        @endif
    @endif
</div>

<style>
.card:hover { transform: translateY(-4px); transition: .12s ease; }

/* chuẩn hóa danh sách pagination (tránh icon/arrow to) */
.pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
}
.pagination li {
    display: inline-block;
}
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
.pagination li a:hover {
    background: rgba(231,84,128,0.06);
}
.pagination li.active span {
    background: #e75480;
    color: #fff;
    border-color: #e75480;
}
.pagination li.disabled span {
    opacity: 0.6;
    cursor: default;
}

/* nếu custom view có icon lớn, ép kích thước icon */
.pagination li a .page-icon,
.pagination li span .page-icon {
    width: 14px;
    height: 14px;
    display: inline-block;
    vertical-align: middle;
}
</style>
@endsection
