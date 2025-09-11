@extends('admin.layout')

@section('title', 'Sửa mã khuyến mãi')

@section('content')
<div class="admin-card">
    <h3 style="margin:0 0 16px;font-size:1.1rem;color:#4b3a3f">Sửa mã khuyến mãi</h3>

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="styled-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">Mã khuyến mãi</label>
            <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required>
        </div>

        <div class="form-group">
            <label for="type">Loại mã</label>
            <select name="type" id="type" required>
                <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="value">Giá trị</label>
            <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" required>
        </div>

        <div class="form-group">
            <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
            <input type="number" name="min_order_value" id="min_order_value" value="{{ old('min_order_value', $coupon->min_order_value) }}">
        </div>

        <div class="form-group">
            <label for="usage_limit">Giới hạn số lần sử dụng</label>
            <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}">
        </div>

        <div class="form-group">
            <label for="start_date">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $coupon->start_date) }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $coupon->end_date) }}" required>
        </div>

        <div style="margin-top:20px;display:flex;gap:10px;">
            <button type="submit" class="btn-add">Cập nhật</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn-action btn-edit">Quay lại</a>
        </div>
    </form>
</div>

<style>
    .styled-form .form-group { margin-bottom:16px; }
    .styled-form label { display:block; margin-bottom:6px; font-weight:600; color:#7a2f3b; }
    .styled-form input, .styled-form select {
        width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;
        font-size:0.95rem; transition:border-color .2s;
    }
    .styled-form input:focus, .styled-form select:focus {
        border-color:#c03651; outline:none;
    }
</style>
@endsection