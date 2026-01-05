@extends('layouts.app')

@section('title', 'Product List')

@section('content')

<h3 class="mb-3">📦 Product List</h3>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
    + Add Product
</a>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ asset('storage/'.$product->image) }}"
                             width="60" class="rounded">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>₹{{ $product->price }}</td>
                    <td>
                        @if($product->stock == 0)
                            <span class="badge bg-danger">Out of Stock</span>
                        @else
                            <span class="badge bg-success">
                                 {{ $product->stock }}
                            </span>
                        @endif
                    </td>

                    <td class="d-flex  gap-2">

                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
