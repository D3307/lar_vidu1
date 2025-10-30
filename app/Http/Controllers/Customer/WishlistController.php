<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product', 'product.images')
            ->where('user_id', Auth::id())
            ->get();
        return view('customer.wishlist', compact('wishlists'));
    }

    // thêm Request $request vào tham số
    public function store(Request $request, $productId)
    {
        Wishlist::firstOrCreate([
            'user_id'   => Auth::id(),
            'product_id'=> $productId,
            'color'     => $request->color,
            'size'      => $request->size,
            'material'  => $request->material,
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    public function destroy($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
    }

    public function add(Request $request, $productId)
    {
        $request->validate([
            'color'    => 'required|string',
            'size'     => 'required|string',
            'material' => 'required|string',
        ]);

        Wishlist::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'product_id'=> $productId,
            ],
            [
                'color'     => $request->color,
                'size'      => $request->size,
                'material'  => $request->material,
            ]
        );

        return back()->with('success', 'Đã thêm sản phẩm vào danh sách yêu thích.');
    }
}