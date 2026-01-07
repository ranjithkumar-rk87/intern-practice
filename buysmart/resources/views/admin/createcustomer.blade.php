@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>➕ Create User</h3>

        <a href="{{ route('listcustomer') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                @csrf

                <div class="row g-3">

                    {{-- Basic Info --}}
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" id="name"
                               class="form-control"
                               value="{{ old('name') }}">
                        <small class="text-danger" id="nameError"></small>

                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control"
                               value="{{ old('email') }}">
                        <small class="text-danger" id="emailError"></small>
                    </div>

                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" id="password"
                               class="form-control">
                        <small class="text-danger" id="passwordError"></small>
                    </div>

                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" 
                               id="confirmPassword"
                               class="form-control">
                        <small class="text-danger" id="confirmPasswordError"></small>
                    </div>

                    {{-- Address Info --}}
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone"
                               class="form-control"
                               value="{{ old('phone') }}">
                        <small class="text-danger" id="phoneError"></small>
                    </div>

                    <div class="col-md-6">
                        <label>Pincode</label>
                        <input type="text" name="pincode" id="pincode"
                               class="form-control"
                               value="{{ old('pincode') }}">
                        <small class="text-danger" id="pincodeError"></small>
                    </div>

                    <div class="col-md-12">
                        <label>Address</label>
                        <textarea name="address"
                                  id="address"
                                  class="form-control"
                                  rows="2">{{ old('address') }}</textarea>
                        <small class="text-danger" id="addressError"></small>
                    </div>

                    <div class="col-md-6">
                        <label>City</label>
                        <input type="text" name="city" id="city"
                               class="form-control"
                               value="{{ old('city') }}">
                        <small class="text-danger" id="cityError"></small>
                    </div>

                    <div class="col-md-6">
                        <label>State</label>
                        <input type="text" name="state" id="state"
                               class="form-control"
                               value="{{ old('state') }}">
                        <small class="text-danger" id="stateError"></small>
                    </div>

                </div>

                <button class="btn btn-success mt-4">
                    Create User
                </button>

            </form>

        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('#createUserForm').submit(function (e) {
        let valid = true;

        // Clear old errors
        $('small.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let name     = $('#name').val().trim();
        let email    = $('#email').val().trim();
        let password = $('#password').val();
        let confirm  = $('#confirmPassword').val();
        let phone    = $('#phone').val().trim();
        let pincode  = $('#pincode').val().trim();
        let address  = $('#address').val().trim();
        let city     = $('#city').val().trim();
        let state    = $('#state').val().trim();

        // Name
        if (name === '') {
            $('#nameError').text('Name is required');
            $('#name').addClass('is-invalid');
            valid = false;
        }

        // Email
        if (email === '') {
            $('#emailError').text('Email is required');
            $('#email').addClass('is-invalid');
            valid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $('#emailError').text('Enter a valid email');
            $('#email').addClass('is-invalid');
            valid = false;
        }

        // Password
        if (password === '') {
            $('#passwordError').text('Password is required');
            $('#password').addClass('is-invalid');
            valid = false;
        } else if (password.length < 8) {
            $('#passwordError').text('Password must be at least 8 characters');
            $('#password').addClass('is-invalid');
            valid = false;
        }

        // Confirm Password
        if (confirm === '') {
            $('#confirmPasswordError').text('Confirm password is required');
            $('#confirmPassword').addClass('is-invalid');
            valid = false;
        } else if (password !== confirm) {
            $('#confirmPasswordError').text('Passwords do not match');
            $('#confirmPassword').addClass('is-invalid');
            valid = false;
        }

        // Phone
         if (confirm === '') {
            $('#phoneError').text('phone is required');
            $('#phone').addClass('is-invalid');
            valid = false;
        }
        else if (phone !== '' && !/^[0-9]{10}$/.test(phone)) {
            $('#phoneError').text('Phone must be 10 digits');
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
