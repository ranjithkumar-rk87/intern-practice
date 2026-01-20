<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Address;
use App\Models\OrderHistory;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }

    public function updateQty(Request $request, Product $product)
    {
        $qty = (int) $request->quantity;

        if ($request->action === 'increase') $qty++;
        if ($request->action === 'decrease' && $qty > 1) $qty--;

        return back()->withInput(['quantity' => $qty]);
    }

    public function checkout()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $addresses = Address::where('user_id', Auth::id())->get();

        foreach ($addresses as $address) {
            $address->is_deliverable = \App\Models\Pincode::where('pincode', $address->pincode)
                ->where('is_active', 1)->exists();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        return view('user.checkout', compact('cartItems','addresses'));
    }

    public function placeorder(Request $request)
    {
        $request->validate([
            'selected_address' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cartItems = Auth::user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('success', 'Your cart is empty');
        }

        // Check stock
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart')->with(
                    'error',
                    'Only ' . $item->product->stock . ' stock available for ' . $item->product->name
                );
            }
            $item->product->decrement('stock', $item->quantity);
        }

        // Calculate total
        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $address = Address::where('id', $request->selected_address)
            ->where('user_id', Auth::id())->firstOrFail();

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'address_id' => $address->id,
            'phone' => $address->phone,
            'address' => $address->address,
            'city' => $address->city,
            'state' => $address->state,
            'pincode' => $address->pincode,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Save order items
        $itemsSnapshot = [];
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'product_name' => $item->product->name,
                'subtotal' => $item->product->price * $item->quantity,
            ]);

            $itemsSnapshot[] = [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity,
            ];
        }

        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'payment_method' => $order->payment_method,
            'phone' => $order->phone,
            'address' => $order->address,
            'city' => $order->city,
            'state' => $order->state,
            'pincode' => $order->pincode,
            'action' => 'created',
            'items' => $itemsSnapshot,
        ]);

        Auth::user()->carts()->delete();

        return redirect()->route('orderstatus')->with('success', 'Order Placed Successfully');
    }

    public function usershow($id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.ordershow', compact('order'));
    }

    public function orderStatus(Request $request)
    {
        $successMessage = $request->session()->get('success');
        return view('user.order_status', compact('successMessage'));
    }

   public function destroy($id)
{
    $order = Order::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    if ($order->status !== 'pending') {
        return back()->with('error', 'Order cannot be cancelled');
    }

    $itemsSnapshot = [];
    foreach ($order->items as $item) {
        if ($item->product) {
            $item->product->increment('stock', $item->quantity);
        }

        $itemsSnapshot[] = [
            'product_id' => $item->product_id,
            'product_name' => $item->product_name ?? $item->product->name,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'subtotal' => $item->subtotal,
        ];
    }

    OrderHistory::create([
        'order_id' => $order->id,
        'user_id' => $order->user_id,
        'total_amount' => $order->total_amount,
        'status' => 'cancelled',
        'payment_method' => $order->payment_method,
        'phone' => $order->phone,
        'address' => $order->address,
        'city' => $order->city,
        'state' => $order->state,
        'pincode' => $order->pincode,
        'action' => 'cancelled',
        'items' => $itemsSnapshot,
    ]);

    $order->items()->delete();
    $order->delete();

    return back()->with('success', 'Order cancelled successfully');
}


    public function track(Order $order)
    {
        return view('user.order_track', compact('order'));
    }
}
