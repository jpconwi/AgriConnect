@extends('layouts.app')
@section('title', 'All Orders')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-truck me-2 text-success"></i>All Orders</h3>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>Order #</th><th>Buyer</th><th>Total</th><th>Status</th><th>Payment</th><th>Delivery</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td class="fw-semibold">{{ $order->order_number }}</td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $order->buyer->avatar_url }}" style="width:26px;height:26px;border-radius:50%;" alt="">
                    {{ $order->buyer->name }}
                </div>
            </td>
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
        <tr><td colspan="7"><div class="ac-empty"><i class="bi bi-truck ac-empty-icon"></i><p class="mb-0">No orders yet.</p></div></td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
