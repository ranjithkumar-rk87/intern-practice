@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>
        <p class="text-muted">Welcome, {{ auth()->user()->name }}</p>
    </div>

    {{-- USERS --}}
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Users</h6>
                <h2 class="text-primary">{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Admins</h6>
                <h2 class="text-success">{{ $totalAdmins }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5>Normal Users</h5>
                <h2 class="text-warning">{{ $totalNormalUsers }}</h2>
            </div>
        </div>
    </div>

    {{-- ORDERS --}}
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Pending Orders</h6>
                <h2 class="text-warning">{{ $pendingOrders }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Confirmed Orders</h6>
                <h2 class="text-info">{{ $confirmedOrders }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Delivered Orders</h6>
                <h2 class="text-success">{{ $deliveredOrders }}</h2>
            </div>
        </div>
    </div>

    {{-- REVENUE --}}
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Revenue</h6>
                <h2 class="text-danger">₹{{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
