<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    // Hiển thị trang chat tổng
    public function index(Request $request)
    {
        // Lấy danh sách khách hàng có tin nhắn
        $customers = User::whereHas('messages', function ($q) {
            $q->where('is_admin', false);
        })->get();

        // Xác định khách đang được chọn
        $selectedUserId = $request->query('user_id');
        $messages = collect();

        if ($selectedUserId) {
            $messages = Message::where('user_id', $selectedUserId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // 🔥 Đánh dấu là đã đọc tất cả tin nhắn của khách này
            Message::where('user_id', $selectedUserId)
                ->where('is_admin', false)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

        return view('admin.chat', compact('customers', 'messages', 'selectedUserId'));
    }

    // Gửi tin nhắn từ admin đến khách
    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        // Nếu có gửi kèm ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        Message::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'is_admin' => true,
            'image' => $imagePath ?? null,
        ]);

        return response()->json(['success' => true]);
    }

    // Lấy tin nhắn của 1 khách (dùng AJAX)
    public function fetch($userId)
    {
        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}