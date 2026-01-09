@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="container my-4">

    <form action="{{ route('checkout.place') }}" method="POST">
    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white fw-semibold">
                    📍 Delivery Address
                </div>

                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control"
                               value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               placeholder="10-digit mobile number">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Full Address</label>
                        <textarea name="address" rows="3"
                                  class="form-control"
                                  placeholder="House no, Street, Area"></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-semibold">
                    💳 Payment Method
                </div>

                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio"
                               name="payment_method" value="cod" checked>
                        <label class="form-check-label fw-semibold">
                            Cash on Delivery
                        </label>
                        <div class="text-muted small">
                            Pay when your order arrives
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="payment_method" value="online">
                        <label class="form-check-label fw-semibold">
                            Online Payment
                        </label>
                        <div class="text-muted small">
                            UPI / Card / Net Banking
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            {{-- Order Summary --}}
            <div class="card shadow-sm sticky-top" style="top: 90px;">
                <div class="card-header bg-dark text-white fw-semibold">
                    🧾 Order Summary
                </div>

                <div class="card-body">
                    @php $total = 0; @endphp

                    @foreach($cartItems as $item)
                        @php
                            $subtotal = $item->product->price * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                {{ $item->product->name }}
                                <small class="text-muted">× {{ $item->quantity }}</small>
                            </span>
                            <span>₹{{ $subtotal }}</span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>₹{{ $total }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Delivery</span>
                        <span class="text-success">FREE</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>₹{{ $total }}</span>
                    </div>

                    <button class="btn btn-success w-100 mt-3">
                         Place Order
                    </button>

                    <p class="text-center text-muted small mt-2">
                        Safe & Secure Payments
                    </p>
                </div>
            </div>

        </div>
    </div>

    </form>
</div>
<script>
$(document).ready(function() {

    $('form').on('submit', function(e) {
        let valid = true;
        let phone = $('input[name="phone"]').val().trim();
        let address = $('textarea[name="address"]').val().trim();
        let city = $('input[name="city"]').val().trim();
        let state = $('input[name="state"]').val().trim();
        let pincode = $('input[name="pincode"]').val().trim();

        // Clear previous errors
        $('.text-danger').remove();

        // Phone validation
        if (phone === '') {
            $('input[name="phone"]').after('<span class="text-danger small">Phone is required</span>');
            valid = false;
        } else if (!/^\d{10}$/.test(phone)) {
            $('input[name="phone"]').after('<span class="text-danger small">Enter a valid 10-digit phone number</span>');
            valid = false;
        }

        // Address validation
        if (address === '') {
            $('textarea[name="address"]').after('<span class="text-danger small">Address is required</span>');
            valid = false;
        }

        // City validation
        if (city === '') {
            $('input[name="city"]').after('<span class="text-danger small">City is required</span>');
            valid = false;
        }

        // State validation
        if (state === '') {
            $('input[name="state"]').after('<span class="text-danger small">State is required</span>');
            valid = false;
        }

        // Pincode validation
        if (pincode === '') {
            $('input[name="pincode"]').after('<span class="text-danger small">Pincode is required</span>');
            valid = false;
        } else if (!/^\d{6}$/.test(pincode)) {
            $('input[name="pincode"]').after('<span class="text-danger small">Enter a valid 6-digit pincode</span>');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
</script>

@endsection
