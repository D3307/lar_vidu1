@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
