<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Admin Panel')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <div class="flex min-h-screen">
            <aside class="hidden w-72 lg:block h-screen sticky top-0 p-6 bg-primary text-primary-content">
                    @include('layouts.admin-sidebar')
                </aside>

            <div class="flex-1">
                <header class="border-b border-slate-200 bg-white px-6 py-4 shadow-sm">
                    <div class="max-w-7xl mx-auto flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-xl font-semibold text-slate-900">@yield('title', 'Admin Panel')</h1>
                            <p class="text-sm text-slate-500">@yield('description')</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex flex-col text-right">
                                <span class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="text-xs uppercase tracking-wide text-slate-500">{{ Auth::user()->role === 'admin' ? 'Admin' : 'Pelanggan' }}</span>
                            </div>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300">
                                        <span>{{ __('Akun') }}</span>
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0 011.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <main class="max-w-7xl mx-auto px-6 py-6">
                    @if (session('success'))
                        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-900">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
