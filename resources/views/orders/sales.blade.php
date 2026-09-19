@extends('layouts.app')
@section('title', 'Sales & Orders')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-receipt me-2 text-success"></i>Sales &amp; Orders</h3>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>Order #</th><th>Buyer</th><th>My Items</th><th>Order Status</th><th>Delivery</th><th></th></tr></thead>
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
            <td>
                @foreach($order->items as $item)
                    <div class="small">{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = ₱{{ number_format($item->subtotal,2) }}</div>
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
        <tr><td colspan="6">
            <div class="ac-empty">
                <i class="bi bi-receipt-cutoff ac-empty-icon"></i>
                <p class="mb-0">No orders yet for your products.</p>
            </div>
        </td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
