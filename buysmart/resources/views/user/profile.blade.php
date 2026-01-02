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

            <form action="{{ route('profile.update') }}" method="POST">
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
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ $detail->phone ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label>Pincode</label>
                        <input type="text" name="pincode"
                               class="form-control"
                               value="{{ $detail->pincode ?? '' }}">
                    </div>

                    <div class="col-md-12">
                        <label>Address</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="2">{{ $detail->address ?? '' }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label>City</label>
                        <input type="text" name="city"
                               class="form-control"
                               value="{{ $detail->city ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label>State</label>
                        <input type="text" name="state"
                               class="form-control"
                               value="{{ $detail->state ?? '' }}">
                    </div>

                </div>

                <button class="btn btn-primary mt-4">
                    Save Details
                </button>

            </form>

        </div>
    </div>
</div>
@endsection
