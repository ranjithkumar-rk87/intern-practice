@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">My Wishlist</h3>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($items->isEmpty())
        <p>No items in wishlist.</p>
    @endif

    <div class="row">
        @foreach($items as $item)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card border rounded h-100 mb-3">
                <img src="{{ asset('storage/'.$item->product->image) }}" class="card-img-top img-fluid" alt="{{ $item->product->name }}">
                <div class="card-body text-center">
                    <h6>{{ $item->product->name }}</h6>

                         <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 mt-auto">
                            <form action="{{ route('cart.add', $item->product->id) }}" method="GET">
                                @csrf
                                <button class="btn btn-sm btn-primary w-sm-auto">
                                    Add to Cart
                                </button>
                            </form>

                        <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
