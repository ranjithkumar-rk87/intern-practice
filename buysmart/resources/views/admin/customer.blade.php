@extends('layouts.app')

@section('title', 'Normal Users')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">

            <div class="card-header bg-dark text-white">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Users List</h5>

                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                        + Create User
                    </a>
                </div>
            </div>

            <div class="card-body">

                @if($users->count())
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>S.NO</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered At</th>
                                <th>Make Admin/user</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($users as $key => $user)
                            <tr onclick="window.location='{{ route('users.edit', $user->id) }}'"
                                class="cursor-pointer">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                   <td>
                                        @if($user->hasRole('admin'))
                                            <span class="badge bg-primary">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">User</span>
                                        @endif
                                    </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                @if(!$user->hasRole('admin'))
                                    <form method="POST"
                                        action="{{ route('make.admin', $user->id) }}"
                                        onsubmit="return confirm('Are you sure you want to make this user an Admin?')">
                                        @csrf
                                        <button class="btn btn-success btn-sm">
                                            Make Admin
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                        action="{{ route('remove.admin', $user->id) }}"
                                        onsubmit="return confirm('Remove admin role from this user?')">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">
                                            Remove Admin
                                        </button>
                                    </form>
                                @endif
                            </td>
                                    <td onclick="event.stopPropagation();">
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        No normal users found.
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
