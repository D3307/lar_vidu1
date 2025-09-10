@extends('admin.layout')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="admin-card" style="max-width:700px;margin:auto">
    <h3 style="margin-bottom:16px;font-size:1.1rem;color:#4b3a3f">🔍 Chi tiết đánh giá</h3>

    <div class="form-group">
        <label>Sản phẩm</label>
        <input type="text" value="{{ $review->product->name ?? 'N/A' }}" disabled>
    </div>

    <div class="form-group">
        <label>Người dùng</label>
        <input type="text" value="{{ $review->user->name ?? 'N/A' }}" disabled>
    </div>

    <div class="form-group">
        <label>Đơn hàng</label>
        <input type="text" value="#{{ $review->order->id ?? 'N/A' }}" disabled>
    </div>

    <div class="form-group">
        <label>Rating</label>
        <input type="text" value="⭐ {{ $review->rating }}" disabled>
    </div>

    <div class="form-group">
        <label>Bình luận</label>
        <textarea disabled style="min-height:100px">{{ $review->comment }}</textarea>
    </div>

    <div class="form-group">
        <label>Ngày tạo</label>
        <input type="text" value="{{ $review->created_at->format('d/m/Y H:i') }}" disabled>
    </div>

    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:18px">
        <a href="{{ route('admin.reviews.index') }}" class="btn-cancel">⬅ Quay lại</a>
        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn-save">✏️ Sửa</a>
    </div>
</div>

<style>
    .form-group { margin-bottom:14px; display:flex; flex-direction:column; }
    .form-group label { font-weight:600; margin-bottom:6px; color:#4b3a3f; }
    .form-group input, .form-group textarea {
        padding:8px 10px; border:1px solid #ccc; border-radius:8px; font-size:0.95rem;
    }
    .form-group textarea { resize:vertical; }
</style>
@endsection