@extends('layouts.app')

@section('title', 'Về chúng tôi')

@section('content')
<div class="container py-4">
    <h1 class="mb-4" style="font-size: 1.8rem;">Chính sách đổi trả</h1>
    <div class="mb-4" style="line-height:1.7;">
        <h5>1. Chính sách đổi sản phẩm</h5>
        <strong>a. Đổi size</strong>
        <ul>
            <li>Áp dụng 01 lần đổi / 1 đơn hàng với các đơn hàng mua online và tại cửa hàng.</li>
            <li>Sản phẩm đổi trong thời gian <strong>3 ngày</strong> kể từ ngày mua hàng trên hóa đơn (đối với khách mua trực tiếp), <strong>3 ngày</strong> kể từ ngày nhận hàng (đối với khách mua online).</li>
            <li>Sản phẩm còn mới, nguyên tem, tags, mang theo hóa đơn mua hàng, chưa giặt, không dơ bẩn, hư hỏng bởi tác nhân bên ngoài sau khi mua hàng.</li>
        </ul>
        <strong>b. Đổi sản phẩm lỗi</strong>
        <ul>
            <li><strong>Điều kiện áp dụng:</strong> Sản phẩm lỗi kỹ thuật (rách, bung keo, ...).</li>
            <li><strong>Không áp dụng:</strong> Sản phẩm đã qua sử dụng.</li>
            <li>Phản hồi đến shop trong vòng <strong>3 ngày</strong> kể từ ngày mua hàng trên hóa đơn (khách mua trực tiếp), <strong>3 ngày</strong> kể từ ngày nhận hàng (khách mua online).</li>
        </ul>
        <h5 class="mt-3">2. Phương thức đổi sản phẩm</h5>
        <ul>
            <li>Hàng mua trực tiếp tại cửa hàng: Đổi trả trực tiếp tại cửa hàng.</li>
            <li>Hàng mua online (website, Shopee, Lazada): Liên hệ shop qua email hoặc số điện thoại để được đổi trả.</li>
        </ul>
        <h5 class="mt-3">3. Chi phí đổi hàng</h5>
        <ul>
            <li>Miễn phí đổi hàng cho khách mua ở shop trong trường hợp bị lỗi từ nhà sản xuất, giao nhầm hàng, bị hư hỏng trong quá trình vận chuyển.</li>
            <li>Trường hợp không vừa size hoặc khách không ưng sản phẩm, khách hàng vui lòng trả phí vận chuyển hoàn đơn về cửa hàng.</li>
        </ul>
    </div>

    <h4 class="mt-4">Địa chỉ liên hệ</h4>
    <p><strong>Địa chỉ:</strong> 41A, Phú Diễn, Bắc Từ Liêm, Hà Nội</p>
    <p><strong>Số điện thoại:</strong> 0123 456 789</p>
    <p><strong>Email:</strong> info@giaycaogot.com</p>

    <div style="width: 100%; height: 350px;" class="mt-3">
        <iframe
            width="100%"
            height="100%"
            frameborder="0"
            style="border:0"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3873.7765318273246!2d105.7617326108948!3d21.0534854868478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454dc7ef09531%3A0x814cc26d6bf2aa49!2zNDFBIMSQLiBQaMO6IERp4buFbiwgUGjDuiBEaeG7hW4sIELhuq9jIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e1!3m2!1svi!2s!4v1757502007239!5m2!1svi!2s">
        </iframe>
    </div>
</div>
@endsection
