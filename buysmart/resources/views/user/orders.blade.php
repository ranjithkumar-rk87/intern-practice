@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
<h3 class="mb-3">📦 My Orders</h3>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($orders->isEmpty())
    <div class="alert alert-warning">No orders found</div>
@else

<table class="table table-bordered align-middle text-center">
    <thead class="table-dark">
        <tr>
            <th>Order ID</th>
            <th>Total</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Date</th>
            <th width="180">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>₹{{ $order->total_amount }}</td>
            <td title="
                @foreach($order->items as $item)
                {{ $item->product->name }} × {{ $item->quantity }}
                @endforeach
                ">
                {{ $order->items->sum('quantity') }}
                </td>

            <td>
                <span class="badge 
                    {{ $order->status == 'pending' ? 'bg-warning' : 
                       ($order->status == 'confirmed' ? 'bg-info' : 'bg-success') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
            <td class="d-flex gap-2">

                <a href="{{ route('orders.show', $order->id) }}"
                   class="btn btn-sm btn-primary">
                    View
                </a>
                @if(in_array($order->status, ['confirmed', 'delivered']))
                    <a href="{{ route('orders.track', $order->id) }}"
                    class="btn btn-sm btn-success">
                        Track
                    </a>
                @endif

                @if($order->status === 'pending')
                    <form action="{{ route('orders.destroy', $order->id) }}"
                          method="POST"
                          onsubmit="return confirm('Cancel this order?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            Cancel
                        </button>
                    </form>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif
@endsection
