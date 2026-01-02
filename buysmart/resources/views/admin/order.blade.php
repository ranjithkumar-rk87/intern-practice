@extends('layouts.app')

@section('title', 'Admin Orders')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<h3>📦 All Orders</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th width="160">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>₹{{ $order->total_amount }}</td>
            <td>
                <span class="badge bg-info">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
            <td class="d-flex gap-2">
                <a href="{{ route('admin.orders.show', $order->id) }}"
                   class="btn btn-sm btn-primary">
                    View
                </a>
                 <form action="{{ route('admin.orders.destroy', $order->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this order permanently?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
