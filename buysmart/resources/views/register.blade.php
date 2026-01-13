@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4>Register</h4>
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

                <form class="mb-3" method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        <p class="text-danger" id="nameError"></p>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        <p class="text-danger" id="emailError"></p>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <p class="text-danger" id="passwordError"></p>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control">
                        <p class="text-danger" id="confirmPasswordError"></p>
                    </div>

                    <button class="btn btn-success w-100">Register</button>
                </form>


                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-success">Already have account?</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    $('#registerForm').submit(function (e) {
        let valid = true;

        $('small.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val();
        let confirmPassword = $('#confirmPassword').val();

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
        } else if (!validateEmail(email)) {
            $('#emailError').text('Enter a valid email');
            $('#email').addClass('is-invalid');
            valid = false;
        }

        // Password
        if (password === '') {
            $('#passwordError').text('Password is required');
            $('#password').addClass('is-invalid');
            valid = false;
        } else if (password.length < 8) {
            $('#passwordError').text('Password must be at least 8 characters');
            $('#password').addClass('is-invalid');
            valid = false;
        }

        // Confirm password
        if (confirmPassword === '') {
            $('#confirmPasswordError').text('Confirm password is required');
            $('#confirmPassword').addClass('is-invalid');
            valid = false;
        } else if (password !== confirmPassword) {
            $('#confirmPasswordError').text('Passwords do not match');
            $('#confirmPassword').addClass('is-invalid');
            valid = false;
        }

        if (!valid) {
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
