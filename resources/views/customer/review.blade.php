@extends('layouts.app')

@section('title', 'Đánh giá đơn hàng #' . $order->id)

@section('content')
<div class="container py-5">
    <h3>Đánh giá đơn hàng #{{ $order->id }}</h3>

    <form action="{{ route('customer.review.store', $order->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Chọn số sao:</label>
            <select name="rating" class="form-select" style="width:200px;" required>
                <option value="">-- Chọn --</option>
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}">{{ $i }} sao</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nhận xét:</label>
            <textarea name="comment" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection