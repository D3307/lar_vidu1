<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\UserHistory;

class AccountController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $histories = UserHistory::with(['coupon', 'order'])
            ->where('user_id', $user->id)
            ->whereNotNull('order_id')
            ->orderBy('used_at', 'desc')
            ->get()
            ->sortByDesc(fn($h) => !is_null($h->coupon_id)) // Ưu tiên bản ghi có coupon_id
            ->unique('order_id') // Lọc trùng theo order_id
            ->values();

        // Nếu muốn phân trang, dùng LengthAwarePaginator:
        $perPage = 5;
        $page = request()->get('page', 1);
        $pagedHistories = new \Illuminate\Pagination\LengthAwarePaginator(
            $histories->forPage($page, $perPage),
            $histories->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('customer.accounts.edit', [
            'user' => $user,
            'histories' => $pagedHistories
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('accounts.edit')->with('success', 'Cập nhật thông tin thành công!');
    }
}