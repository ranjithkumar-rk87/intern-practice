@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 align-items-start">

        <div class="col-lg-6 col-md-6">
            <div class="card shadow-sm border-0">
                <img 
                    src="{{ asset('storage/'.$product->image) }}" 
                    class="img-fluid rounded"
                    alt="{{ $product->name }}"
                    style="max-height:450px; object-fit:contain;"
                >
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card shadow-sm border-0 p-4 h-100">

                <h2 class="fw-bold mb-2">{{ $product->name }}</h2>

                <h4 class="text-success fw-semibold mb-3">
                    ₹{{ number_format($product->price, 2) }}
                </h4>

                <p class="text-muted mb-4">
                    {{ $product->description }}
                </p>

                @auth

                <div class="d-grid gap-2 d-md-flex mt-4">

                    <form action="{{ route('cart.add', $product->id) }}" method="GET">
                        @csrf
                        <button class="btn btn-primary btn-lg w-100">
                             Add to Cart
                        </button>
                    </form>

                    <form action="{{ route('buy.now', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg w-100">
                             Buy Now
                        </button>
                    </form>

                </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mb-2">
                         Add to Cart
                    </a>

                    <a href="{{ route('login') }}" class="btn btn-success btn-lg">
                         Buy Now
                    </a>
                 @endguest


            </div>
        </div>

    </div>
</div>

@auth
<div class="d-md-none fixed-bottom bg-white shadow p-3">
    <div class="d-flex gap-2">
        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-outline-primary w-50">
            Add to Cart
        </a>
        <form action="{{ route('buy.now', $product->id) }}" method="POST" class="w-50">
            @csrf
            <button class="btn btn-success w-100">
                Buy Now
            </button>
        </form>
    </div>
</div>
@endauth
@endsection
