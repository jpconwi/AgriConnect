@extends('layouts.app')
@section('title', 'Order '.$order->order_number)
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-receipt me-2 text-success"></i>Order {{ $order->order_number }}</h3>
<div class="row g-4">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Items</h6>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>{{ $item->product->name ?? 'Product removed' }} × {{ $item->quantity }}</span>
                            <span class="fw-semibold">₱{{ number_format($item->subtotal, 2) }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between fw-bold px-0 pt-3">
                        <span>Total</span><span class="ac-price">₱{{ number_format($order->total_amount, 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="bi bi-geo-alt me-1"></i>Delivery Address</h6>
                <p class="mb-3">{{ $order->delivery_address }}</p>
                @if($order->notes)
                    <h6 class="fw-bold mb-2">Notes</h6>
                    <p class="mb-0">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-2">Status</h6>
                <p><span class="badge bg-info-subtle text-dark fs-6">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></p>
                <h6 class="fw-bold mb-2">Payment</h6>
                <p>{{ ucfirst(str_replace('_',' ',$order->payment->method)) }} —
                    <span class="badge bg-{{ $order->payment->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment->status) }}</span>
                </p>
                @if($order->delivery)
                <a href="{{ route('orders.track', $order) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-truck me-1"></i>Track Delivery</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
