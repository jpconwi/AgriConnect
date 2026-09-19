@extends('layouts.app')
@section('title', 'Manage Listings')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-clipboard-check me-2 text-success"></i>Manage Listings</h3>
<form method="GET" class="ac-filter-bar">
    <div class="row g-2">
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach(['pending','approved','rejected','out_of_stock'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>Product</th><th>Seller</th><th>Category</th><th>Price</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $product->display_image }}" class="rounded-3" style="width:40px;height:40px;object-fit:cover;" alt="">
                    <span class="fw-semibold">{{ $product->name }}</span>
                </div>
            </td>
            <td>{{ $product->seller->name }} ({{ ucfirst($product->seller->role) }})</td>
            <td>{{ $product->category->name }}</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
            <td>
                @php
                $badge = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'out_of_stock' => 'secondary'][$product->status];
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$product->status)) }}</span>
            </td>
            <td class="text-end">
                @if($product->status !== 'approved')
                <form method="POST" action="{{ route('admin.products.approve', $product) }}" class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-success">Approve</button>
                </form>
                @endif
                @if($product->status !== 'rejected')
                <form method="POST" action="{{ route('admin.products.reject', $product) }}" class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-danger">Reject</button>
                </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6"><div class="ac-empty"><i class="bi bi-clipboard-x ac-empty-icon"></i><p class="mb-0">No listings found.</p></div></td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
