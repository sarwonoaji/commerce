<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="business">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>@yield('title', 'Admin Panel')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-base-200 text-base-content">
        <div class="navbar sticky top-0 z-50 bg-primary text-primary-content shadow-md">
            <div class="container mx-auto flex items-center gap-4">
                <div class="flex items-center flex-1">
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white font-bold">ABC</div>
                        <span class="font-semibold text-lg">PT ABC LKS Shop</span>
                    </a>
                </div>

             

                <div class="flex items-center gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-primary-content" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="ml-2 hidden sm:inline">Katalog</span>
                    </a>

                    <a href="{{ route('cart.index') }}" class="btn btn-ghost relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-primary-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7h14l-2-7M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        <span class="ml-2 hidden sm:inline">Keranjang</span>
                        <span class="badge badge-secondary absolute -top-1 -right-2">{{ count(session('cart', [])) }}</span>
                    </a>

                    @auth
                        <div class="dropdown dropdown-end">
                            <label tabindex="0" class="btn btn-ghost rounded-full px-2 flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-8 h-8 rounded-full bg-neutral text-white flex items-center justify-center">
                                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                                    </div>
                                </div>
                                <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            </label>
                            <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-white text-base-content rounded-box w-52">
                                <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full text-left">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endauth

                    <div class="md:hidden">
                        <button class="btn btn-ghost" aria-label="Buka menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="md:hidden">
                <div class="container mx-auto px-4 py-2">
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-ghost">
                            <span class="inline-block mr-2 text-primary-content">📚</span>
                            Katalog
                        </a>
                        @auth
                            <a href="{{ route('orders.index') }}" class="btn btn-ghost">Pesanan Saya</a>
                        @endauth
                        <a href="{{ route('cart.index') }}" class="btn btn-ghost">Keranjang <span class="badge badge-secondary ml-2">{{ count(session('cart', [])) }}</span></a>
                    </div>
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
