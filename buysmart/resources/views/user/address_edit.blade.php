@extends('layouts.app')

@section('title', 'Edit Address')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">✏️ Edit Address</h3>

    <div class="card shadow">
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

            <form action="{{ route('address.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $address->full_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $address->phone) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $address->address) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $address->city) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $address->state) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $address->pincode) }}">
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="checkbox" name="is_default" id="is_default" class="me-2" {{ $address->is_default ? 'checked' : '' }}>
                        <label for="is_default">Set as default address</label>
                    </div>
                </div>

                <button class="btn btn-primary">Update Address</button>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('form').on('submit', function (e) {
        let valid = true;

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        function showError(input, message) {
            input.addClass('is-invalid');
            input.after('<div class="invalid-feedback">' + message + '</div>');
            valid = false;
        }

        // Full Name
        let fullName = $('input[name="full_name"]');
        if ($.trim(fullName.val()) === '') {
            showError(fullName, 'Full name is required.');
        }

        // Phone
        let phone = $('input[name="phone"]');
        let phonePattern = /^[0-9]{10}$/;
        if ($.trim(phone.val()) === '') {
            showError(phone, 'Phone number is required.');
        } else if (!phonePattern.test(phone.val())) {
            showError(phone, 'Enter a valid 10-digit phone number.');
        }

        // Address
        let address = $('textarea[name="address"]');
        if ($.trim(address.val()) === '') {
            showError(address, 'Address is required.');
        }

        // City
        let city = $('input[name="city"]');
        if ($.trim(city.val()) === '') {
            showError(city, 'City is required.');
        }

        // State
        let state = $('input[name="state"]');
        if ($.trim(state.val()) === '') {
            showError(state, 'State is required.');
        }

        // Pincode
        let pincode = $('input[name="pincode"]');
        let pinPattern = /^[0-9]{6}$/;
        if ($.trim(pincode.val()) === '') {
            showError(pincode, 'Pincode is required.');
        } else if (!pinPattern.test(pincode.val())) {
            showError(pincode, 'Enter a valid 6-digit pincode.');
        }

        if (!valid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid:first').offset().top - 100
            }, 400);
        }

    });

});
</script>

@endsection
