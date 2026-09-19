@extends('layouts.app')
@section('title', 'Marketplace')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Marketplace</h3>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-6">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }} ({{ ucfirst($cat->type) }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success w-100">Filter</button>
    </div>
</form>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" style="height:160px;object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                        <span class="text-muted">No image</span>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-success-subtle text-success mb-2 align-self-start">{{ $product->category->name }}</span>
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="text-muted small mb-1">by {{ $product->seller->name }}</p>
                    <p class="fw-bold mb-2">₱{{ number_format($product->price, 2) }} / {{ $product->unit }}</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-success mt-auto btn-sm">View Details</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No products found.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
