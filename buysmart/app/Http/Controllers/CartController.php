<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function cartList()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.cart', compact('cartItems'));
    }

public function remove($id)
{
    $cart = Cart::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

    $cart->delete();

    return redirect()->back()->with('success', 'Item removed from cart');
}
public function updateQty(Request $request, $id)
{
    $cartItem = Cart::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($request->action === 'increase') {
        $cartItem->quantity += 1;
    }

    if ($request->action === 'decrease') {
        $cartItem->quantity = max(1, $cartItem->quantity - 1);
    }

    $cartItem->save();

    return back()->with('success', 'Cart updated successfully');
}
}

