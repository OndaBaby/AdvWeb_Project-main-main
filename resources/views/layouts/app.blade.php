{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f05026; /* Shopee orange */
        color: #ffffff; /* White */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .navbar-brand {
        color: #ffffff; /* White */
        font-weight: bold;
        font-size: 1.5rem;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .nav-links {
        display: flex;
        align-items: center;
    }

    .nav-link {
        color: #ffffff; /* White */
        margin: 0 1rem;
        font-weight: bold;
        text-decoration: none;
    }

    .nav-link i {
        margin-right: 5px;
    }

    .cart-icon {
        margin-left: 1rem;
        cursor: pointer;
    }

    .cart-icon svg {
        height: 30px;
        width: 30px;
    }
</style>
</head>
<body>
    <div id="app">
    </head>
    <body>
        <div id="app">
            <!-- Header -->
            <header class="navbar">
                <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'user' ? route('home') : route('welcome'))) : route('welcome') }}" class="navbar-brand">
                    <img src="{{ asset('storage/images/donnn.png') }}" alt="">Shoeshable
                </a>
                <div class="nav-links">
                    @guest
                        {{-- <a href="{{ route('about') }}" class="nav-link"><i class="fas fa-question"></i>About Us</a>
                        <a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-phone"></i>Contact Us</a>
                        <a href="{{ route('faqwel') }}" class="nav-link"><i class="fas fa-fa-question"></i>FAQs</a> --}}
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @else
                         @if(Auth::user()->role == 'admin')
                            {{-- <a href="{{ route('user') }}" class="nav-link">Users</a>
                            <a href="{{ route('product') }}" class="nav-link">Products</a>
                            <a href="{{ route('order.index') }}" class="nav-link">Orders</a>
                            <a href="{{ route('analytics') }}" class="nav-link">Analytics</a>
                            <a href="{{ route('feedback') }}" class="nav-link">Feedbacks</a>
                            <a href="{{ route('inventory') }}" class="nav-link">Inventory</a>
                            <a href="{{ route('supplier') }}" class="nav-link">Suppliers</a>
                            <a href="{{ route('faq') }}" class="nav-link">FAQs</a> --}}
                        @else
                            {{-- <a href="{{ route('cart') }}" class="nav-link"><i class="fas fa-shopping-cart"></i>Cart</a> --}}
                            {{-- <a href="{{ route('cart.index') }}" class="nav-link"> --}}
                                <i class="fas fa-shopping-cart"></i> Cart
                                @php
                                    $cartItemCount = \App\Models\Cart::where('customer_id', Auth::id())->count();
                                @endphp
                                @if ($cartItemCount > 0)
                                    <span class="badge badge-pill badge-primary">{{ $cartItemCount }}</span>
                                @endif
                            {{-- </a> --}}
                            {{-- <a href="{{ route('myorder') }}" class="nav-link"class="nav-link"><i class="fas fa-bag"></i>My Order</a> --}}
                        @endif
                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    {{ __('View Profile') }}
                                </a> --}}
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </header>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
