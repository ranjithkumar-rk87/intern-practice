@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4>Login</h4>
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

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="mb-3" method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <small class="text-danger" id="emailError"></small>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="text-danger" id="passwordError"></small>
                    </div>

                    <div class="text-end mb-3">
                        <a href="{{ route('forgot.password.form') }}">Forgot Password?</a>
                    </div>
                    <button class="btn btn-success w-100">Login</button>
                </form>


                <div class="text-center">
                    <a href="{{ route('register') }}">Create account</a>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('#loginForm').submit(function (e) {
        let isValid = true;

        $('#emailError').text('');
        $('#passwordError').text('');
        $('#email, #password').removeClass('is-invalid');

        let email = $('#email').val().trim();
        let password = $('#password').val().trim();

        // Email
        if (email === '') {
            $('#emailError').text('Email is required');
            $('#email').addClass('is-invalid');
            isValid = false;
        } else if (!validateEmail(email)) {
            $('#emailError').text('Enter a valid email');
            $('#email').addClass('is-invalid');
            isValid = false;
        }

        // Password
        if (password === '') {
            $('#passwordError').text('Password is required');
            $('#password').addClass('is-invalid');
            isValid = false;
        } else if (password.length < 8) {
            $('#passwordError').text('Password must be at least 8 characters');
            $('#password').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    function validateEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

});
</script>


@endsection
