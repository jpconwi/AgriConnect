@extends('layouts.app')
@section('title', 'All Orders')
@section('content')
<h3 class="mb-3">All Orders</h3>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Order #</th><th>Buyer</th><th>Total</th><th>Status</th><th>Payment</th><th>Delivery</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->buyer->name }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>
            <td>{{ ucfirst(str_replace('_',' ',$order->status)) }}</td>
            <td>
                <span class="badge bg-{{ $order->payment?->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment?->status ?? 'n/a') }}</span>
            </td>
            <td>
                @if($order->delivery)
                <form method="POST" action="{{ route('admin.deliveries.update', $order->delivery) }}" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach(['preparing','in_transit','delivered'] as $s)
                            <option value="{{ $s }}" {{ $order->delivery->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </form>
                @endif
            </td>
            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No orders yet.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $orders->links() }}
@endsection
