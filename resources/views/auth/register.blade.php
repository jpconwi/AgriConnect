@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="ac-auth-wrap">
    <div class="ac-auth-card" style="max-width:1040px;">
        <div class="ac-auth-side">
            <div>
                <h2><span class="d-block fs-1">🌱</span>Join AgriConnect</h2>
                <ul>
                    <li><i class="bi bi-basket-fill"></i> Buyers shop fresh produce &amp; inputs</li>
                    <li><i class="bi bi-tractor"></i> Farmers list produce for sale</li>
                    <li><i class="bi bi-box-seam-fill"></i> Suppliers list seeds, tools &amp; fertilizer</li>
                </ul>
            </div>
            <p class="small mb-0 opacity-75">Farmer &amp; supplier accounts are reviewed by an admin before activation.</p>
        </div>
        <div class="ac-auth-form">
            <h4 class="ac-section-title mb-1">Create an Account</h4>
            <p class="text-muted small mb-4">It only takes a minute to get started.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">I am registering as a...</label>
                    <select name="role" class="form-select" required>
                        <option value="">Select a role</option>
                        <option value="farmer" {{ old('role') === 'farmer' ? 'selected' : '' }}>Farmer (sell produce)</option>
                        <option value="supplier" {{ old('role') === 'supplier' ? 'selected' : '' }}>Supplier (sell farm inputs)</option>
                        <option value="buyer" {{ old('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                    </select>
                    <div class="form-text">Farmer and supplier accounts require admin approval before you can log in.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>
                </div>
                <button class="btn btn-success w-100 py-2">Register</button>
            </form>
            <p class="mt-3 mb-0 small">Already have an account? <a href="{{ route('login') }}">Login</a>.</p>
        </div>
    </div>
</div>
@endsection
