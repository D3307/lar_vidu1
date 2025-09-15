<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .invoice-box {
            width: 100%;
            padding: 10px;
            border: 1px solid #000;
        }
        .section {
            margin-bottom: 10px;
        }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; color: #d35400; }
        .row { display: flex; justify-content: space-between; }
        .col { width: 48%; }
        .barcode, .qrcode { text-align: center; margin: 10px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 5px; text-align: center; }
        .total { text-align: right; font-weight: bold; font-size: 16px; margin-top: 10px; }
        .footer { font-size: 12px; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="invoice-box">

        {{-- Header --}}
        <div class="header">
            <h2>Bridal Shop</h2>
            <p>Mã vận đơn: SPX{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
            <p>Mã đơn hàng: {{ $order->id }}</p>
        </div>

        {{-- Barcode (giả lập bằng mã đơn hàng) --}}
        <div class="barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG((string)$order->id, 'C128') }}" alt="barcode" height="50">
        </div>

        {{-- Thông tin người bán & người mua --}}
        <div class="row section">
            <div class="col">
                <strong>Người bán:</strong><br>
                Bridal Shop<br>
                Địa chỉ: 123 Quang Trung, Hà Nội<br>
                SĐT: 0987654321
            </div>
            <div class="col">
                <strong>Người mua:</strong><br>
                {{ $order->name }}<br>
                {{ $order->address }}<br>
                SĐT: {{ $order->phone }}
            </div>
        </div>

        {{-- Sản phẩm trong đơn --}}
        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>SL</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'SP đã xóa' }}</td>
                            <td>{{ $item->color ?? '-' }}</td>
                            <td>{{ $item->size ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- QR Code --}}
        <div class="qrcode">
            {!! QrCode::size(120)->generate('Order-'.$order->id) !!}
            <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        {{-- Tổng tiền --}}
        <div class="total">
            Tổng cộng: {{ number_format($order->final_total, 0, ',', '.') }} đ
        </div>

        {{-- Footer --}}
        <div class="footer">
            Kiểm tra sản phẩm khi nhận hàng. Liên hệ CSKH Shopee khi có vấn đề phát sinh.
        </div>
    </div>
</body>
</html>