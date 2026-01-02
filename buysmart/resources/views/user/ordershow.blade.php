@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<h3>Order #{{ $order->id }}</h3>
<p>Status: {{ ucfirst($order->status) }}</p>
<p>Total: ₹{{ $order->total_amount }}</p>

<table class="table">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
    </tr>
    @foreach($order->items as $item)
    <tr>
        <td>{{ $item->product->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>₹{{ $item->price }}</td>
    </tr>
    @endforeach
</table>
@endsection
