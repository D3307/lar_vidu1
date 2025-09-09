@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container my-5">
    <h2 class="mb-4" style="color: var(--primary)">🛒 Giỏ hàng của bạn</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <form action="{{ route('cart.removeSelected') }}" method="POST" id="cart-form">
            @csrf
            <div class="table-responsive shadow-sm rounded">
                <table class="table align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Sản phẩm</th>
                            <th>Màu</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $key => $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected[]" value="{{ $key }}">
                                </td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        {{-- ✅ Sửa lại đường dẫn ảnh --}}
                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" 
                                            class="rounded me-3" style="width:70px; height:70px; object-fit:cover;">
                                        <span>{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="d-inline-block rounded-circle" 
                                          style="width:20px; height:20px; background:{{ $item['color'] }}; border:1px solid #ccc;"></span>
                                </td>
                                <td>{{ $item['size'] ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $key) }}" method="POST" class="d-inline">
                                        @csrf
                                        {{-- ✅ Ô nhập số lượng ngắn gọn hơn --}}
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                               class="form-control form-control-sm d-inline-block text-center" style="width:60px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-1">Cập nhật</button>
                                    </form>
                                </td>
                                <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <!-- nút Xóa: submit POST tới cart.removeSelected -->
                    <button type="submit" formaction="{{ route('cart.removeSelected') }}" formmethod="POST" class="btn btn-outline-danger">
                        <i class="fas fa-trash-alt"></i> Xóa các sản phẩm đã chọn
                    </button>
                </div>

                <div class="text-end">
                    <h4 class="mb-3">Tổng cộng:
                        <span style="color: var(--primary)">{{ number_format($total, 0, ',', '.') }} đ</span>
                    </h4>

                    <a href="{{ route('customer.products') }}" class="btn" style="background: var(--accent); color: #fff;">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>

                    <!-- Nút Thanh toán: gửi selected[] bằng GET tới checkout -->
                    <button type="submit" formaction="{{ route('checkout') }}" formmethod="GET"
                            class="btn" style="background: var(--primary); color: #fff;">
                        Thanh toán <i class="fas fa-credit-card"></i>
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="text-center py-5">
            <p class="fs-5">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('customer.products') }}" class="btn" style="background: var(--primary); color:#fff;">
                <i class="fas fa-shopping-bag"></i> Mua sắm ngay
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.getElementById("select-all")?.addEventListener("change", function(e) {
        document.querySelectorAll("input[name='selected[]']").forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endpush
@endsection