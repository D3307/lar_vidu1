<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about()
    {
        return view('customer.about');
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lưu phản hồi vào DB hoặc gửi mail
            // Ví dụ tạm in ra log
            \Log::info('Phản hồi khách hàng:', $request->only('name', 'email', 'message'));

            return back()->with('success', 'Cảm ơn bạn đã gửi phản hồi cho chúng tôi!');
        }

        return view('customer.contact');
    }
}