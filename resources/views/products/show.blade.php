@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="row">
    <div class="col-md-5">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded shadow-sm">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:300px;">
                <span class="text-muted">No image</span>
            </div>
        @endif
    </div>
    <div class="col-md-7">
        <span class="badge bg-success-subtle text-success mb-2">{{ $product->category->name }}</span>
        <h3>{{ $product->name }}</h3>
        <p class="text-muted">Sold by {{ $product->seller->name }} ({{ ucfirst($product->seller->role) }})</p>
        <h4 class="text-success">₱{{ number_format($product->price, 2) }} <small class="text-muted fs-6">/ {{ $product->unit }}</small></h4>
        <p>{{ $product->description ?: 'No description provided.' }}</p>
        <p class="small">Stock available: <strong>{{ $product->stock_quantity }} {{ $product->unit }}</strong></p>

        @auth
            @if(auth()->user()->isBuyer())
                <form method="POST" action="{{ route('cart.add', $product) }}" class="row g-2 mt-3" style="max-width:300px;">
                    @csrf
                    <div class="col-6">
                        <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->stock_quantity }}" value="1" required>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success w-100" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>Add to Cart</button>
                    </div>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-success mt-3">Login to purchase</a>
        @endauth
    </div>
</div>
@endsection
