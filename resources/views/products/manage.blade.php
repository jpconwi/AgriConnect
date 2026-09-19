@extends('layouts.app')
@section('title', 'My Products')
@section('content')
<div class="ac-page-head">
    <div>
        <h3 class="ac-section-title mb-1">My Products</h3>
        <p class="text-muted mb-0">Manage your listings and track approval status.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Add Product</a>
</div>

<div class="table-responsive">
<table class="table align-middle">
    <thead>
        <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $product->display_image }}" class="rounded-3" style="width:44px;height:44px;object-fit:cover;" alt="">
                    <span class="fw-semibold">{{ $product->name }}</span>
                </div>
            </td>
            <td>{{ $product->category->name }}</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock_quantity }} {{ $product->unit }}</td>
            <td>
                @php
                $badge = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'out_of_stock' => 'secondary'][$product->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$product->status)) }}</span>
            </td>
            <td class="text-end">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Delete this product?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="ac-empty">
                <i class="bi bi-box-seam ac-empty-icon"></i>
                <p class="mb-2">You haven't listed any products yet.</p>
                <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">Add your first product</a>
            </div>
        </td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
