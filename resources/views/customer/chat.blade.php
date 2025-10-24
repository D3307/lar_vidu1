@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- CỘT TRÁI: FAQs -->
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body">
                    <h4 class="fw-bold mb-3" style="color:#7a2f3b;">
                        💖 Câu hỏi thường gặp
                    </h4>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    Chính sách đổi trả sản phẩm?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể đổi trả trong vòng <strong>7 ngày</strong> kể từ khi nhận hàng, 
                                    với điều kiện sản phẩm còn nguyên tem, tag và chưa qua sử dụng.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    Phí vận chuyển và thời gian giao hàng?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Miễn phí giao hàng cho đơn từ <strong>500.000₫</strong>.  
                                    Thời gian giao hàng từ <strong>1–3 ngày</strong> tùy khu vực.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    Làm sao để biết kích thước phù hợp?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ở mỗi sản phẩm, chúng tôi có bảng <strong>hướng dẫn chọn size</strong> chi tiết.  
                                    Nếu vẫn chưa chắc, bạn có thể chat trực tiếp với chúng tôi để được tư vấn.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    Sản phẩm có giống hình không?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Chúng tôi cam kết sản phẩm <strong>100% giống hình</strong> và được chụp thực tế tại studio của shop.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                    Có hỗ trợ gói quà hoặc thiệp chúc mừng không?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có 💝 Chúng tôi hỗ trợ <strong>gói quà miễn phí</strong> và có thể đính kèm thiệp chúc mừng theo yêu cầu.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: CHAT -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0" style="border-radius:16px;">
                <div class="card-body">
                    <h4 class="fw-bold mb-3" style="color:#7a2f3b;">💬 Chat với chúng tôi</h4>

                    <!-- Khung tin nhắn -->
                    <div id="chat-messages" style="
                        height: 350px;
                        overflow-y: auto;
                        background: #fff;
                        border: 1px solid #f3c3d0;
                        border-radius: 12px;
                        padding: 15px;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                        margin-bottom: 12px;
                    ">
                        @foreach($messages as $msg)
                            <div class="message {{ $msg->is_admin ? 'admin-msg' : 'user-msg' }}">
                                <div class="bubble">
                                    <strong>{{ $msg->is_admin ? 'Admin' : 'Bạn' }}:</strong>
                                    @if($msg->message)
                                        {{ $msg->message }}
                                    @endif

                                    @if($msg->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $msg->image) }}" 
                                                 alt="Hình ảnh" style="max-width: 200px; border-radius:10px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Form gửi tin -->
                    <form id="chat-form" class="d-flex flex-column gap-2" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex gap-2">
                            <input type="text" name="message" id="message" 
                                class="form-control" placeholder="Nhập tin nhắn..." 
                                style="border-radius: 25px; border: 1px solid #f3c3d0; font-size: 15px;">
                            
                            <label for="image" class="btn btn-light border" 
                                   style="border-radius: 25px;">
                                📷
                                <input type="file" name="image" id="image" accept="image/*" hidden>
                            </label>

                            <button type="submit" 
                                    class="btn px-4"
                                    style="background-color:#e74c7e; color:#fff; border-radius:25px; font-weight:600;">
                                <i class="bi bi-send"></i> Gửi
                            </button>
                        </div>
                        <small class="text-muted" id="file-name" style="margin-left:5px;"></small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#image').on('change', function(){
    let file = this.files[0];
    $('#file-name').text(file ? 'Đã chọn: ' + file.name : '');
});

$('#chat-form').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('customer.chat.send') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(){
            $('#message').val('');
            $('#image').val('');
            $('#file-name').text('');
            fetchMessages();
        }
    });
});

function fetchMessages(){
    $.get("{{ route('customer.chat.fetch') }}", function(data){
        let html = '';
        data.forEach(msg => {
            html += `<div class="message ${msg.is_admin ? 'admin-msg' : 'user-msg'}">
                        <div class="bubble">
                            <strong>${msg.is_admin ? 'Admin' : 'Bạn'}:</strong>
                            ${msg.message ? msg.message : ''}
                            ${msg.image ? 
                                `<div class="mt-2">
                                    <img src="/storage/${msg.image}" style="max-width:200px; border-radius:10px;">
                                </div>` 
                            : ''}
                        </div>
                    </div>`;
        });
        $('#chat-messages').html(html);
        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    });
}

setInterval(fetchMessages, 3000);
</script>

<style>
.message { display: flex; margin-bottom: 10px; }
.message.admin-msg { justify-content: flex-end; }
.message.user-msg { justify-content: flex-start; }
.message .bubble {
    max-width: 75%;
    padding: 10px 15px;
    border-radius: 18px;
    line-height: 1.4;
    font-size: 15px;
}
.user-msg .bubble {
    background: #f8e4ea;
    color: #333;
    border-top-left-radius: 0;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.admin-msg .bubble {
    background: #e74c7e;
    color: #fff;
    border-top-right-radius: 0;
    box-shadow: 0 1px 5px rgba(231, 76, 126, 0.3);
}
.accordion-button:not(.collapsed) {
    color: #7a2f3b;
    background-color: #fce8ee;
}
</style>
@endsection