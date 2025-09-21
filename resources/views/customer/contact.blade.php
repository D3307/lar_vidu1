@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="contact-hero">
    <h1 class="contact-main-title text-start">Địa chỉ liên hệ</h1>
    <p class="contact-desc text-start">
        Bạn có câu hỏi hoặc góp ý? Hãy liên hệ với chúng tôi bằng cách điền vào form bên dưới. Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.
    </p>
</div>

<div class="contact-map-section">
    <div class="contact-map-wrap">
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

<div class="contact-form-section" style="margin-top:40px;">
    <h2 class="contact-form-title">Gửi Email Cho Chúng Tôi</h2>
    <form method="POST" action="{{ route('customer.contact') }}" class="contact-form-main">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Nhập họ tên của bạn">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Nhập email của bạn">
            </div>
            <div class="col-12">
                <label for="message" class="form-label">Nội dung</label>
                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Nhập nội dung liên hệ"></textarea>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-send-custom">Gửi</button>
        </div>
    </form>
</div>

<style>
.contact-hero {
    margin-top: 32px;
    margin-bottom: 18px;
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
}
.contact-main-title {
    font-size: 2.0rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-align: left;
}
.contact-desc {
    color: #222;
    font-size: 1.08rem;
    font-weight: 500;
    margin-bottom: 0;
    text-align: left;
}
.contact-map-section {
    background: #faf7fa;
    padding: 0 0 36px 0;
}
.contact-map-wrap {
    max-width: 1100px;
    margin: 0 auto;
    height: 340px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 24px rgba(231,84,128,0.08);
}
.contact-map-wrap iframe {
    width: 100%;
    height: 100%;
    border: 0;
    filter: grayscale(0.1) brightness(0.98);
}
.contact-form-section {
    background: #fff;
    max-width: 900px;
    margin: 0 auto;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(231,84,128,0.08);
    padding: 38px 48px 32px 48px;
    margin-top: 40px;
    z-index: 3;
    position: relative;
}
.contact-form-title {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 28px;
    letter-spacing: 0.5px;
}
.contact-form-main .form-label {
    font-weight: 500;
    color: #222;
}
.contact-form-main .form-control:focus {
    border-color: #e75480;
    box-shadow: 0 0 0 0.08rem rgba(231,84,128,0.13);
}
.btn-send-custom {
    background: #e75480;
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    padding: 12px 48px;
    font-size: 1.1rem;
    transition: background 0.18s;
    box-shadow: 0 2px 8px rgba(231,84,128,0.04);
    letter-spacing: 1px;
}
.btn-send-custom:hover, .btn-send-custom:focus {
    background: #c13c6a;
    color: #fff;
}
@media (max-width: 900px) {
    .contact-map-wrap, .contact-form-section {
        padding: 10px 4px;
        max-width: 100%;
        border-radius: 0;
    }
    .contact-form-section {
        margin-top: 24px;
        padding: 18px 4px;
    }
    .contact-main-title {
        font-size: 1.3rem;
    }
}
</style>
@endsection