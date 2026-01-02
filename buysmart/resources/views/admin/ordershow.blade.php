{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

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
