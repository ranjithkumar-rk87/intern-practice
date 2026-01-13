@extends('layouts.app')

@section('title', 'Order Status')

@section('content')
<div class="container my-5">

    {{-- Display Success Message --}}
    @if($successMessage)
        <div class="alert alert-success text-center">
            {{ $successMessage }}
        </div>
    @endif

    <div class="card shadow-sm text-center p-4 mb-3">
        <h3>Thank you! 🎉</h3>
        <p>Your order has been placed successfully.</p>

        <div class="d-flex justify-content-center gap-2">
            <a href="{{ url('/') }}" class="btn btn-primary btn-sm">Continue Shopping</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">View My Orders</a>
        </div>
    </div>

</div>
@endsection
