@extends('layouts.app')
@section('title', $product->name)
@section('content')

<nav class="mb-3 small">
    <a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Back to Marketplace</a>
</nav>

<div class="row g-4">
    <div class="col-md-5">
        <div class="rounded-4 overflow-hidden shadow-sm" style="height:340px;">
            <img src="{{ $product->display_image }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $product->name }}">
        </div>
    </div>
    <div class="col-md-7">
        <span class="ac-cat-pill {{ $product->category->type === 'input' ? 'input-type' : '' }} mb-2">{{ $product->category->name }}</span>
        <h2 class="ac-section-title mt-2">{{ $product->name }}</h2>

        <div class="ac-seller-line mb-3">
            <img src="{{ $product->seller->avatar_url }}" alt="">
            <span>Sold by <strong>{{ $product->seller->name }}</strong> &middot; {{ ucfirst($product->seller->role) }}</span>
        </div>

        <div class="ac-price fs-3 mb-3">₱{{ number_format($product->price, 2) }} <small class="fs-6">/ {{ $product->unit }}</small></div>

        <p class="text-muted">{{ $product->description ?: 'No description provided.' }}</p>

        <div class="d-flex align-items-center gap-3 mb-4">
            <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                <i class="bi {{ $product->stock_quantity > 0 ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                {{ $product->stock_quantity > 0 ? $product->stock_quantity.' '.$product->unit.' in stock' : 'Out of stock' }}
            </span>
        </div>

        @auth
            @if(auth()->user()->isBuyer())
                <form method="POST" action="{{ route('cart.add', $product) }}" class="row g-2" style="max-width:320px;">
                    @csrf
                    <div class="col-6">
                        <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->stock_quantity }}" value="1" required>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success w-100" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-1"></i>Add to Cart
                        </button>
                    </div>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-success"><i class="bi bi-box-arrow-in-right me-1"></i>Login to purchase</a>
        @endauth
    </div>
</div>
@endsection
