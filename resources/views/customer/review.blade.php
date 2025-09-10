@if($order->status === 'delivered')
    <h4 class="mt-4">Đánh giá sản phẩm</h4>
    @auth
        @foreach($order->items as $item)
            <div class="border rounded p-3 mb-3">
                <p><strong>{{ $item->product->name ?? $item->product_name }}</strong></p>

                <form action="{{ route('customer.review', $item->product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-2">
                        <label class="form-label">Chọn số sao:</label>
                        <select name="rating" class="form-select" style="width:150px;" required>
                            <option value="">-- Chọn --</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }} sao</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Nhận xét:</label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
            </div>
        @endforeach
    @else
        <p><a href="{{ route('login') }}">Đăng nhập</a> để gửi đánh giá.</p>
    @endauth
@endif
