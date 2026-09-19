@extends('layouts.app')
@section('title', 'Manage Listings')
@section('content')
<h3 class="mb-3">Manage Listings</h3>
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach(['pending','approved','rejected','out_of_stock'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
    </div>
</form>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Product</th><th>Seller</th><th>Category</th><th>Price</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
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
        <tr><td colspan="6" class="text-center text-muted py-4">No listings found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $products->links() }}
@endsection
