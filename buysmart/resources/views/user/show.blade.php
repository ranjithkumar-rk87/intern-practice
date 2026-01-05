@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">

        {{-- Product Image --}}
        <div class="col-md-6">
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="img-fluid rounded"
                 style="max-height:400px; object-fit:contain;">
        </div>

        {{-- Product Details --}}
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <h4 class="text-success">₹{{ number_format($product->price, 2) }}</h4>
            <p class="text-muted">{{ $product->description }}</p>

            @auth
            <form method="GET">
                @csrf

                {{-- Quantity --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Quantity</label>

                    <div class="input-group" style="max-width:160px;">
                        <button formaction="{{ route('quantity.update', $product->id) }}"
                                name="action"
                                value="decrease"
                                class="btn btn-outline-secondary">−</button>

                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', 1) }}"
                               class="form-control text-center"
                               readonly>

                        <button formaction="{{ route('quantity.update', $product->id) }}"
                                name="action"
                                value="increase"
                                class="btn btn-outline-secondary">+</button>
                    </div>

                    <small class="text-muted">
                        Stock: {{ $product->stock }}
                    </small>
                </div>

                <div class="d-grid gap-2 d-md-flex">
                    <button formaction="{{ route('cart.add', $product->id) }}"
                            class="btn btn-primary btn-lg w-100">
                        Add to Cart
                    </button>

                    <button formaction="{{ route('buy.now', $product->id) }}"
                            class="btn btn-success btn-lg w-100">
                        Buy Now
                    </button>
                </div>
            </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                    Login to Continue
                </a>
            @endguest

        </div>
    </div>
</div>
@endsection
