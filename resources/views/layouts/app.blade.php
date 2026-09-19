<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agri Connect')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌾</text></svg>">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg ac-navbar mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand ac-brand" href="{{ route('home') }}">
                <span class="ac-logo-badge">🌾</span> <span>AgriConnect</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="bi bi-shop me-1"></i>Marketplace</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                        @if(auth()->user()->isSeller())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.manage') }}"><i class="bi bi-box-seam me-1"></i>My Products</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.sales') ? 'active' : '' }}" href="{{ route('orders.sales') }}"><i class="bi bi-receipt me-1"></i>Sales / Orders</a></li>
                        @endif
                        @if(auth()->user()->isBuyer())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}"><i class="bi bi-bag-check me-1"></i>My Orders</a></li>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-1"></i>Users</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-clipboard-check me-1"></i>Listings</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-1"></i>Categories</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-truck me-1"></i>Orders</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-lg-center">
                    @auth
                        @if(auth()->user()->isBuyer())
                            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3 me-1"></i>Cart</a></li>
                        @endif
                        <li class="nav-item d-flex align-items-center gap-2 me-2 mt-2 mt-lg-0">
                            <img src="{{ auth()->user()->avatar_url }}" class="nav-avatar" alt="{{ auth()->user()->name }}">
                            <div class="d-flex flex-column lh-1">
                                <span class="fw-semibold small">{{ auth()->user()->name }}</span>
                                <span class="badge bg-light text-dark border badge-role align-self-start mt-1">{{ auth()->user()->role }}</span>
                            </div>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-outline-success btn-sm me-2" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="btn btn-success btn-sm" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        @if(session('status'))
            <div class="alert alert-success d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill"></i> {{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <div class="d-flex align-items-center gap-2 mb-1"><i class="bi bi-exclamation-triangle-fill"></i><strong>Please fix the following:</strong></div>
                <ul class="mb-0 ps-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="ac-footer">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <span>🌾 &copy; {{ date('Y') }} <strong class="text-success">AgriConnect</strong> — Connecting Farmers, Suppliers &amp; Buyers.</span>
            <span class="d-flex gap-3">
                <i class="bi bi-shield-check"></i> Secure marketplace
                <i class="bi bi-truck ms-2"></i> Delivery tracking
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
