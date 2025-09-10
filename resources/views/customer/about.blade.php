@extends('layouts.app')

@section('title', 'Về chúng tôi')

@section('content')
<div class="container py-4">
    <h1 class="mb-4" style="font-size: 1.8rem;">Giới thiệu về chúng tôi</h1>
    <p>
        Chào mừng bạn đến với cửa hàng bán giày cao gót của chúng tôi.  
        Chúng tôi cung cấp sản phẩm và dịch vụ chất lượng cao, với sứ mệnh mang lại sự hài lòng cho khách hàng.
    </p>

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
