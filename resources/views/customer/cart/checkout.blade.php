@extends('layouts.app')

@section('title', 'Đặt hàng')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center" style="color: #e75480;">🛍️ Đặt hàng</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf

                        {{-- nếu có selected keys thì giữ lại --}}
                        @if(!empty($selected))
                            @foreach($selected as $key)
                                <input type="hidden" name="selected[]" value="{{ $key }}">
                            @endforeach
                        @endif

                        {{-- hiển thị danh sách item (cart từ controller) --}}
                        <div class="mb-3">
                            <h5>Sản phẩm</h5>
                            @foreach($cart as $k => $item)
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset($item['image'] ?? '') }}" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:6px;margin-right:12px;">
                                    <div>
                                        <div style="font-weight:700">{{ $item['name'] }}</div>
                                        <div class="text-muted">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1),0,',','.') }} đ</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- thông tin giao hàng --}}
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color:#e75480;">Họ và tên</label>
                            <input type="text" class="form-control border-pink" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label" style="color:#e75480;">Địa chỉ</label>
                            <input type="text" class="form-control border-pink" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label" style="color:#e75480;">Số điện thoại</label>
                            <input type="text" class="form-control border-pink" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment" class="form-label" style="color:#e75480;">Phương thức thanh toán</label>
                            <select class="form-select border-pink" id="payment" name="payment" required>
                                <option value="cod">Thanh toán khi nhận hàng</option>
                                <option value="momo">Thanh toán Online (Momo)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn w-100 text-white" style="background-color:#e75480;">
                            Xác nhận thanh toán
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-pink { border: 1px solid #e75480 !important; }
    .card { border-top: 4px solid #e75480; }
</style>
@endsection