@extends('layouts.app')
@section('title', 'Track Order')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-truck me-2 text-success"></i>Tracking — {{ $order->order_number }}</h3>
<div class="card" style="max-width:640px;">
<div class="card-body p-4">
    @php
        $steps = ['preparing' => 1, 'in_transit' => 2, 'delivered' => 3];
        $current = $steps[$order->delivery->status] ?? 1;
    @endphp
    <div class="ac-tracker">
        <div class="ac-tstep {{ $current >= 1 ? 'done' : '' }}">
            <div class="ac-tdot"><i class="bi bi-box-seam"></i></div>
            <div class="ac-tlabel">Preparing</div>
        </div>
        <div class="ac-tstep {{ $current >= 2 ? 'done' : '' }}">
            <div class="ac-tdot"><i class="bi bi-truck"></i></div>
            <div class="ac-tlabel">In Transit</div>
        </div>
        <div class="ac-tstep {{ $current >= 3 ? 'done' : '' }}">
            <div class="ac-tdot"><i class="bi bi-check-lg"></i></div>
            <div class="ac-tlabel">Delivered</div>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Tracking No.</span><strong>{{ $order->delivery->tracking_number }}</strong></li>
        <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Courier</span><strong>{{ $order->delivery->courier_name ?? 'Not yet assigned' }}</strong></li>
        <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Current Location</span><strong>{{ $order->delivery->current_location ?? 'Awaiting dispatch' }}</strong></li>
        <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Estimated Arrival</span><strong>{{ optional($order->delivery->estimated_arrival)->format('M d, Y') ?? 'TBD' }}</strong></li>
    </ul>
</div>
</div>
@endsection
