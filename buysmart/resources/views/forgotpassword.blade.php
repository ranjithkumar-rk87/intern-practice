@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-success  text-center">
                <h4 class="text-white">Forgot Password</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('forgetpassword') }}">
                    @csrf
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control mb-3" required>
                    <button class="btn btn-success w-100 mb-3">Send Reset Link</button>
                </form>
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none"> Back to Login</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
