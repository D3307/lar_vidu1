@extends('admin.layout')

@section('title', 'Thêm người dùng')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.users.store') }}" method="POST" style="max-width:600px;margin:auto">
        @csrf

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name') }}" required>
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   value="{{ old('email') }}" required>
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" id="phone" 
                   value="{{ old('phone') }}" required>
            @error('phone') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" name="address" id="address" 
                   value="{{ old('address') }}" required>
            @error('address') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" required>
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" id="role" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:18px">
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">⬅ Quay lại</a>
            <button type="submit" class="btn-save">💾 Thêm mới</button>
        </div>
    </form>
</div>

{{-- Giữ nguyên style dùng chung với trang edit --}}
<style>
    .form-group {
        margin-bottom:14px;
        display:flex;
        flex-direction:column;
    }
    .form-group label {
        font-weight:600;
        margin-bottom:6px;
        color:#4b3a3f;
    }
    .form-group input,
    .form-group select {
        padding:8px 10px;
        border:1px solid #ccc;
        border-radius:8px;
        font-size:0.95rem;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color:#d64571;
        outline:none;
        box-shadow:0 0 0 2px rgba(214,69,113,0.2);
    }
    .error-text {
        font-size:0.85rem;
        color:#d9534f;
        margin-top:4px;
    }

    .btn-save {
        background:#f0d4db;
        color:#7a2f3b;
        padding:8px 16px;
        border:none;
        border-radius:8px;
        font-weight:600;
        cursor:pointer;
        transition:all .2s;
    }
    .btn-save:hover { background:#d64571; color:#fff; }

    .btn-cancel {
        background:#eee;
        color:#333;
        padding:8px 16px;
        border-radius:8px;
        text-decoration:none;
        font-weight:600;
        transition:all .2s;
    }
    .btn-cancel:hover { background:#ddd; }
</style>
@endsection
