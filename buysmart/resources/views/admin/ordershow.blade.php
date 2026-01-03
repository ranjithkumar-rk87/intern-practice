{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">
    ← Back to Orders
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<h3>Order #{{ $order->id }}</h3>

<p><strong>User:</strong> {{ $order->user->name }}</p>
<p><strong>Total:</strong> ₹{{ $order->total_amount }}</p>

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

<form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
    @csrf

    <label>Status</label>
    <select name="status" class="form-select w-25">
        <option value="pending" @selected($order->status=='pending')>Pending</option>
        <option value="Confirmed" @selected($order->status=='Confirmed')>Confirmed</option>
        <option value="delivered" @selected($order->status=='delivered')>Delivered</option>
    </select>

    <button class="btn btn-success mt-2">Update Status</button>
</form>

<hr>

<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₹{{ $item->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
