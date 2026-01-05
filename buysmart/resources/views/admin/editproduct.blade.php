@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<h3 class="mb-3">✏️ Edit Product</h3>

<form action="{{ route('admin.products.update', $product->id) }}"
      method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name"
               value="{{ $product->name }}"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price"
               value="{{ $product->price }}"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description"
                  class="form-control">{{ $product->description }}</textarea>
    </div>

    <div class="mb-3">
    <label>Stock</label>
    <input type="number"
           name="stock"
           value="{{ $product->stock }}"
           class="form-control"
           min="0"
           required>
    </div>


    <div class="mb-3">
        <label>Image</label><br>
        <img src="{{ asset('storage/'.$product->image) }}"
             width="100" class="mb-2 rounded"><br>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-success">Update Product</button>
    <a href="{{ route('admin.products.list') }}" class="btn btn-secondary">
        Back
    </a>
</form>

@endsection
