@extends('layouts.app')

@section('title','Add Product')

@section('content')
<div class="container">
     <a href="{{ route('admin.products.list') }}" class="btn btn-secondary mb-3">
        ← Back
    </a>

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
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="mb-3">
            <input type="text" name="name" id="name" class="form-control" placeholder="Product Name">
            <small class="text-danger" id="nameError"></small>
            </div>
            
            <div class="mb-3">
            <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
            <small class="text-danger" id="descriptionError"></small>
            </div>
            
            <div class="mb-3">
            <input type="number" name="price" id="price" class="form-control" placeholder="Price">
            <small class="text-danger" id="priceError"></small>
            </div>
            
            <div class="mb-3">
            <input type="number" name="stock" id="stock" class="form-control" placeholder="Stock Quantity" min="0">
            <small class="text-danger" id="stockError"></small>
            </div>

            <div class="mb-3">
            <input type="file" name="image" id="image" class="form-control">
            <small class="text-danger" id="imageError"></small>
            </div>

            <button class="btn btn-success w-100">Save Product</button>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {

    $('#productForm').submit(function (e) {
        let valid = true;

        $('small.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let name = $('#name').val().trim();
        let description = $('#description').val().trim();
        let price = $('#price').val();
        let stock = $('#stock').val();
        let image = $('#image').val();

        // Product name
        if (name === '') {
            $('#nameError').text('Product name is required');
            $('#name').addClass('is-invalid');
            valid = false;
        }

        // Description
        if (description === '') {
            $('#descriptionError').text('Description is required');
            $('#description').addClass('is-invalid');
            valid = false;
        }

        // Price
        if (price === '') {
            $('#priceError').text('Price is required');
            $('#price').addClass('is-invalid');
            valid = false;
        } else if (price <= 0) {
            $('#priceError').text('Price must be greater than 0');
            $('#price').addClass('is-invalid');
            valid = false;
        }

        // Stock
        if (stock === '') {
            $('#stockError').text('Stock quantity is required');
            $('#stock').addClass('is-invalid');
            valid = false;
        } else if (stock < 0) {
            $('#stockError').text('Stock cannot be negative');
            $('#stock').addClass('is-invalid');
            valid = false;
        }

        // Image
        if (image === '') {
            $('#imageError').text('Product image is required');
            $('#image').addClass('is-invalid');
            valid = false;
        } else {
            let allowed = ['jpg', 'jpeg', 'png', 'webp'];
            let ext = image.split('.').pop().toLowerCase();
            if (!allowed.includes(ext)) {
                $('#imageError').text('Allowed formats: JPG, PNG, WEBP');
                $('#image').addClass('is-invalid');
                valid = false;
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
</script>

@endsection
