@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="mb-2 text-center fw-bold" style="font-size:2.2rem; color:#222;">Checkout</h2>
    <div class="text-center mb-4">
        <span>Bạn có mã giảm giá? <a href="#" style="color:#e75480; font-weight:600;">Click here</a> để nhập</span>
    </div>
    <div class="row justify-content-center">
        <!-- Billing Details -->
        <div class="col-lg-7">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4" style="color:#e75480;">BILLING DETAILS</h5>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">First name*</label>
                            <input type="text" class="form-control border-pink" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last name*</label>
                            <input type="text" class="form-control border-pink" name="last_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Company name <span class="text-muted">(optional)</span></label>
                            <input type="text" class="form-control border-pink" name="company">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Country / Region*</label>
                            <select class="form-select border-pink" name="country" required>
                                <option value="">Chọn quốc gia</option>
                                <option value="VN" selected>Việt Nam</option>
                                <option value="US">United States (US)</option>
                                <!-- Thêm các quốc gia khác nếu cần -->
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Street address*</label>
                            <input type="text" class="form-control border-pink mb-2" name="address" placeholder="House number and street name" required>
                            <input type="text" class="form-control border-pink" name="address2" placeholder="Apartment, suite, unit, etc. (optional)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Town / City*</label>
                            <input type="text" class="form-control border-pink" name="city" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country <span class="text-muted">(optional)</span></label>
                            <input type="text" class="form-control border-pink" name="country_optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Postcode*</label>
                            <input type="text" class="form-control border-pink" name="postcode" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone*</label>
                            <input type="text" class="form-control border-pink" name="phone" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email address*</label>
                            <input type="email" class="form-control border-pink" name="email" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="ship-diff" name="ship_diff">
                                <label class="form-check-label" for="ship-diff">
                                    Ship to a different address?
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Order notes <span class="text-muted">(optional)</span></label>
                            <textarea class="form-control border-pink" name="order_notes" rows="2"></textarea>
                        </div>
                    </div>
            </div>
        </div>
        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4" style="color:#e75480;">YOUR ORDER</h5>
                <table class="table mb-3">
                    <thead>
                        <tr style="border-bottom:1.5px solid #eee;">
                            <th class="fw-semibold" style="color:#222;">Product</th>
                            <th class="fw-semibold text-end" style="color:#222;">Sub-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $item['name'] }}</span>
                            </td>
                            <td class="text-end">
                                {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1),0,',','.') }} đ
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bold">Sub-total</td>
                            <td class="fw-bold text-end">{{ number_format($total,0,',','.') }} đ</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Shipping</td>
                            <td class="text-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping" id="flat" value="flat" checked>
                                    <label class="form-check-label" for="flat">Flat rate 30,000đ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping" id="free" value="free">
                                    <label class="form-check-label" for="free">Free shipping</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping" id="pickup" value="pickup">
                                    <label class="form-check-label" for="pickup">Local pickup</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold" style="font-size:1.1rem;">Total</td>
                            <td class="fw-bold text-end" style="font-size:1.1rem; color:#e75480;">
                                {{ number_format($finalTotal ?? $total,0,',','.') }} đ
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment" id="bank" value="bank" required>
                        <label class="form-check-label fw-semibold" for="bank">
                            Direct bank transfer
                        </label>
                        <div class="text-muted small ms-4">
                            Make your payment directly into our bank account.<br>
                            Please use your Order ID as the payment reference.<br>
                            Your order will not be shipped until the funds have cleared in our account.
                        </div>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment" id="cod" value="cod" required>
                        <label class="form-check-label fw-semibold" for="cod">
                            Cash on delivery
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment" id="paypal" value="paypal" required>
                        <label class="form-check-label fw-semibold" for="paypal">
                            Paypal <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="Paypal" style="height:18px;vertical-align:middle;">
                        </label>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="agree" required>
                    <label class="form-check-label" for="agree">
                        I agree to the website <a href="#" style="color:#e75480;">Terms and Conditions</a>
                    </label>
                </div>
                <button type="submit" class="btn w-100 text-white fw-bold py-2" style="background:#222; font-size:1.1rem; letter-spacing:1px;">
                    PLACE ORDER
                </button>
                </form>
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
.form-control:focus, .form-select:focus {
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
.table th, .table td {
    vertical-align: middle;
}
</style>
@endsection
