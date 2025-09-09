<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller; // <-- thêm dòng này
use Illuminate\Http\Request;
use App\Models\Product;

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
        // Lấy 4 sản phẩm mới nhất
        $products = Product::latest()->take(4)->get();

        return view('home', compact('products'));
    }
}
