@extends('layouts.app')
@section('title', 'Marketplace')
@section('content')

<div class="ac-hero">
    <span class="ac-hero-badge"><i class="bi bi-patch-check-fill"></i> Fresh from Surigao del Sur &amp; beyond</span>
    <h1 class="display-6">Farm-fresh produce &amp; farm inputs, delivered.</h1>
    <p>Browse listings straight from verified local farmers and suppliers — rice, vegetables, fruits, seeds, fertilizers, and tools.</p>
</div>

<form method="GET" class="ac-filter-bar">
    <div class="row g-2 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search products..." value="{{ request('search') }}">
            </div>
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
            <button class="btn btn-success w-100"><i class="bi bi-funnel me-1"></i>Filter</button>
        </div>
    </div>
</form>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset">
                <div class="card ac-product-card">
                    <div class="ac-product-img-wrap">
                        <img src="{{ $product->display_image }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="ac-cat-pill {{ $product->category->type === 'input' ? 'input-type' : '' }} mb-2 align-self-start">{{ $product->category->name }}</span>
                        <h6 class="card-title mb-1">{{ $product->name }}</h6>
                        <div class="ac-seller-line mb-2">
                            <img src="{{ $product->seller->avatar_url }}" alt="">
                            <span>{{ $product->seller->name }}</span>
                        </div>
                        <div class="ac-price mt-auto">₱{{ number_format($product->price, 2) }} <small>/ {{ $product->unit }}</small></div>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="ac-empty">
                <i class="bi bi-basket ac-empty-icon"></i>
                <p class="mb-0">No products found. Try a different search or category.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
