@extends('layouts.app')

@section('title', 'Add Address')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">+ Add Address</h3>

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

            <form action="{{ route('address.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="checkbox" name="is_default" id="is_default" class="me-2">
                        <label for="is_default">Set as default address</label>
                    </div>
                </div>

                <button class="btn btn-success">Add Address</button>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();

        let isValid = true;
        let errorMessages = [];
        $('input, textarea').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Full Name
        let fullName = $('input[name="full_name"]').val().trim();
        if(fullName === '') {
            isValid = false;
            $('input[name="full_name"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Full Name is required.</div>');
        }

        // Phone
        let phone = $('input[name="phone"]').val().trim();
        let phonePattern = /^[0-9]{10}$/;
        if(phone === '') {
            isValid = false;
            $('input[name="phone"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Phone is required.</div>');
        } else if(!phonePattern.test(phone)) {
            isValid = false;
            $('input[name="phone"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Enter a valid 10-digit phone number.</div>');
        }

        // Address
        let address = $('textarea[name="address"]').val().trim();
        if(address === '') {
            isValid = false;
            $('textarea[name="address"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Address is required.</div>');
        }

        // City
        let city = $('input[name="city"]').val().trim();
        if(city === '') {
            isValid = false;
            $('input[name="city"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">City is required.</div>');
        }

        // State
        let state = $('input[name="state"]').val().trim();
        if(state === '') {
            isValid = false;
            $('input[name="state"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">State is required.</div>');
        }

        // Pincode
        let pincode = $('input[name="pincode"]').val().trim();
        let pinPattern = /^[0-9]{6}$/;
        if(pincode === '') {
            isValid = false;
            $('input[name="pincode"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Pincode is required.</div>');
        } else if(!pinPattern.test(pincode)) {
            isValid = false;
            $('input[name="pincode"]').addClass('is-invalid')
                .after('<div class="invalid-feedback">Enter a valid 6-digit pincode.</div>');
        }
        if (isValid) {
            this.submit();
        }
    });
});
</script>

@endsection
