@extends('layouts.app')

@section('title','Products')

@section('content')
<div class="container">
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow">

                <img src="{{ asset('storage/'.$product->image) }}"
                     class="card-img-top img-cover ">

                <div class="card-body d-flex flex-column">
                    <h6>{{ $product->name }}</h6>
                    <p class="text-success">₹{{ $product->price }}</p>

                    <a href="{{ route('products.show',$product->id) }}"
                       class="btn btn-danger btn-sm mt-auto">
                        Show Now
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
