@extends('layouts.app')
@section('title', 'Cart')
@section('content')
<h3 class="mb-3">Your Cart</h3>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $item)
        <tr>
            <td>{{ $item['product']->name }}</td>
            <td>₱{{ number_format($item['product']->price, 2) }}</td>
            <td style="max-width:120px;">
                <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="form-control form-control-sm">
                    <button class="btn btn-sm btn-outline-secondary">↻</button>
                </form>
            </td>
            <td>₱{{ number_format($item['subtotal'], 2) }}</td>
            <td>
                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Your cart is empty. <a href="{{ route('home') }}">Browse the marketplace</a>.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@if($items->isNotEmpty())
<div class="d-flex justify-content-between align-items-center">
    <h5>Total: ₱{{ number_format($total, 2) }}</h5>
    <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
</div>
@endif
@endsection
