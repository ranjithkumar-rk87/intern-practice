<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

        return view('admin.order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'user')
            ->findOrFail($id);

        return view('admin.ordershow', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated');
    }
    public function destroy($id)
{
        $order = Order::findOrFail($id);

        if ($order->status === 'delivered') {
            return back()->with('error', 'Delivered orders cannot be deleted');
        }

        $order->delete();

        return back()->with('success', 'Order deleted successfully');
}
}

