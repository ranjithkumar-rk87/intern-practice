<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }
    public function store()
    {
        $cartItems = Auth::user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('success', 'Your cart is empty');
        }

        // Calculate total
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Clear cart
        Auth::user()->carts()->delete();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully');
    }
    public function usershow($id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.ordershow', compact('order'));
    }
    public function buyNow($id)
{
    $product = Product::findOrFail($id);

    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $product->price,
        'status' => 'pending',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => $product->price,
    ]);

    return redirect()->route('orders.show', $order->id)
        ->with('success', 'Order placed successfully');
}
    public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order cannot be cancelled');
        }
        
        $order->items()->delete();

        $order->delete();

        return back()->with('success', 'Order cancelled successfully');
    }
}
