@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">👤 My Profile</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Profile Details Form --}}
    <div class="card shadow mb-5">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $detail->phone ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ $detail->pincode ?? '' }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ $detail->address ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $detail->city ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ $detail->state ?? '' }}">
                    </div>
                </div>
                <button class="btn btn-primary mt-4">Save Details</button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>My Addresses</h5>
        <a href="{{ route('address.create') }}" class="btn btn-success btn-sm">+ Add Address</a>
    </div>

   @if($addresses->isEmpty())
    <div class="alert alert-warning">No addresses found.</div>
@else
    <div class="row">
        @foreach($addresses as $addr)
        <div class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="card h-100 shadow-sm position-relative">
                {{-- Default badge in top-right corner --}}
                @if($addr->is_default)
                    <span class="badge bg-success position-absolute" 
                          style="top: 10px; right: 10px; z-index: 10;">
                        Default
                    </span>
                @endif

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ $addr->full_name }}</h6>
                    <p class="mb-1"><strong>Phone:</strong> {{ $addr->phone }}</p>
                    <p class="mb-1">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}</p>

                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('address.edit', $addr->id) }}" class="btn btn-sm btn-primary w-50">Edit</a>

                        <form action="{{ route('address.destroy', $addr->id) }}" method="POST" class="w-50"
                            onsubmit="return confirm('Are you sure you want to delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100">Delete</button>
                        </form>
                    </div>

                    @if(!$addr->is_default)
                    <a href="{{ route('address.default', $addr->id) }}" class="btn btn-sm btn-outline-success mt-2 w-100">
                        Set as Default
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

</div>
@endsection
