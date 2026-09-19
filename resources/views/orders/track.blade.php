@extends('layouts.app')
@section('title', 'Track Order')
@section('content')
<h3 class="mb-3">Tracking — {{ $order->order_number }}</h3>
<div class="card shadow-sm" style="max-width:600px;">
<div class="card-body">
    @php
        $steps = ['preparing' => 1, 'in_transit' => 2, 'delivered' => 3];
        $current = $steps[$order->delivery->status] ?? 1;
    @endphp
    <div class="d-flex justify-content-between mb-4 text-center">
        <div class="{{ $current >= 1 ? 'text-success fw-bold' : 'text-muted' }}">📦<br>Preparing</div>
        <div class="{{ $current >= 2 ? 'text-success fw-bold' : 'text-muted' }}">🚚<br>In Transit</div>
        <div class="{{ $current >= 3 ? 'text-success fw-bold' : 'text-muted' }}">✅<br>Delivered</div>
    </div>
    <p><strong>Tracking No.:</strong> {{ $order->delivery->tracking_number }}</p>
    <p><strong>Courier:</strong> {{ $order->delivery->courier_name ?? 'Not yet assigned' }}</p>
    <p><strong>Current Location:</strong> {{ $order->delivery->current_location ?? 'Awaiting dispatch' }}</p>
    <p><strong>Estimated Arrival:</strong> {{ optional($order->delivery->estimated_arrival)->format('M d, Y') ?? 'TBD' }}</p>
</div>
@endsection
