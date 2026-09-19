@extends('layouts.app')
@section('title', 'Cart')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-cart3 me-2 text-success"></i>Your Cart</h3>
<div class="table-responsive mb-3">
<table class="table align-middle">
    <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $item)
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $item['product']->display_image }}" class="rounded-3" style="width:44px;height:44px;object-fit:cover;" alt="">
                    <span class="fw-semibold">{{ $item['product']->name }}</span>
                </div>
            </td>
            <td>₱{{ number_format($item['product']->price, 2) }}</td>
            <td style="max-width:130px;">
                <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="form-control form-control-sm">
                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-repeat"></i></button>
                </form>
            </td>
            <td class="fw-semibold">₱{{ number_format($item['subtotal'], 2) }}</td>
            <td>
                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5">
            <div class="ac-empty">
                <i class="bi bi-cart-x ac-empty-icon"></i>
                <p class="mb-2">Your cart is empty.</p>
                <a href="{{ route('home') }}" class="btn btn-success btn-sm">Browse the marketplace</a>
            </div>
        </td></tr>
    @endforelse
    </tbody>
</table>
</div>
@if($items->isNotEmpty())
<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Total: <span class="ac-price">₱{{ number_format($total, 2) }}</span></h5>
        <a href="{{ route('checkout') }}" class="btn btn-success"><i class="bi bi-bag-check me-1"></i>Proceed to Checkout</a>
    </div>
</div>
@endif
@endsection
