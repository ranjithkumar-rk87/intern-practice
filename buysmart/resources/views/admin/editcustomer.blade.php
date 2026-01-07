@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow">
            <div class="card-header bg-dark ">
                <h5 class="mb-0 text-white">Edit User</h5>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" id="userUpdateForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                        <small class="text-danger" id="nameError"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                        <small class="text-danger" id="emailError"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   class="form-control"
                                   value="{{ old('phone', $user->detail->phone ?? '') }}">
                            <small class="text-danger" id="phoneError"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text"
                                   name="city"
                                   id="city"
                                   class="form-control"
                                   value="{{ old('city', $user->detail->city ?? '') }}">
                            <small class="text-danger" id="cityError"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text"
                                   name="state"
                                   id="state"
                                   class="form-control"
                                   value="{{ old('state', $user->detail->state ?? '') }}">
                            <small class="text-danger" id="stateError"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text"
                                   name="pincode"
                                   id="pincode"
                                   class="form-control"
                                   value="{{ old('pincode', $user->detail->pincode ?? '') }}">
                            <small class="text-danger" id="pincodeError"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address"
                                    id="address"
                                    rows="3"
                                    class="form-control">{{ old('address', $user->detail->address ?? '') }}</textarea>
                            <small class="text-danger" id="addressError"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>

                        <select name="role"
                                class="form-select"
                                {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                            <option value="user"
                                {{ $user->hasRole('user') ? 'selected' : '' }}>
                                User
                            </option>

                            <option value="admin"
                                {{ $user->hasRole('admin') ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>

                        <small class="text-muted">
                            Changing role affects user access
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admindashboard') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Update User
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function () {

    $('#userUpdateForm').submit(function (e) {
        let valid = true;

        // Clear old errors
        $('small.text-danger').text('');
        $('.form-control, .form-select').removeClass('is-invalid');

        let name    = $('#name').val().trim();
        let email   = $('#email').val().trim();
        let phone   = $('#phone').val().trim();
        let city    = $('#city').val().trim();
        let state   = $('#state').val().trim();
        let pincode = $('#pincode').val().trim();
        let address = $('#address').val().trim();
        let role    = $('#is_user').val();

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

        // Phone
        if (phone !== '' && !/^[0-9]{10}$/.test(phone)) {
            $('#phoneError').text('Phone must be 10 digits');
            $('#phone').addClass('is-invalid');
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

        if (!valid) {
            e.preventDefault();
        }
    });

});
</script>

@endsection
