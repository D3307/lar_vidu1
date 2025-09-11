@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row g-4">
                <!-- Cột Thông tin cá nhân -->
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-3">
                                    <span class="bg-light rounded-circle p-3">
                                        <i class="fa-solid fa-user fa-2x text-brand"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 fw-bold text-brand">Thông tin cá nhân</h4>
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
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control rounded-3"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control rounded-3"
                                        value="{{ old('phone', $user->phone) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Mật khẩu (để trống nếu không đổi)</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control rounded-3">
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control rounded-3">
                                </div>

                                <button type="submit" class="btn btn-brand w-100 py-2 fw-bold">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cột Lịch sử -->
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-brand mb-3">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử đơn hàng / khuyến mãi
                            </h4>

                            @if($histories->count())
                                <div class="history-list">
                                    @foreach($histories as $history)
                                        <div class="history-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 shadow-sm">
                                            <div>
                                                <div class="fw-semibold text-brand">
                                                    <i class="fa-solid fa-receipt me-2"></i> Đơn #{{ $history->order?->id ?? '-' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($history->used_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <div>
                                                    <span class="badge bg-brand text-white px-3 py-2">
                                                        {{ $history->coupon?->code ?? 'Không có mã' }}
                                                    </span>
                                                </div>
                                                <div class="fw-bold mt-1 text-brand">
                                                    @if($history->discount)
                                                        -{{ number_format($history->discount, 0, ',', '.') }} đ
                                                    @else
                                                        0 đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-3">
                                    {{ $histories->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @else
                                <p class="text-muted">Bạn chưa có lịch sử giao dịch nào.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* === MÀU CHỦ ĐẠO === */
    :root {
        --brand-color: #7a2f3b;   /* rượu vang */
        --brand-hover: #b14d63;   /* hồng nhạt */
    }

    /* Text và icon */
    .text-brand {
        color: var(--brand-color) !important;
    }

    /* Button custom */
    .btn-brand {
        background-color: var(--brand-color);
        border: none;
        color: #fff;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-brand:hover {
        background-color: var(--brand-hover);
        color: #fff;
    }

    /* Override Bootstrap primary */
    .btn-primary {
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
    }
    .btn-primary:hover {
        background-color: var(--brand-hover) !important;
        border-color: var(--brand-hover) !important;
    }

    /* Input */
    .form-control {
        border: 1px solid #e3a1b2;
    }
    .form-control:focus {
        border-color: var(--brand-hover);
        box-shadow: 0 0 5px rgba(177, 77, 99, 0.4);
    }

    /* Bảng lịch sử */
    .history-item {
        background: #fff;
        border: 1px solid #f2d7dd;
        transition: all 0.3s ease;
    }
    .history-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(122, 47, 59, 0.15);
        border-color: var(--brand-color);
    }

    /* Badge màu chủ đạo */
    .bg-brand {
        background-color: var(--brand-color) !important;
    }
</style>
@endsection