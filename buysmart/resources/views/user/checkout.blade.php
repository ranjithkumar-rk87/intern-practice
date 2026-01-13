@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="container my-4">
    <a href="{{ url()->previous() }}" class="text-dark">
        <- Back
    </a>

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white fw-semibold d-flex justify-content-between align-items-center">
                        📍 Delivery Address
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            + New Address
                        </button>
                    </div>

                    <div class="card-body">
                        @if($addresses->count() > 0)
                            @foreach($addresses as $address)
                                <div class="d-flex justify-content-between align-items-start mb-2 p-2 border rounded">
                                    <div>
                                        <strong>{{ $address->full_name }}</strong><br>
                                        {{ $address->phone }}<br>
                                        {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                    <br>
                                        @if($address->is_deliverable)
                                            <span class="text-success small">Delivery Available ✅</span>
                                        @else
                                            <span class="text-danger small">Delivery Not Available ❌</span>
                                        @endif
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="radio" 
                                            name="selected_address" 
                                            value="{{ $address->id }}" 
                                            id="address{{ $address->id }}" 
                                            @if($address->is_default || $loop->first) checked @endif>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No saved addresses. Please add one.</p>
                        @endif
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white fw-semibold">
                        💳 Payment Method
                    </div>

                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                            <label class="form-check-label fw-semibold">
                                Cash on Delivery
                            </label>
                            <div class="text-muted small">
                                Pay when your order arrives
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="online">
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

            {{-- Order Summary --}}
            <div class="col-lg-4 col-md-6">
                <div class="card">
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

                        @php
                        $hasDeliverableAddress = $addresses->contains(function ($address) {
                            return \App\Models\Pincode::where('pincode', $address->pincode)
                                                    ->where('is_active', 1)
                                                    ->exists();
                        });
                    @endphp

                    <button 
                        class="btn btn-success w-100 mt-3" 
                        type="submit"
                        {{ !$hasDeliverableAddress ? 'disabled' : '' }}
                    >
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

{{-- Add Address Modal --}}
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addAddressForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="10-digit mobile number">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" rows="3" class="form-control" placeholder="House no, Street, Area"></textarea>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$('#addAddressForm').on('submit', function(e){
    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
        url: "{{ route('address.save') }}",
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#addAddressModal').modal('hide');
            location.reload();
        },
        error: function(err) {
            alert('Error saving address: ' + (err.responseJSON?.message || 'Check form inputs'));
        }
    });
});
</script>

@endsection
