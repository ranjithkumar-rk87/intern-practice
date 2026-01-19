@extends('layouts.app')

@section('title', 'Track Order')

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">🚚 Track Order #{{ $order->id }}</h3>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to Orders
        </a>
    </div>

    {{-- Order Card --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Status --}}
            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge 
                    {{ $order->status === 'delivered' ? 'bg-success' : 'bg-warning text-dark' }} text-uppercase">
                    {{ str_replace('_',' ', $order->status) }}
                </span>
            </div>

            <p class="text-muted mb-4">
                Last Updated: {{ $order->updated_at->format('d M Y, h:i A') }}
            </p>

            @php
                $steps = [
                    'placed' => 'Order Placed',
                    'confirmed' => 'Confirmed',
                    'delivered' => 'Delivered',
                ];

                $currentStep = array_search($order->status, array_keys($steps));
                $totalSteps = count($steps) - 1;
                $progress = ($currentStep / $totalSteps) * 100;
            @endphp

            {{-- Progress Bar --}}
            <div class="progress mb-4">
                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $progress }}%"
                    aria-valuenow="{{ $progress }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                </div>
            </div>

            <div class="row text-center small fw-semibold mb-4">
                @foreach($steps as $key => $label)
                    @php $index = array_search($key, array_keys($steps)); @endphp
                    <div class="col">
                        @if($index <= $currentStep)
                            <span class="text-success">✔ {{ $label }}</span>
                        @else
                            <span class="text-muted">{{ $label }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <strong>Delivery Address:</strong>
                <p class="mb-1">
                    @if($order->deliveryAddress)
                        {{ $order->deliveryAddress->address }},
                        {{ $order->deliveryAddress->city }},
                        {{ $order->deliveryAddress->state }} -
                        {{ $order->deliveryAddress->pincode }}
                    @else
                        {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}
                    @endif
                </p>
            </div>

            {{-- Ordered Items --}}
            <div class="mb-3">
                <strong>Items:</strong>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->product->name ?? 'Product' }} (x{{ $item->quantity }})
                            <span>₹{{ number_format($item->price, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="text-end mt-3">
                <strong>Total Amount: ₹{{ number_format($order->total_amount, 2) }}</strong>
            </div>

        </div>
    </div>

</div>
@endsection
