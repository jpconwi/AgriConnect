@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h3 class="mb-4">Welcome, {{ auth()->user()->name }}</h3>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card shadow-sm text-center p-3"><h2>{{ $products->count() }}</h2><p class="mb-0 text-muted">My Listings</p></div></div>
    <div class="col-md-4"><div class="card shadow-sm text-center p-3"><h2>{{ $products->where('status','approved')->count() }}</h2><p class="mb-0 text-muted">Approved</p></div></div>
    <div class="col-md-4"><div class="card shadow-sm text-center p-3"><h2>{{ $orderItemsCount }}</h2><p class="mb-0 text-muted">Order Line Items</p></div></div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
    <a href="{{ route('products.manage') }}" class="btn btn-outline-success">Manage Products</a>
    <a href="{{ route('orders.sales') }}" class="btn btn-outline-secondary">View Sales</a>
</div>
@endsection
