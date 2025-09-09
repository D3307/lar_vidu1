<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('customer.about');
    }

    public function contact()
    {
        return view('customer.contact');
    }
}