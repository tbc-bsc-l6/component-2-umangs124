<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Product Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>
    <x-navbar>
        <a class="navbar-brand" href="/">Product Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (Gate::allows('admin'))
                    <li class="nav-item">
                        <span class="nav-link active">Welcome, {{ Auth::user()?->name }}</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showAllVendors') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showProductTypes') }}">Product Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showProductHistories') }}">Products Histories</a>
                    </li>
                @endif
                @if (Gate::allows('vendor'))
                    <li class="nav-item">
                        <span class="nav-link active">Welcome, {{ Auth::user()?->name }}</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showProductByVendorId/' . Auth::user()?->id) }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showCreateProductForm') }}">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('showChangePasswordForm') }}">Change Password</a>
                    </li>
                @endif
            </ul>
            @auth
                @if (Gate::allows('vendor'))
                    <form action="{{ asset('showProductByVendorId/' . Auth::user()?->id) }}" class="d-flex"
                        role="product_search">
                        <input class="form-control me-2" type="text" name="product_search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-primary me-2" type="submit">Search</button>
                    </form>
                @endif
                @if (Gate::allows('admin'))
                    <form action="{{ asset('showAllVendors') }}" class="d-flex" role="search">
                        <input class="form-control me-2" type="text" name="user_search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-primary me-2" type="submit">Search</button>
                    </form>
                @endif
                <div>
                    <form method="POST" action="{{ asset('users/logout') }}">
                        @csrf
                        <button class="btn btn-outline-primary" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
            @guest
                <a class="btn btn-outline-primary" aria-current="page"
                    href="{{ asset('users/showRegisterForm') }}">Register</a>
                <a class="btn btn-outline-primary ms-2" href="{{ asset('users/showLoginForm') }}">Login</a>
            @endguest
        </div>
    </x-navbar>
    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>
</html>
