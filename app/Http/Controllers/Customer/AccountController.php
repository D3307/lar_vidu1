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

        // Lấy lịch sử của user hiện tại
        $histories = UserHistory::with(['coupon', 'order'])
            ->where('user_id', $user->id)
            ->orderBy('used_at', 'desc')
            ->paginate(5);

        return view('customer.accounts.edit', compact('user', 'histories'));
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