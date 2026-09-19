@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="ac-auth-wrap">
    <div class="ac-auth-card">
        <div class="ac-auth-side">
            <div>
                <h2><span class="d-block fs-1">🌾</span>Welcome back to AgriConnect</h2>
                <ul>
                    <li><i class="bi bi-check-circle-fill"></i> Browse fresh produce &amp; farm inputs</li>
                    <li><i class="bi bi-check-circle-fill"></i> Track your orders &amp; deliveries</li>
                    <li><i class="bi bi-check-circle-fill"></i> Manage listings as a farmer or supplier</li>
                </ul>
            </div>
            <p class="small mb-0 opacity-75">Connecting farmers, suppliers &amp; buyers across Surigao del Sur.</p>
        </div>
        <div class="ac-auth-form">
            <h4 class="ac-section-title mb-1">Login</h4>
            <p class="text-muted small mb-4">Enter your details to access your account.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button class="btn btn-success w-100 py-2">Login</button>
            </form>

            <div class="ac-demo-box mt-4">
                <div class="fw-semibold mb-1"><i class="bi bi-info-circle me-1"></i>Demo accounts <span class="text-muted fw-normal">(password: <code>password</code>)</span></div>
                <div class="row small mb-0">
                    <div class="col-6"><code>admin@agriconnect.test</code></div>
                    <div class="col-6"><code>farmer@agriconnect.test</code></div>
                    <div class="col-6"><code>supplier@agriconnect.test</code></div>
                    <div class="col-6"><code>buyer@agriconnect.test</code></div>
                </div>
            </div>

            <p class="mt-3 mb-0 small">No account? <a href="{{ route('register') }}">Register here</a>.</p>
        </div>
    </div>
</div>
@endsection
