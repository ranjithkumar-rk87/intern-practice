@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">👤 My Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

        <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control"
                        value="{{ $user->name }}" disabled>
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control"
                        value="{{ $user->email }}" disabled>
                </div>

                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="form-control"
                        value="{{ $detail->phone ?? '' }}">
                    <small class="text-danger" id="phoneError"></small>
                </div>

                <div class="col-md-6">
                    <label>Pincode</label>
                    <input type="text" name="pincode" id="pincode"
                        class="form-control"
                        value="{{ $detail->pincode ?? '' }}">
                    <small class="text-danger" id="pincodeError"></small>
                </div>

                <div class="col-md-12">
                    <label>Address</label>
                    <textarea name="address" id="address"
                            class="form-control"
                            rows="2">{{ $detail->address ?? '' }}</textarea>
                    <small class="text-danger" id="addressError"></small>
                </div>

                <div class="col-md-6">
                    <label>City</label>
                    <input type="text" name="city" id="city"
                        class="form-control"
                        value="{{ $detail->city ?? '' }}">
                    <small class="text-danger" id="cityError"></small>
                </div>

                <div class="col-md-6">
                    <label>State</label>
                    <input type="text" name="state" id="state"
                        class="form-control"
                        value="{{ $detail->state ?? '' }}">
                    <small class="text-danger" id="stateError"></small>
                </div>

            </div>

            <button class="btn btn-primary mt-4">Save Details</button>
        </form>


        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('#profileForm').submit(function (e) {
        let valid = true;

        // clear old errors
        $('small.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let phone   = $('#phone').val().trim();
        let pincode = $('#pincode').val().trim();
        let address = $('#address').val().trim();
        let city    = $('#city').val().trim();
        let state   = $('#state').val().trim();

        // Phone (10 digits)
        if (phone === '') {
            $('#phoneError').text('Phone number is required');
            $('#phone').addClass('is-invalid');
            valid = false;
        } else if (!/^[0-9]{10}$/.test(phone)) {
            $('#phoneError').text('Enter valid 10 digit phone number');
            $('#phone').addClass('is-invalid');
            valid = false;
        }

        // Pincode
        if (pincode === '') {
            $('#pincodeError').text('Pincode is required');
            $('#pincode').addClass('is-invalid');
            valid = false;
        } else if (!/^[0-9]{6}$/.test(pincode)) {
            $('#pincodeError').text('Enter valid 6 digit pincode');
            $('#pincode').addClass('is-invalid');
            valid = false;
        }

        // Address
        if (address === '') {
            $('#addressError').text('Address is required');
            $('#address').addClass('is-invalid');
            valid = false;
        }

        // City
        if (city === '') {
            $('#cityError').text('City is required');
            $('#city').addClass('is-invalid');
            valid = false;
        }

        // State
        if (state === '') {
            $('#stateError').text('State is required');
            $('#state').addClass('is-invalid');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
</script>

@endsection
