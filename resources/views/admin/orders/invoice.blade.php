<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Vận đơn #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        .invoice {
            width: 128mm;
            margin: 0 auto;
            border: 1px solid #000;
            box-sizing: border-box;
            padding: 5mm;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 18px;
            font-weight: bold;
        }
        .tracking {
            text-align: right;
        }
        .tracking p {
            margin: 0;
            line-height: 1.3;
        }
        .section {
            border-bottom: 1px solid #000;
            padding: 4px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col {
            width: 50%;
        }
        .bold {
            font-weight: bold;
        }
        .center {
            text-align: center;
        }
        .bigcode {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 3px 0;
        }
        .midcode {
            font-size: 12px;
            font-weight: bold;
            text-align: right;
        }
        .qrcode {
            text-align: center;
            margin-top: 5px;
        }
        .qrcode img {
            width: 70px;
            height: 70px;
        }
        .product {
            margin-top: 3px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .product ul {
            margin: 4px 0 0 15px;
            padding: 0;
        }
        .footer {
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #000;
            margin-top: 5px;
            padding-top: 3px;
        }
        @page {
            size: A5 portrait;
            margin: 5mm;
        }
    </style>
</head>
<body>
    <div class="invoice">

        {{-- HEADER --}}
        <div class="header">
            <div class="logo">
                <strong>Bridal Shop</strong>
            </div>
            <div class="tracking">
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG((string)$order->id, 'C128', 1.6, 50) }}" alt="barcode"><br>
                <p><strong>Mã vận đơn:</strong> SPX{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
            </div>
        </div>

        {{-- FROM / TO --}}
        <div class="section">
            <div class="row">
                <div class="col">
                    <strong>Từ:</strong><br>
                    Bridal Shop<br>
                    ĐC: 41A, Phú Diễn, Bắc Từ Liêm, Hà Nội<br>
                    SĐT: 0987654321
                </div>
                <div class="col">
                    <strong>Đến:</strong><br>
                    {{ $order->name }}<br>
                    {{ $order->address }}<br>
                    SĐT: {{ $order->phone }}
                </div>
            </div>
        </div>

        {{-- PRODUCT LIST --}}
        <div class="section product">
            <strong>Nội dung hàng (SL: {{ $order->items->sum('quantity') }}):</strong>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->product->name ?? 'SP đã xóa' }}, SL: {{ $item->quantity }}</li>
                @endforeach
            </ul>
        </div>

        {{-- QR + NGÀY --}}
        <div class="section row" style="align-items: center;">
            <div class="col qrcode">
                <img src="{{ public_path('storage/qrcode.png') }}" alt="QR Code">
            </div>
            <div class="col" style="text-align:right;">
                <p class="bold">Mã nội bộ: HC-{{ $order->id }}-GV10R</p>
                <p><strong>Ngày đặt:</strong><br>{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- TOTAL --}}
        <div class="section">
            <p><strong>Tiền thu người nhận:</strong> 
               {{ $order->final_total > 0 ? number_format($order->final_total, 0, ',', '.') . ' đ' : '0 VND' }}</p>
            <p><strong>Khối lượng tối đa:</strong> 320g</p>
            <p><strong>Ghi chú giao hàng:</strong> Được đồng kiểm</p>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            Kiểm tra sản phẩm khi nhận hàng. Liên hệ shop khi có vấn đề.
        </div>
    </div>
</body>
</html>