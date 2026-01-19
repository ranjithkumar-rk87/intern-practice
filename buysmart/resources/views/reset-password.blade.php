@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-success text-center">
                <h4 class="text-white">Reset Password</h4>
            </div>

            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            readonly>

                        <!-- <input type="email" name="email" class="form-control" required> -->
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" >
                    </div>

                    <button class="btn btn-success w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('form').on('submit', function (e) {
        let valid = true;

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        function showError(input, message) {
            input.addClass('is-invalid');
            input.after('<div class="invalid-feedback">' + message + '</div>');
            valid = false;
        }

        // Password
        let password = $('input[name="password"]');
        if ($.trim(password.val()) === '') {
            showError(password, 'Password is required.');
        } else if (password.val().length < 8) {
            showError(password, 'Password must be at least 8 characters.');
        }

        // Confirm Password
        let confirmPassword = $('input[name="password_confirmation"]');
        if ($.trim(confirmPassword.val()) === '') {
            showError(confirmPassword, 'Confirm password is required.');
        } else if (password.val() !== confirmPassword.val()) {
            showError(confirmPassword, 'Passwords do not match.');
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
