@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<h3 class="mb-3">Checkout</h3>
<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Order Summary</h6>
                <ul class="list-group list-group-flush">
                    @foreach($items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                            <span>₱{{ number_format($item['subtotal'], 2) }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span><span>₱{{ number_format($total, 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="delivery_address" class="form-control" rows="2" required>{{ old('delivery_address', auth()->user()->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required id="paymentMethod">
                            <option value="cod">Cash on Delivery</option>
                            <option value="gcash">GCash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3" id="refField" style="display:none;">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}">
                    </div>
                    <button class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const sel = document.getElementById('paymentMethod');
    const ref = document.getElementById('refField');
    function toggle() { ref.style.display = sel.value === 'cod' ? 'none' : 'block'; }
    sel.addEventListener('change', toggle); toggle();
</script>
@endpush
@endsection
