@extends('layouts.app')

@section('title', 'Lịch sử hoạt động')

@section('content')
<div class="container">
    <h2>Lịch sử hoạt động</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Thời gian</th>
                <th>Hoạt động</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $h)
                <tr>
                    <td>{{ $h->used_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($h->action_type === 'use_coupon')
                            Sử dụng mã khuyến mãi
                        @elseif($h->action_type === 'view_product')
                            Xem sản phẩm
                        @elseif($h->action_type === 'buy_order')
                            Đặt hàng
                        @endif
                    </td>
                    <td>
                        @if($h->coupon)
                            Mã: {{ $h->coupon->code }} (giảm {{ $h->discount ?? 0 }})
                        @elseif($h->order)
                            Đơn hàng #{{ $h->order->id }} - {{ number_format($h->order->total,0,',','.') }}đ
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Chưa có hoạt động nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $histories->links('vendor.pagination.bootstrap-4') }}
</div>
@endsection