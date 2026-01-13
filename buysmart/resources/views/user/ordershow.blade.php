@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Order #{{ $order->id }}</h3>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        ← Back to Orders
    </a>
</div>

{{-- Order Info --}}
<div class="card mb-3">
    <div class="card-header fw-bold">Order Info</div>
    <div class="card-body">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        <p><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</p>
    </div>
</div>

{{-- Delivery Address --}}
@php
$addr = $order->deliveryAddress ?? null;
@endphp

<div class="card mb-3">
    <div class="card-header fw-bold">Delivery Address</div>
    <div class="card-body">
        <p class="mb-1"><strong>Name:</strong> {{ $addr->full_name ?? $order->user->name }}</p>
        <p class="mb-1"><strong>Phone:</strong> {{ $addr->phone ?? $order->phone ?? 'N/A' }}</p>
        <p class="mb-0"><strong>Address:</strong><br>
            {{ $addr->address ?? $order->address ?? 'N/A' }}<br>
            {{ $addr->city ?? $order->city ?? '' }},
            {{ $addr->state ?? $order->state ?? '' }} - {{ $addr->pincode ?? $order->pincode ?? '' }}
        </p>
    </div>
</div>

{{-- Order Items --}}
<div class="card mb-3">
    <div class="card-header fw-bold">Order Items</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($order->items as $item)
                    @php $subtotal = $item->price * $item->quantity; $grandTotal += $subtotal; @endphp
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ $item->price }}</td>
                        <td>₹{{ $subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-end mb-5">
    <h5>Total: <span class="text-success">₹{{ $grandTotal }}</span></h5>
</div>
</div>
@endsection
