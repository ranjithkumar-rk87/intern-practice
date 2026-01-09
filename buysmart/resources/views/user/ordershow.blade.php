@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Order #{{ $order->id }}</h3>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        ← Back to Orders
    </a>
</div>

<h3>Order #{{ $order->id }}</h3>
<p>Status: {{ ucfirst($order->status) }}</p>
<p>Total: ₹{{ $order->total_amount }}</p>

@php $detail = $order->user->detail; @endphp


<div class="card mb-3">
    <div class="card-header fw-bold">
        Delivery Address
    </div>

    <div class="card-body">
        <p class="mb-1">
            <strong>Name:</strong> {{ $order->user->name }}
        </p>

        <p class="mb-1">
            <strong>Phone:</strong> {{ $detail->phone ?? 'N/A' }}
        </p>

        <p class="mb-0">
            <strong>Address:</strong><br>
            {{ $detail->address ?? 'N/A' }}<br>
            {{ $detail->city ?? '' }},
            {{ $detail->state ?? '' }} - {{ $detail->pincode ?? '' }}
        </p>
    </div>
</div>

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
