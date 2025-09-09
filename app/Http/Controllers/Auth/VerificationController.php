<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    /**
     * Xử lý xác minh email khi user click link trong mail
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = \App\Models\User::findOrFail($id);

        // Kiểm tra hash trong URL có khớp với email không
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.notice')->with('error', 'Liên kết xác minh không hợp lệ.');
        }

        // Nếu chưa xác minh thì cập nhật cột email_verified_at
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect()->route('home')->with('success', 'Email của bạn đã được xác minh.');
    }

    /**
     * Gửi lại email xác minh
     */
    public function send(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Đã gửi lại liên kết xác minh!');
    }
}
