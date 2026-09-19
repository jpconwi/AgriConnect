@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<h3 class="mb-3">My Orders</h3>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th>Payment</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>
            <td><span class="badge bg-info-subtle text-dark">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></td>
            <td><span class="badge bg-{{ $order->payment?->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment?->status ?? 'n/a') }}</span></td>
            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-success">View</a></td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No orders yet.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $orders->links() }}
@endsection
