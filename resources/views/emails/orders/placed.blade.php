<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng #{{ $order->id }}</title>
</head>
<body style="font-family:'Segoe UI',sans-serif; background:#f9f9f9; margin:0; padding:0;">
    <div style="max-width:600px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

        <div style="background:#7a2f3b; color:#fff; padding:18px 25px;">
            <h2 style="margin:0;">🛍️ Cảm ơn bạn đã đặt hàng tại {{ config('app.name') }}!</h2>
        </div>

        <div style="padding:25px;">
            <p>Xin chào <strong>{{ $order->name }}</strong>,</p>
            <p>Chúng tôi đã nhận được đơn hàng của bạn. Dưới đây là thông tin chi tiết:</p>

            <table width="100%" style="border-collapse:collapse; margin-top:10px;">
                <thead>
                    <tr style="background:#f2d8dc; color:#7a2f3b;">
                        <th align="left" style="padding:8px;">Sản phẩm</th>
                        <th style="padding:8px;">Số lượng</th>
                        <th align="right" style="padding:8px;">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px;">{{ $item->product->name }}</td>
                            <td align="center" style="padding:8px;">{{ $item->quantity }}</td>
                            <td align="right" style="padding:8px;">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top:15px;">
                <strong>Tổng cộng:</strong> {{ number_format($order->final_total, 0, ',', '.') }} đ<br>
                <strong>Phương thức thanh toán:</strong> {{ strtoupper($order->payment_method) }}
            </p>

            <p>
                <strong>Địa chỉ giao hàng:</strong><br>
                {{ $order->address }}<br>
                SĐT: {{ $order->phone }}
            </p>

            <div style="text-align:center; margin-top:25px;">
                <a href="{{ route('orders.show', $order->id) }}" 
                   style="background:#7a2f3b; color:#fff; padding:10px 20px; 
                          border-radius:6px; text-decoration:none; display:inline-block;">
                    Xem chi tiết đơn hàng
                </a>
            </div>

            <p style="margin-top:30px;">💖 Cảm ơn bạn đã tin tưởng {{ config('app.name') }}!</p>
        </div>
    </div>
</body>
</html>