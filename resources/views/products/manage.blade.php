@extends('layouts.app')
@section('title', 'My Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">My Products</h3>
    <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
</div>

<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead>
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
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
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Delete this product?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">You haven't listed any products yet.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
