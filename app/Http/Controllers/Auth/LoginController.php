<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectToUser = '/home';
    protected $redirectToAdmin = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Hiển thị form login
    public function showLoginForm()
    {
        return view('auth.login'); // form login chung user/admin
    }

    // Xử lý login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember'); // checkbox remember me

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect theo role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended($this->redirectToAdmin);
            }

            return redirect()->intended($this->redirectToUser);
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email', 'remember'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcomeweb');
    }
}
