@extends('layouts.app')

@section('title','Products')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-3">
            <div class="card border rounded shadow-sm mb-4">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    Categories

                    @if(isset($category))
                        <a href="{{ route('products.index') }}"
                        class="text-decoration-none text-danger small">
                            Clear
                        </a>
                    @endif
                </div>

                <div class="list-group list-group-flush">
                    <a href="{{ route('products.index') }}"
                    class="list-group-item list-group-item-action
                    {{ !isset($category) ? 'active' : '' }}">
                        All Products
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('products.category', $cat) }}"
                        class="list-group-item list-group-item-action
                        {{ (isset($category) && $category == $cat) ? 'active' : '' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <form method="GET" action="{{ route('products.search') }}" class="mb-3">
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
            <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('products.index') }}" class="d-flex align-items-center">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="sort" class="form-select w-auto me-2" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High to Low</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </form>
        </div>

            

            <!-- SEARCH INFO -->
            @if(request('search'))
                <h6 class="mb-3">
                    Search results for:
                    <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('products.index') }}"
                       class="text-decoration-none text-secondary ms-2">
                        ✕ Clear
                    </a>
                </h6>
            @endif

            <!-- PRODUCTS GRID -->
            <div class="row g-4">

                @if(request('search') && $products->isEmpty())
                    <div class="text-center">
                        <img src="{{ asset('images/common/no_search.png') }}"
                             alt="No products found"
                             class="img-fluid mb-3">
                        <h5 class="text-muted">No products found</h5>
                    </div>
                @endif

                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card border rounded h-100 shadow">

                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="card-img-top img-cover"
                                 alt="{{ $product->name }}">

                            <div class="card-body d-flex flex-column text-center">
                                <h6>{{ $product->name }}</h6>

                                @if($product->stock > 0)
                                    <p class="text-success mb-2">
                                        ₹{{ number_format($product->price, 2) }}
                                    </p>
                                @else
                                    <span class="badge text-danger mb-2">
                                        Out of Stock
                                    </span>
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

    </div>
</div>

@endsection
