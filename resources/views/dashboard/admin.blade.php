@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="ac-page-head">
    <div>
        <h3 class="ac-section-title mb-1">Admin Dashboard</h3>
        <p class="text-muted mb-0">Platform overview and moderation shortcuts.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card ac-stat-card">
            <div class="ac-stat-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="ac-stat-value">{{ $totalUsers }}</div>
                <div class="ac-stat-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card ac-stat-card gold">
            <div class="ac-stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="ac-stat-value">{{ $pendingUsers }}</div>
                <div class="ac-stat-label">Pending Approvals</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card ac-stat-card info">
            <div class="ac-stat-icon"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="ac-stat-value">{{ $totalProducts }}</div>
                <div class="ac-stat-label">Total Listings</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card ac-stat-card">
            <div class="ac-stat-icon"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="ac-stat-value">{{ $totalOrders }}</div>
                <div class="ac-stat-label">Total Orders</div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="btn btn-success"><i class="bi bi-person-check me-1"></i>Review Pending Users</a>
    <a href="{{ route('admin.products.index', ['status' => 'pending']) }}" class="btn btn-outline-success"><i class="bi bi-clipboard-check me-1"></i>Review Pending Listings ({{ $pendingProducts }})</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"><i class="bi bi-truck me-1"></i>View All Orders</a>
</div>
@endsection
