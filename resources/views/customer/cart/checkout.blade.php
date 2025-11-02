@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-5">
    {{-- Hiển thị lỗi/flash --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <h2 class="mb-2 text-center fw-bold" style="font-size:2.2rem; color:#222;">Thanh toán</h2>

    <!-- MÃ GIẢM GIÁ -->
    <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
        <h5 class="fw-bold mb-3" style="color:#e75480;">MÃ GIẢM GIÁ</h5>

        <div class="mb-2">
            <form method="GET" action="{{ route('checkout.form') }}">
                <label for="coupon_id">Chọn mã giảm giá:</label>
                <select name="coupon_id" id="coupon_id" onchange="this.form.submit()">
                    <option value="">-- Không áp dụng --</option>
                    @foreach($coupons as $c)
                        @if(empty($c->product_id)) {{-- Chỉ hiện mã giảm cho toàn đơn hàng --}}
                            <option value="{{ $c->id }}" {{ (isset($couponId) && $couponId == $c->id) ? 'selected' : '' }}>
                                {{ $c->code }} -
                                @if($c->discount_type === 'percent')
                                    Giảm {{ $c->discount }}%
                                @else
                                    Giảm {{ number_format($c->discount,0,',','.') }} đ
                                @endif
                            </option>
                        @endif
                    @endforeach
                </select>
            </form>
        </div>

        <div class="row justify-content-center">
            <!-- Thông tin thanh toán -->
            <div class="col-lg-7">
                <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-4" style="color:#e75480;">THÔNG TIN THANH TOÁN</h5>

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="coupon_id" value="{{ $couponId ?? '' }}">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ và tên</label>
                                <input type="text" class="form-control border-pink" name="name" required
                                       value="{{ old('name', Auth::user()->name ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Tên công ty <span class="text-muted">(không bắt buộc)</span></label>
                                <input type="text" class="form-control border-pink" name="company">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Quốc gia / Khu vực*</label>
                                <select class="form-select border-pink" name="country" required>
                                    <option value="">Chọn quốc gia</option>
                                    <option value="VN" selected>Việt Nam</option>
                                    <option value="US">Hoa Kỳ</option>
                                    <!-- Thêm các quốc gia khác nếu cần -->
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Địa chỉ*</label>
                                <input type="text" class="form-control border-pink mb-2"
                                       name="address" placeholder="Số nhà và tên đường" required>
                                <input type="text" class="form-control border-pink"
                                       name="address2" placeholder="Căn hộ, tầng, đơn vị, v.v. (không bắt buộc)">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tỉnh / Thành phố*</label>
                                <input type="text" class="form-control border-pink" name="city" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Quốc gia (không bắt buộc)</label>
                                <input type="text" class="form-control border-pink" name="country_optional">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mã bưu điện*</label>
                                <input type="text" class="form-control border-pink" name="postcode" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại*</label>
                                <input type="text" class="form-control border-pink" name="phone" required
                                       value="{{ old('phone', Auth::user()->phone ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Email*</label>
                                <input type="email" class="form-control border-pink" name="email" required
                                       value="{{ old('email', Auth::user()->email ?? '') }}">
                            </div>

                            <div class="col-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="ship-diff" name="ship_diff">
                                    <label class="form-check-label" for="ship-diff">
                                        Giao hàng tới địa chỉ khác?
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ghi chú đơn hàng
                                    <span class="text-muted">(không bắt buộc)</span>
                                </label>
                                <textarea class="form-control border-pink" name="order_notes" rows="2"></textarea>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-lg-5">
                <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-4" style="color:#e75480;">ĐƠN HÀNG CỦA BẠN</h5>

                    <table class="table mb-3">
                        <thead>
                            <tr style="border-bottom:1.5px solid #eee;">
                                <th class="fw-semibold" style="color:#222;">Sản phẩm</th>
                                <th class="fw-semibold text-end" style="color:#222;">Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $item['name'] }}</span>
                                        <input type="hidden" name="product_detail_id[]" value="{{ $item['product_detail_id'] }}">
                                        <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                                        <input type="hidden" name="price[]" value="{{ $item['price'] }}">
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $coupon = \App\Models\Coupon::where('product_id', $item['id'])
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();
                                            $discountedPrice = $item['price'];
                                            if ($coupon) {
                                                $discount = $coupon->discount_type === 'percent' 
                                                    ? $item['price'] * ($coupon->discount / 100)
                                                    : $coupon->discount;
                                                $discount = min($discount, $item['price']);
                                                $discountedPrice = $item['price'] - $discount;
                                            }
                                            $subtotal = $discountedPrice * $item['quantity'];
                                        @endphp
                                        {{ number_format($subtotal, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="fw-bold">Tạm tính</td>
                                <td class="fw-bold text-end">{{ number_format($total,0,',','.') }} đ</td>
                            </tr>

                            @if($discount > 0)
                                <tr>
                                    <td class="fw-bold">Giảm giá</td>
                                    <td class="fw-bold text-end" style="color:#e75480;">
                                        -{{ number_format($discount,0,',','.') }} đ
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="font-size:1.1rem;">Thành tiền</td>
                                    <td class="fw-bold text-end" style="font-size:1.1rem; color:#e75480;">
                                        {{ number_format($finalTotal,0,',','.') }} đ
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td class="fw-bold">Phí vận chuyển</td>
                                <td class="text-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping" id="flat" value="flat" checked>
                                        <label class="form-check-label" for="flat">
                                            Giao hàng tiêu chuẩn
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping" id="pickup" value="pickup">
                                        <label class="form-check-label" for="pickup">
                                            Nhận tại cửa hàng
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold" style="font-size:1.1rem;">Thành tiền</td>
                                <td class="fw-bold text-end" style="font-size:1.1rem; color:#e75480;">
                                    {{ number_format($finalTotal,0,',','.') }} đ
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="cod" value="cod" required>
                            <label class="form-check-label fw-semibold" for="cod">Thanh toán khi nhận hàng</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="momo" value="momo" required>
                            <label class="form-check-label fw-semibold" for="momo">
                                Thanh toán qua Momo
                                <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="Momo"
                                     style="height:18px;vertical-align:middle;">
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="btn w-100 text-white fw-bold py-2"
                            style="background:#222; font-size:1.1rem; letter-spacing:1px;">
                        ĐẶT HÀNG
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: #fafbfc;
    }
    .bg-white {
        background: #fff !important;
    }
    .border-pink {
        border: 1.5px solid #e75480 !important;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #e75480 !important;
        box-shadow: 0 0 0 0.15rem rgba(231,84,128,0.10);
    }
    .form-check-input:checked {
        background-color: #e75480;
        border-color: #e75480;
    }
    .btn {
        border-radius: 8px;
    }
    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<script>
    document.getElementById('toggle-coupon')?.addEventListener('click', function(e) {
        e.preventDefault();
        const box = document.getElementById('coupon-box');
        if (box) {
            box.style.display = (box.style.display === 'none') ? 'block' : 'none';
        }
    });

    // Giả lập xử lý coupon (có thể gọi Ajax)
    function applyCoupon() {
        let code = document.querySelector('input[name="coupon_code"]').value.trim();
        if (code === "") {
            alert("Vui lòng nhập mã giảm giá!");
            return;
        }
        alert("Mã " + code + " đã được áp dụng (demo).");
        // TODO: Gửi code về server để check
    }
</script>
@endsection