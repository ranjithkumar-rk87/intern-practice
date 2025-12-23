<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Change Password</h4>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('changepassword') }}" method="POST">
                        @csrf

                        <div class="form-group mt-2">
                            <label>Old Password</label>
                            <input type="password" name="old_password" class="form-control">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Change Password</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>