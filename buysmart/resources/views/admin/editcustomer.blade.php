@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Edit User</h5>
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

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $user->detail->phone ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text"
                                   name="city"
                                   class="form-control"
                                   value="{{ old('city', $user->detail->city ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text"
                                   name="state"
                                   class="form-control"
                                   value="{{ old('state', $user->detail->state ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text"
                                   name="pincode"
                                   class="form-control"
                                   value="{{ old('pincode', $user->detail->pincode ?? '') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address"
                                      rows="3"
                                      class="form-control">{{ old('address', $user->detail->address ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select name="is_user" class="form-select" required>
                            <option value="0" {{ $user->is_user == 0 ? 'selected' : '' }}>Normal User</option>
                            <option value="1" {{ $user->is_user == 1 ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>


                    {{-- Buttons --}}
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
@endsection
