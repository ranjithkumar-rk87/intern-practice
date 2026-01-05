<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request,$productId)
    {
        $userId = Auth::id();

        $quantity = $request->quantity ?? 1;

        $product = Product::findOrFail($productId);

        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            if (($cart->quantity + $quantity) > $product->stock) {
                return back()->with('error', 'Stock limit exceeded');
            }
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
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

    $product = $cartItem->product;

    if ($request->action === 'increase') {

        if ($cartItem->quantity < $product->stock) {
            $cartItem->quantity += 1;
        } else {
            return back()->with('error', 'Only ' . $product->stock . ' items available in stock');
        }
    }

    if ($request->action === 'decrease') {
        $cartItem->quantity = max(1, $cartItem->quantity - 1);
    }

    $cartItem->save();

    return back()->with('success', 'Cart updated successfully');
}
}

