<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;

class UserHistoryController extends Controller
{
    public function index()
    {
        $histories = UserHistory::with(['order', 'coupon'])
            ->where('user_id', Auth::id())
            ->whereNotNull('order_id') // Chỉ lấy lịch sử có mã đơn hàng
            ->orderByDesc('used_at')
            ->paginate(10);

        return view('customer.histories.index', compact('histories'));
    }
}