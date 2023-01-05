<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Product Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::user()?->role_id == 2)
                        <li class="nav-item">
                            <span class="">Welcome {{ Auth::user()?->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('showAllVendors') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('showCreateVendorForm') }}">Create Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">View Products History</a>
                        </li>
                    @endif
                    @if (Auth::user()?->role_id == 1)
                        <li class="nav-item">
                            <span class="nav-link active">Welcome, {{ Auth::user()?->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('showProductByVendorId') }}">Home</a>
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
                    @if (Auth::user()?->role_id == 1)
                        <form action="{{ asset('showProductByVendorId') }}" class="d-flex" role="product_search">
                            <input class="form-control me-2" type="text" name="product_search" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-success me-2" type="submit">Search</button>
                        </form>
                    @endif
                    @if (Auth::user()?->role_id == 2)
                        <form action="{{ asset('showAllVendors') }}" class="d-flex" role="search">
                            <input class="form-control me-2" type="text" name="user_search" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-success me-2" type="submit">Search</button>
                        </form>
                    @endif
                    <div>
                        <form method="POST" action="users/logout">
                            @csrf
                            <button class="btn btn-danger" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
                @guest
                    <a class="btn btn-outline-success" aria-current="page"
                        href="{{ asset('users/showRegisterForm') }}">Register</a>
                    <a class="btn btn-outline-success ms-2" href="{{ asset('users/showLoginForm') }}">Login</a>
                @endguest
            </div>
        </div>
    </nav>
    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
