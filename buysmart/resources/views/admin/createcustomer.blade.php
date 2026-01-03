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

    {{-- Validation Errors --}}
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

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Basic Info --}}
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    {{-- Address Info --}}
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Pincode</label>
                        <input type="text" name="pincode"
                               class="form-control"
                               value="{{ old('pincode') }}">
                    </div>

                    <div class="col-md-12">
                        <label>Address</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="2">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label>City</label>
                        <input type="text" name="city"
                               class="form-control"
                               value="{{ old('city') }}">
                    </div>

                    <div class="col-md-6">
                        <label>State</label>
                        <input type="text" name="state"
                               class="form-control"
                               value="{{ old('state') }}">
                    </div>

                </div>

                <button class="btn btn-success mt-4">
                    Create User
                </button>

            </form>

        </div>
    </div>
</div>
@endsection
