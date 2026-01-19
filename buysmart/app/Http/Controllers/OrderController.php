<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Address;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        // dd($orders);
        // exit();

        return view('user.orders', compact('orders'));
    }
    public function updateQty(Request $request, Product $product)
    {
        $qty = (int) $request->quantity;

        if ($request->action === 'increase') {
            $qty++;
        }

        if ($request->action === 'decrease' && $qty > 1) {
            $qty--;
        }

        return back()->withInput(['quantity' => $qty]);
    }
    public function checkout(){
         $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $addresses = Address::where('user_id', auth()->id())->get();

         foreach ($addresses as $address) {
            $address->is_deliverable = \App\Models\Pincode::where('pincode', $address->pincode)
                ->where('is_active', 1)
                ->exists();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Your cart is empty');
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
            return redirect()->route('cart')
                ->with('success', 'Your cart is empty');
        }
         foreach ($cartItems as $item) {

            if ($item->product->stock < $item->quantity) {
                DB::rollBack();

                return redirect()->route('cart')->with(
                    'error',
                    'Only ' . $item->product->stock .
                    ' stock available for ' . $item->product->name
                );
            }
            $item->product->decrement('stock', $item->quantity);
        }

        // Calculate total
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        $address = Address::where('id', $request->selected_address)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'address_id'     => $address->id,
            'phone'          => $address->phone,
            'address'        => $address->address,
            'city'           => $address->city,
            'state'          => $address->state,
            'pincode'        => $address->pincode,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'product_name' => $item->product->name,
                'subtotal'     => $item->product->price * $item->quantity,
            ]);
        }

        // Clear cart
        Auth::user()->carts()->delete();

        // return redirect()->route('orders.show', $order->id)
        //     ->with('success', 'Order placed successfully');
        return redirect()->route('orderstatus')->with('success','Order Placed Successfully');
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


    public function buyNow(Request $request,$id)
{
    $product = Product::findOrFail($id);

     if ($product->stock <= 0) {
        return back()->with('error', 'Product is out of stock');
    }

    $quantity = $request->quantity ?? 1;

    if ($quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available');
        }

    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $product->price,
        'status' => 'pending',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' =>  $quantity,
        'price' => $product->price,
    ]);
    $product->decrement('stock', $quantity);

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
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
        
        $order->items()->delete();

        $order->delete();

        return back()->with('success', 'Order cancelled successfully');
    }
    public function track(Order $order)
{
    return view('user.order_track', compact('order'));
}
}
