@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">

        <h3 class="mb-4 text-center text-md-start">🛒 My Cart</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="alert alert-warning text-center">
                Your cart is empty
            </div>
            <div class="text-center">
                <a href="/" class="btn btn-primary">Continue Shopping</a>
            </div>
        @else

        <div class="card shadow">
            <div class="card-body p-2 p-md-4">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $grandTotal = 0; @endphp

                            @foreach($cartItems as $item)
                                @php
                                    $total = $item->product->price * $item->quantity;
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="{{ asset('storage/'.$item->product->image) }}"
                                             width="50" class="me-2 rounded">
                                        {{ $item->product->name }}
                                    </td>
                                    <td>₹{{ $item->product->price }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="d-flex align-items-center gap-1">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" name="action" value="decrease"
                                                    class="btn btn-outline-secondary btn-sm">−</button>

                                            <input type="text"
                                                value="{{ $item->quantity }}"
                                                readonly
                                                class="qty text-center width-40">

                                            <button type="submit" name="action" value="increase"
                                                    class="btn btn-outline-secondary btn-sm">+</button>
                                        </form>
                                    </td>

                                    <td>₹{{ $total }}</td>
                                    <td>
                                     <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Remove this item from cart?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                Remove
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 

                <hr>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h4 class="mb-3 mb-md-0">Total: <span class="text-success">₹{{ $grandTotal }}</span></h4>
                    <form action="{{ route('checkout.index') }}">
                        @csrf
                        <button class="btn btn-success">
                            Checkout
                        </button>
                    </form>
                </div>

            </div>
        </div>

        @endif
    </div>
</div>
</div>
@endsection
