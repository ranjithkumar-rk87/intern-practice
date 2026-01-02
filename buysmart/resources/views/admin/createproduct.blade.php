@extends('layouts.app')

@section('title','Add Product')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show col-md-6 mx-auto" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger col-md-6 mx-auto">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-6 mx-auto card shadow p-4">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="name" class="form-control mb-3" placeholder="Product Name">

            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

            <input type="number" name="price" class="form-control mb-3" placeholder="Price">

            <input type="file" name="image" class="form-control mb-3">

            <button class="btn btn-success w-100">Save Product</button>
        </form>
    </div>
</div>
@endsection
