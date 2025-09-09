@extends('layouts.app')

@section('title', 'Xác thực email')

@section('content')
<div class="container" style="padding: 4rem 0; text-align: center;">
    <div class="promo-banner" style="max-width: 600px; margin: 0 auto;">
        <h2>Xác thực email của bạn</h2>
        <p>Trước khi tiếp tục, vui lòng kiểm tra email của bạn và nhấp vào link xác thực.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" style="margin: 1rem 0; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
                Một link xác thực mới đã được gửi đến email của bạn.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" style="margin-top: 1.5rem;">
            @csrf
            <button type="submit" class="btn">Gửi lại email xác thực</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
            @csrf
            <button type="submit" class="btn btn-secondary">Đăng xuất</button>
        </form>
    </div>
</div>
@endsection