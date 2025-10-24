@extends('admin.layout')

@section('content')
<div class="container-fluid py-3">
    <h3 class="mb-4 fw-bold text-chat-title">
        💬 Chat với khách hàng
    </h3>

    <div class="row">
        <!-- Cột trái: danh sách khách hàng -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 chat-card-left">
                <div class="card-header text-white fw-semibold chat-list-header">
                    Danh sách khách hàng
                </div>
                <ul class="list-group list-group-flush customer-list">
                    @forelse($customers as $c)
                        <a href="{{ route('admin.chat', ['user_id' => $c->id]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $selectedUserId == $c->id ? 'active' : '' }}">
                            <span>
                                <i class="bi bi-person-circle me-2"></i> {{ $c->name }}
                            </span>
                            @if($selectedUserId == $c->id)
                                <span class="badge badge-chat-active">Đang chat</span>
                            @endif
                        </a>
                    @empty
                        <li class="list-group-item text-muted text-center py-3">Chưa có khách nào nhắn tin</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Cột phải: khung chat -->
        <div class="col-md-9">
            @if($selectedUserId)
                <div class="card shadow-sm border-0 chat-card">
                    <div class="card-header chat-header fw-semibold">
                        💬 Đang chat với: 
                        <span class="chat-user-name">{{ $customers->where('id', $selectedUserId)->first()->name ?? 'Không rõ' }}</span>
                    </div>
                    <div class="card-body chat-box" id="chat-messages">
                        @foreach($messages as $msg)
                            <div class="message {{ $msg->is_admin ? 'admin-msg' : 'user-msg' }}">
                                <div class="bubble">
                                    <strong>{{ $msg->is_admin ? 'Admin' : 'Khách' }}:</strong> {{ $msg->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer chat-footer">
                        <form id="chat-form" class="d-flex flex-column gap-2" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex gap-2 align-items-center">
                                <input type="hidden" name="user_id" value="{{ $selectedUserId }}">

                                <input type="text" name="message" id="message" 
                                    class="form-control rounded-pill chat-input" 
                                    placeholder="Nhập tin nhắn...">

                                <!-- Nút chọn ảnh -->
                                <label for="image" class="btn btn-light border rounded-pill">
                                    📷
                                    <input type="file" name="image" id="image" accept="image/*" hidden>
                                </label>

                                <button type="submit" class="btn chat-btn-send rounded-pill px-4">
                                    <i class="bi bi-send"></i> Gửi
                                </button>
                            </div>
                            <small class="text-muted" id="file-name" style="margin-left:5px;"></small>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-light text-center py-5 shadow-sm rounded-3 chat-empty">
                    👈 Hãy chọn một khách hàng ở bên trái để xem và trả lời tin nhắn.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if($selectedUserId)
<script>
function fetchMessages(){
    $.get("{{ route('admin.chat.fetch', $selectedUserId) }}", function(data){
        let html = '';
        data.forEach(msg => {
            html += `<div class="message ${msg.is_admin ? 'admin-msg' : 'user-msg'}">
                        <div class="bubble">
                            <strong>${msg.is_admin ? 'Admin' : 'Khách'}:</strong> 
                            ${msg.message ? msg.message : ''}
                            ${msg.image ? 
                                `<div class="mt-2">
                                    <img src="/storage/${msg.image}" 
                                         style="max-width:200px; border-radius:10px;">
                                </div>` 
                            : ''}
                        </div>
                    </div>`;
        });
        $('#chat-messages').html(html);
        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    });
}

$('#image').on('change', function(){
    let file = this.files[0];
    if(file){
        $('#file-name').text('Đã chọn: ' + file.name);
    } else {
        $('#file-name').text('');
    }
});

$('#chat-form').submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.chat.send') }}",
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

setInterval(fetchMessages, 3000);
</script>
@endif

<style>
.text-chat-title {
    color: #e74c7e !important;
}

.chat-card, .chat-card-left {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(231, 76, 126, 0.1);
}

.chat-list-header {
    background: linear-gradient(90deg, #f48fb1, #ec407a);
    border: none;
}

.badge-chat-active {
    background: #e74c7e;
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 4px 8px;
}

.customer-list a.active {
    background-color: #fff;
    color: #000 !important;
    font-weight: 600;
}

.customer-list a:hover {
    background-color: #fde4ec !important;
}
.chat-header {
    background: #fde9ef !important;
    color: #a62c58 !important;
    border-bottom: 1px solid #f5c4d2;
}

.chat-user-name {
    color: #000;
    font-weight: 600;
}

.chat-box {
    height: 450px;
    overflow-y: auto;
    background: #fff;
    padding: 15px 20px;
    border-radius: 0;
}

.message {
    display: flex;
    margin-bottom: 10px;
}

.message.admin-msg {
    justify-content: flex-end;
}

.message.user-msg {
    justify-content: flex-start;
}

.message .bubble {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 18px;
    line-height: 1.4;
    font-size: 15px;
}

.admin-msg .bubble {
    background: #e74c7e;
    color: #fff;
    border-top-right-radius: 0;
    box-shadow: 0 1px 4px rgba(231, 76, 126, 0.3);
}

.user-msg .bubble {
    background: #f5e6eb;
    color: #333;
    border-top-left-radius: 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* ✉️ FORM NHẬP TIN NHẮN */
.chat-footer {
    background: #fff;
    border-top: 1px solid #f3c3d0;
}

.chat-input {
    font-size: 15px;
    border-radius: 25px !important;
    border: 1px solid #f3c3d0;
}

.chat-btn-send {
    background-color: #e74c7e !important;
    border-color: #e74c7e !important;
    color: #fff;
}

.chat-btn-send:hover {
    background-color: #d13e70 !important;
}

.chat-empty {
    color: #a62c58;
    background: #fff7f9;
    border: 1px solid #f3c3d0;
}
</style>
@endsection