@extends('layouts.app')

@section('title','Products')

@section('content')

<div class="container">
    <div class="row g-4">

        <form method="GET" action="{{ route('products.search') }}">
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search products..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Search
                    </button>
                </div>
            </div>
        </form>

        @if(request('search'))
            <h6 class="mb-3">
                Search results for:
                <strong>"{{ request('search') }}"</strong>
                <a href="{{ route('products.index') }}"
                   class="text-decoration-none text-secondary ms-2">
                    ✕ Clear search
                </a>
            </h6>
        @endif

        @if(request('search') && $products->isEmpty())
            <div class="text-center">
                <img src="{{ asset('images/common/no_search.png') }}"
                     alt="No products found"
                     class="img-fluid mb-3">
                <h5 class=" text-muted">No products found</h5>
            </div>
        @endif

        @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card border rounded h-100 shadow">

                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="card-img-top img-cover">

                    <div class="card-body d-flex flex-column text-center">
                        <h6>{{ $product->name }}</h6>

                        @if($product->stock > 0)
                            <p class="text-success mb-2">
                                ₹{{ number_format($product->price, 2) }}
                            </p>
                        @else
                            <span class="badge  text-danger mb-2">Out of Stock</span>
                         @endif

                            <a href="{{ route('products.show',$product->id) }}"
                               class="btn btn-primary btn-sm mt-auto">
                                Show Now
                            </a>
                       

                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

@endsection
