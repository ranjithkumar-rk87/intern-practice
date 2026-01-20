@extends('layouts.app')

@section('title', 'History Details')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Order #{{ $histories->first()->order_id }}</h3>
        <a href="{{ route('history.index') }}" class="btn btn-secondary">← Back to History</a>
    </div>

    {{-- Timeline --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">Order Timeline</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $i => $history)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ ucfirst(str_replace('_',' ', $history->action)) }}</td>
                            <td>{{ ucfirst($history->status) }}</td>
                            <td>₹{{ number_format($history->total_amount, 2) }}</td>
                            <td>{{ $history->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header fw-bold">Delivery Address</div>
        <div class="card-body">
            <p class="mb-1"><strong>Phone:</strong> {{ $histories->first()->phone ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Address:</strong><br>
                {{ $histories->first()->address ?? 'N/A' }}<br>
                {{ $histories->first()->city ?? '' }},
                {{ $histories->first()->state ?? '' }} - {{ $histories->first()->pincode ?? '' }}
            </p>
        </div>
    </div>

    <div class="card border rounded mb-3">
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
                    @foreach($histories->first()->items ?? [] as $item)
                        @php $grandTotal += $item['subtotal']; @endphp
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₹{{ $item['price'] }}</td>
                            <td>₹{{ $item['subtotal'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Total --}}
    <div class="d-flex justify-content-end mb-5">
        <h5>Total: <span class="text-success">₹{{ $grandTotal }}</span></h5>
    </div>

 
</div>
@endsection
