@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="ac-page-head">
    <div>
        <h3 class="ac-section-title mb-1">Welcome, {{ auth()->user()->name }} 👋</h3>
        <p class="text-muted mb-0">Here's a quick look at your activity.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-success"><i class="bi bi-shop me-1"></i>Browse Marketplace</a>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-success"><i class="bi bi-cart3 me-1"></i>View Cart</a>
    </div>
</div>

<h5 class="ac-section-title mb-3">Recent Orders</h5>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td class="fw-semibold">{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>
            <td><span class="badge bg-info-subtle text-dark">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></td>
            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-success">View</a></td>
        </tr>
    @empty
        <tr><td colspan="5">
            <div class="ac-empty">
                <i class="bi bi-bag ac-empty-icon"></i>
                <p class="mb-2">No orders yet.</p>
                <a href="{{ route('home') }}" class="btn btn-success btn-sm">Start Shopping</a>
            </div>
        </td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection
