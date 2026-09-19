@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h3 class="mb-4">Welcome, {{ auth()->user()->name }}</h3>
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('home') }}" class="btn btn-success">Browse Marketplace</a>
    <a href="{{ route('cart.index') }}" class="btn btn-outline-success">View Cart</a>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">My Orders</a>
</div>
<h5>Recent Orders</h5>
<div class="table-responsive">
<table class="table bg-white shadow-sm">
    <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>
            <td>{{ ucfirst(str_replace('_',' ',$order->status)) }}</td>
            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-success">View</a></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection
