@extends('layouts.app')
@section('title', 'Order '.$order->order_number)
@section('content')
<h3 class="mb-3">Order {{ $order->order_number }}</h3>
<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Items</h6>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->product->name ?? 'Product removed' }} × {{ $item->quantity }}</span>
                            <span>₱{{ number_format($item->subtotal, 2) }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span><span>₱{{ number_format($order->total_amount, 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Delivery Address</h6>
                <p>{{ $order->delivery_address }}</p>
                @if($order->notes)
                    <h6>Notes</h6>
                    <p>{{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Status</h6>
                <p><span class="badge bg-info-subtle text-dark fs-6">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></p>
                <h6>Payment</h6>
                <p>{{ ucfirst(str_replace('_',' ',$order->payment->method)) }} —
                    <span class="badge bg-{{ $order->payment->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment->status) }}</span>
                </p>
                @if($order->delivery)
                <a href="{{ route('orders.track', $order) }}" class="btn btn-outline-success btn-sm">Track Delivery</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
