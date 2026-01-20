@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5">

        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="mb-0">Change Password</h5>
            </div>

            <div class="card-body">

\                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('changepassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Old Password</label>
                        <input type="password" name="old_password" class="form-control">
                        @error('old_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Update Password
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
