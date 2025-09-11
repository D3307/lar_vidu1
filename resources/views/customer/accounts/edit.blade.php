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
                                        <i class="fa-solid fa-user fa-2x text-primary"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 fw-bold text-primary">Thông tin cá nhân</h4>
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

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
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
                            <h4 class="fw-bold text-secondary mb-3">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử đơn hàng / khuyến mãi
                            </h4>

                            @if($histories->count())
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Mã giảm giá</th>
                                                <th>Giảm</th>
                                                <th>Đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($histories as $history)
                                                <tr>
                                                    <td>{{ $history->used_at }}</td>
                                                    <td>{{ $history->coupon?->code ?? '-' }}</td>
                                                    <td>
                                                        @if($history->discount)
                                                            {{ number_format($history->discount, 0, ',', '.') }} đ
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>#{{ $history->order?->id ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $histories->links('vendor.pagination.bootstrap-4') }}
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
    /* Khung thông tin cá nhân */
    .account-info {
        background: #ffffff;
        border: 1px solid #f5c3d2;  /* viền hồng nhạt */
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(122, 47, 59, 0.1); /* bóng nhẹ màu chủ đạo */
    }

    /* Tiêu đề */
    .account-info h2 {
        color: #7a2f3b; /* màu rượu vang từ footer */
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Input */
    .account-info input {
        border: 1px solid #e3a1b2; /* viền hồng nhạt */
        border-radius: 8px;
        padding: 10px;
    }

    .account-info input:focus {
        border-color: #b14d63; /* hồng đậm hơn khi focus */
        box-shadow: 0 0 5px rgba(177, 77, 99, 0.4);
    }

    /* Nút lưu thay đổi */
    .account-info button {
        background: #7a2f3b; /* đồng bộ với footer */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        transition: 0.3s;
    }

    .account-info button:hover {
        background: #b14d63; /* hồng nhạt hơn khi hover */
    }

    /* Bảng lịch sử đơn hàng */
    .history-table {
        margin-top: 30px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(177, 77, 99, 0.1);
    }

    .history-table th {
        background: #7a2f3b; 
        color: #fff;
        padding: 12px;
        text-align: center;
    }

    .history-table td {
        background: #fff;
        padding: 12px;
        border-bottom: 1px solid #f3d6de;
        text-align: center;
    }

    .history-table tr:hover td {
        background: #fceef3; /* hồng nhạt khi hover */
    }

</style>
@endsection