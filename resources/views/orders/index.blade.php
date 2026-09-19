@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-bag-check me-2 text-success"></i>My Orders</h3>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th>Payment</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td class="fw-semibold">{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('M d, Y') }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>
            <td><span class="badge bg-info-subtle text-dark">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></td>
            <td><span class="badge bg-{{ $order->payment?->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment?->status ?? 'n/a') }}</span></td>
            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-success">View</a></td>
        </tr>
    @empty
        <tr><td colspan="6">
            <div class="ac-empty">
                <i class="bi bi-bag ac-empty-icon"></i>
                <p class="mb-0">No orders yet.</p>
            </div>
        </td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
