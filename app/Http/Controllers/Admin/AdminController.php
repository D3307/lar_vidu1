<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // trả về view dashboard admin (tạo file views nếu chưa có)
        return view('admin.dashboard');
    }
}
