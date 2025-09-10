@extends('admin.layout')

@section('title', 'Sửa đánh giá')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:16px;font-size:1.1rem;color:#4b3a3f">✏️ Sửa đánh giá</h3>

    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" style="max-width:600px;margin:auto">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="rating">Rating</label>
            <select name="rating" id="rating" required>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>⭐ {{ $i }}</option>
                @endfor
            </select>
            @error('rating') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="comment">Bình luận</label>
            <textarea name="comment" id="comment" required style="min-height:100px">{{ old('comment', $review->comment) }}</textarea>
            @error('comment') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:18px">
            <a href="{{ route('admin.reviews.index') }}" class="btn-cancel">⬅ Quay lại</a>
            <button type="submit" class="btn-save">💾 Cập nhật</button>
        </div>
    </form>
</div>

<style>
    .form-group { margin-bottom:14px; display:flex; flex-direction:column; }
    .form-group label { font-weight:600; margin-bottom:6px; color:#4b3a3f; }
    .form-group input, .form-group select, .form-group textarea {
        padding:8px 10px; border:1px solid #ccc; border-radius:8px; font-size:0.95rem;
    }
    .form-group textarea { resize:vertical; }
    .error-text { font-size:0.85rem; color:#d9534f; margin-top:4px; }
</style>
@endsection