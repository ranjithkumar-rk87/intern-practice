<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
class WishlistController extends Controller
{
     public function store(Product $product)
    {
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist ❤️');
    }

    public function index()
    {
        $items = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return view('user.wishlist', compact('items'));
    }

    public function destroy(Product $product)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Removed from wishlist');
    }
}
