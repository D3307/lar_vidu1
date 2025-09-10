@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <span class="bg-light rounded-circle p-3">
                                <i class="fa-solid fa-user fa-2x text-primary"></i>
                            </span>
                        </div>
                        <h3 class="mb-0 fw-bold text-primary">Thông tin cá nhân</h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('accounts.update') }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Tên</label>
                            <input type="text" name="name" id="name"
                                   class="form-control rounded-3"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email"
                                   class="form-control rounded-3"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                            <input type="text" name="phone" id="phone"
                                   class="form-control rounded-3"
                                   value="{{ old('phone', $user->phone) }}" required>
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Mật khẩu (để trống nếu không đổi)</label>
                            <input type="password" name="password" id="password"
                                   class="form-control rounded-3">
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control rounded-3">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection