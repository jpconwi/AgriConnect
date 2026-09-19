<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agri Connect')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f3; }
        .navbar-brand span { color: #2e7d32; font-weight: 700; }
        .btn-success { background-color: #2e7d32; border-color: #2e7d32; }
        .btn-success:hover { background-color: #256428; border-color: #256428; }
        .badge-role { text-transform: capitalize; }
        .card { border: 1px solid #e5e7eb; }
        footer { color: #6b7280; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">🌾 <span>AgriConnect</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Marketplace</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        @if(auth()->user()->isSeller())
                            <li class="nav-item"><a class="nav-link" href="{{ route('products.manage') }}">My Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('orders.sales') }}">Sales / Orders</a></li>
                        @endif
                        @if(auth()->user()->isBuyer())
                            <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">My Orders</a></li>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Listings</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->isBuyer())
                            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">🛒 Cart</a></li>
                        @endif
                        <li class="nav-item d-flex align-items-center me-2">
                            <span class="badge bg-light text-dark border badge-role">{{ auth()->user()->role }}</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm">Logout ({{ auth()->user()->name }})</button>
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
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center py-4 small">
        &copy; {{ date('Y') }} AgriConnect — Connecting Farmers, Suppliers &amp; Buyers.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
