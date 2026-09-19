@extends('layouts.app')
@section('title', 'Sales & Orders')
@section('content')
<h3 class="mb-3">Sales &amp; Orders</h3>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Order #</th><th>Buyer</th><th>My Items</th><th>Order Status</th><th>Delivery</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->buyer->name }}</td>
            <td>
                @foreach($order->items as $item)
                    <div>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = ₱{{ number_format($item->subtotal,2) }}</div>
                @endforeach
            </td>
            <td>
                <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach(['pending','confirmed','processing','out_for_delivery','delivered','cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td>
                @if($order->delivery)
                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$order->delivery->status)) }}</span>
                @endif
            </td>
            <td>
                @if($order->payment && $order->payment->status !== 'paid')
                    <form method="POST" action="{{ route('payments.markPaid', $order->payment) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-success">Mark Paid</button>
                    </form>
                @endif
                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary mt-1">View</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No orders yet for your products.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $orders->links() }}
@endsection
