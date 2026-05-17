<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="business">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'PT ABC LKS Shop') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-base-content">
        <div class="navbar bg-primary text-primary-content shadow-lg">
            <div class="container mx-auto">
                <div class="flex-1">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost normal-case text-xl">PT ABC LKS Shop</a>
                </div>
                <div class="flex-none gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Katalog</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="btn btn-ghost">Pesanan Saya</a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="btn btn-accent gap-2">
                        Keranjang
                        <span class="badge badge-secondary">
                            {{ count(session('cart', [])) }}
                        </span>
                    </a>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-ghost">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>

        <main class="container mx-auto px-4 py-8">
            @if (session('success'))
                <div class="alert alert-success mb-6">
                    <div>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error mb-6">
                    <div>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
