@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="ac-page-head">
    <div>
        <h3 class="ac-section-title mb-1">Welcome, {{ auth()->user()->name }} 👋</h3>
        <p class="text-muted mb-0">Here's how your storefront is doing.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card ac-stat-card">
            <div class="ac-stat-icon"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="ac-stat-value">{{ $products->count() }}</div>
                <div class="ac-stat-label">My Listings</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ac-stat-card gold">
            <div class="ac-stat-icon"><i class="bi bi-patch-check"></i></div>
            <div>
                <div class="ac-stat-value">{{ $products->where('status','approved')->count() }}</div>
                <div class="ac-stat-label">Approved</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ac-stat-card info">
            <div class="ac-stat-icon"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="ac-stat-value">{{ $orderItemsCount }}</div>
                <div class="ac-stat-label">Order Line Items</div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('products.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Add Product</a>
    <a href="{{ route('products.manage') }}" class="btn btn-outline-success"><i class="bi bi-box-seam me-1"></i>Manage Products</a>
    <a href="{{ route('orders.sales') }}" class="btn btn-outline-secondary"><i class="bi bi-receipt me-1"></i>View Sales</a>
</div>
@endsection
