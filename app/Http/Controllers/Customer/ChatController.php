<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Hiển thị giao diện chat của khách
    public function index()
    {
        $messages = Message::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('customer.chat', compact('messages'));
    }

    public function send(Request $request)
    {
        // ✅ Kiểm tra dữ liệu đầu vào
        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // ảnh <= 2MB
        ]);

        // ✅ Khởi tạo tin nhắn mới
        $message = new Message();
        $message->user_id = Auth::id();
        $message->is_admin = false;
        $message->message = $request->message;

        // ✅ Nếu người dùng có chọn ảnh thì lưu ảnh vào thư mục storage/app/public/chat_images
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chat_images', 'public');
            $message->image = $path; // lưu đường dẫn tương đối vào DB (vd: chat_images/abc.jpg)
        }

        // ✅ Lưu vào database
        $message->save();

        return response()->json(['success' => true]);
    }

    // Lấy danh sách tin nhắn (dùng AJAX)
    public function fetch()
    {
        return response()->json(
            Message::where('user_id', Auth::id())
                ->orderBy('created_at', 'asc')
                ->get()
        );
    }
}