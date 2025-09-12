@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . ($order->id ?? ''))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm" style="border-radius:10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 style="color:#e75480;margin:0">Đơn hàng #{{ $order->id }}</h4>
                            <div class="text-muted" style="font-size:13px;">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="text-end">
                            <div style="font-weight:800;font-size:18px;color:#222;">
                                {{ number_format($order->total ?? 0,0,',','.') }} đ
                            </div>
                            <div style="margin-top:8px;">
                                <span style="padding:6px 10px;border-radius:18px;background:#f6e8ea;color:#7a2130;font-weight:700;">
                                    {{ strtoupper($order->payment_status ?? $order->status ?? 'PENDING') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 style="margin-bottom:8px;color:#333">Thông tin người nhận</h6>
                            <p style="margin:0"><strong>{{ $order->name }}</strong></p>
                            <p style="margin:0">{{ $order->phone }}</p>
                            <p style="margin:0">{{ $order->address }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p style="margin:0"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 style="color:#333"></h6>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-start">Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                @if(optional($item->product)->image)
                                                    <img src="{{ asset('storage/'.optional($item->product)->image) }}" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:6px;margin-right:12px;">
                                                @endif
                                                <div>
                                                    <div style="font-weight:700;color:#333">{{ optional($item->product)->name ?? $item->product_name ?? 'Sản phẩm' }}</div>
                                                    @if(isset($item->size) && $item->size)
                                                        <div class="text-muted" style="font-size:12px;">Kích thước: {{ $item->size }}</div>
                                                    @endif
                                                    @if(isset($item->color) && $item->color)
                                                        <div class="text-muted" style="font-size:12px;">Màu: {{ $item->color }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ number_format($item->price ?? 0,0,',','.') }} đ</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format( ($item->price ?? 0) * ($item->quantity ?? 1),0,',','.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th class="text-end">{{ number_format($order->total ?? 0,0,',','.') }} đ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="{{ route('orders.index') }}" 
                        class="btn" 
                        style="background:#f6e8ea;color:#7a2130;border:1px solid #e8cbd2;">
                        ‹ Quay về danh sách
                        </a>

                        @if(($order->payment_status ?? null) !== 'paid' && ($order->payment_method ?? '') === 'momo')
                            <a href="{{ route('payment.momo', $order->id) }}" 
                            class="btn" 
                            style="background:#e75480;color:#fff;border:none;">
                            Thanh toán lại (MoMo)
                            </a>
                        @endif

                        <button onclick="window.print()" 
                                class="btn" 
                                style="background:#e75480;color:#fff;border:none;">
                            🖨 In đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- CSS cho in ấn --}}
<style>
@media print {
    /* Ẩn toàn bộ layout mặc định */
    header, footer, nav, .navbar, .sidebar, .mt-4, .btn { 
        display: none !important; 
    }

    /* Chỉ hiển thị phần đơn hàng */
    .card.shadow-sm {
        box-shadow: none !important;
        border: none !important;
    }

    body * {
        visibility: hidden;
    }
    .card.shadow-sm, .card.shadow-sm * {
        visibility: visible;
    }
    .card.shadow-sm {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection
