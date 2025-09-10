@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Liên hệ với chúng tôi</h1>

    <p>Nếu bạn có ý kiến đóng góp hay phản hồi về dịch vụ, vui lòng gửi thông tin bên dưới:</p>

    <form method="POST" action="{{ route('customer.contact') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Nội dung phản hồi</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
    </form>
</div>
@endsection