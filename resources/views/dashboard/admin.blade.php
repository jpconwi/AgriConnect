@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card shadow-sm text-center p-3"><h2>{{ $totalUsers }}</h2><p class="mb-0 text-muted">Total Users</p></div></div>
    <div class="col-md-3"><div class="card shadow-sm text-center p-3"><h2 class="text-warning">{{ $pendingUsers }}</h2><p class="mb-0 text-muted">Pending Approvals</p></div></div>
    <div class="col-md-3"><div class="card shadow-sm text-center p-3"><h2>{{ $totalProducts }}</h2><p class="mb-0 text-muted">Total Listings</p></div></div>
    <div class="col-md-3"><div class="card shadow-sm text-center p-3"><h2>{{ $totalOrders }}</h2><p class="mb-0 text-muted">Total Orders</p></div></div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="btn btn-success">Review Pending Users</a>
    <a href="{{ route('admin.products.index', ['status' => 'pending']) }}" class="btn btn-outline-success">Review Pending Listings ({{ $pendingProducts }})</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">View All Orders</a>
</div>
@endsection
