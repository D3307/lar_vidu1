<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Thêm ở đầu file nếu chưa có

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy 6 sản phẩm mới nhất
        $products = Product::orderBy('created_at', 'desc')->take(6)->get();
        return view('home', compact('products'));
    }
}
