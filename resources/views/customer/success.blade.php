@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); overflow: hidden;">
                <div style="background: linear-gradient(90deg, #e75480 0%, #7a2130 100%); padding: 28px 20px; color: #fff; text-align: center;">
                    @if($order && $order->payment_status === 'paid')
                        <h1 style="margin:0; font-size:28px;">✅ Thanh toán thành công!</h1>
                        <p style="margin:6px 0 0; opacity:0.95;">Cảm ơn bạn. Đơn hàng đã được thanh toán thành công.</p>
                    @else
                        <h1 style="margin:0; font-size:28px;">⚠️ Đơn hàng chưa được thanh toán!</h1>
                        <p style="margin:6px 0 0; opacity:0.95;">Nếu bạn đã thanh toán, vui lòng chờ hệ thống cập nhật hoặc kiểm tra lịch sử đơn hàng.</p>
                    @endif
                </div>

                <div style="padding:24px 28px;">
                    @if(isset($order))
                        <div style="display:flex;gap:18px;align-items:center;">
                            <div style="flex:1">
                                <p style="margin:0;color:#666;"><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                                <p style="margin:6px 0 0;color:#666;"><strong>Phương thức:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                                <p style="margin:6px 0 0;color:#666;"><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status ?? 'pending' }}</p>
                            </div>
                            <div style="text-align:right; min-width:160px;">
                                @php
                                    $discount = $order->discount ?? 0;
                                    $finalTotal = ($order->total ?? 0) - $discount;
                                @endphp
                                <p style="margin:0;color:#222;font-weight:700;font-size:18px;">
                                    {{ number_format($finalTotal, 0, ',', '.') }} VNĐ
                                </p>
                                <small style="color:#999;">
                                    Tổng tiền đơn hàng 
                                    @if($discount > 0)
                                        <br><span style="color:#e75480;">(Đã giảm {{ number_format($discount, 0, ',', '.') }}đ)</span>
                                        @if($order->coupon)
                                            <br><span style="color:#e75480;">Mã giảm giá: {{ $order->coupon->code }}</span>
                                        @endif
                                    @endif
                                </small>
                            </div>
                        </div>

                        <hr style="border:none;border-top:1px solid #f0f0f0;margin:18px 0;">
                    @endif

                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary" style="background:#e75480;border-color:#e75480;">
                            Xem danh sách đơn hàng
                        </a>

                        @if(isset($order))
                            <a href="{{ route('orders.show', $order->id) }}" class="btn" style="background:#7a2130;color:#fff;border:1px solid rgba(0,0,0,0.05);">
                                Xem chi tiết đơn hàng
                            </a>
                        @endif

                        <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="border-color:#ddd;color:#444;">
                            Quay về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tinh chỉnh nhỏ cho trang success */
    .btn-primary { padding: 10px 18px; border-radius: 8px; }
    .btn { padding: 10px 16px; border-radius: 8px; }
</style>
@endsection
