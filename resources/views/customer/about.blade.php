@extends('layouts.app')

@section('title', 'Về chúng tôi')

@section('content')
<div class="container py-4 about-policy">
    <div class="about-card">
        <h1 class="mb-4 about-title">
            Chính sách đổi trả
        </h1>
        <div class="mb-4 about-content">
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
                <li>Hàng mua trực tiếp tại cửa hàng: <span class="about-highlight">Đổi trả trực tiếp tại cửa hàng.</span></li>
                <li>Hàng mua online (website, Shopee, Lazada): <span class="about-highlight">Liên hệ shop qua email hoặc số điện thoại để được đổi trả.</span></li>
            </ul>
            <h5 class="mt-3">3. Chi phí đổi hàng</h5>
            <ul>
                <li><span class="about-highlight">Miễn phí đổi hàng</span> cho khách mua ở shop trong trường hợp bị lỗi từ nhà sản xuất, giao nhầm hàng, bị hư hỏng trong quá trình vận chuyển.</li>
                <li>Trường hợp không vừa size hoặc khách không ưng sản phẩm, khách hàng vui lòng trả phí vận chuyển hoàn đơn về cửa hàng.</li>
            </ul>
        </div>
    </div>
</div>
<style>
.about-policy {
    background: #faf7fa;
    min-height: 100vh;
}
.about-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(231,84,128,0.08);
    padding: 36px 48px 28px 48px;
    max-width: 950px;
    margin: 0 auto;
}
.about-title {
    color: #222;
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}
.about-content h5 {
    color: #222;
    font-weight: 600;
    margin-top: 22px;
    margin-bottom: 10px;
}
.about-content ul {
    margin-bottom: 14px;
    padding-left: 22px;
}
.about-content li {
    margin-bottom: 7px;
    font-size: 1.08rem;
    color: #222;
    line-height: 1.7;
}
.about-content strong {
    color: #222;
}
.about-highlight {
    color: #e75480;
    font-weight: 600;
}
@media (max-width: 900px) {
    .about-card {
        padding: 18px 8px;
        max-width: 100%;
    }
    .about-title {
        font-size: 1.3rem;
    }
}
</style>
@endsection
