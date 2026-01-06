@extends('layouts.app')

@section('title', 'My Cart')

@section('content')

<div class="row">
    <div class="col-md-12">

        <h3 class="mb-4">🛒 My Cart</h3>

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
            <a href="/" class="btn btn-primary">Continue Shopping</a>
        @else

        <div class="card shadow">
            <div class="card-body">

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
                                <td>
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
                                            class="form-control text-center"
                                            value="{{ $item->quantity }}"
                                            readonly
                                            class="width-50">

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

                <hr>

                <div class="d-flex justify-content-between">
                    <h4>Total: <span class="text-success">₹{{ $grandTotal }}</span></h4>
                    <form action="{{ route('checkout') }}" method="POST">
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

@endsection
