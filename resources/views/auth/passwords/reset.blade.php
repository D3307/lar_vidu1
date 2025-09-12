@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Đặt lại mật khẩu</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">Xác nhận mật khẩu</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
    </form>
</div>

<style>
    body, .container {
        background: #fff;
    }
    .auth-card {
        max-width: 420px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(231,84,128,0.08);
        border-top: 4px solid #e75480;
        padding: 32px 28px;
    }
    .auth-title {
        color: #e75480;
        font-weight: bold;
        font-size: 1.4rem;
        margin-bottom: 18px;
        text-align: center;
    }
    .form-label {
        color: #e75480;
        font-weight: 500;
    }
    .form-control {
        border: 1px solid #e75480;
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 12px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #e75480;
        box-shadow: 0 0 0 2px rgba(231,84,128,0.15);
    }
    .btn-primary {
        background: #e75480;
        border: none;
        color: #fff;
        font-weight: bold;
        border-radius: 8px;
        padding: 10px 18px;
        width: 100%;
        margin-top: 10px;
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: #c03651;
    }
    .alert {
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 16px;
    }
</style>
@endsection