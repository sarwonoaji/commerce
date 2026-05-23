<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name', 'Commerce') }}</title>
    @if (class_exists('Vite'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    @endif
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-pink-50 flex items-center py-12 px-4">
    <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="hidden md:flex flex-col items-start justify-center px-8">
            <h1 class="text-4xl font-extrabold text-indigo-600 mb-4">Selamat Datang di E-Commerce</h1>
            <p class="text-gray-600 mb-6">Kelola belanjaanmu dengan cepat dan aman. Masuk untuk melanjutkan.</p>
            <div class="w-full max-w-sm">
                <!-- simple illustration -->
                <svg viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto opacity-90">
                    <defs>
                        <linearGradient id="g1" x1="0" x2="1">
                            <stop offset="0%" stop-color="#6366f1" />
                            <stop offset="100%" stop-color="#ec4899" />
                        </linearGradient>
                    </defs>
                    <rect width="400" height="200" rx="12" fill="url(#g1)" opacity="0.12" />
                </svg>
            </div>
        </div>

        <div class="w-full flex items-center justify-center px-4">
            <div class="w-full max-w-md bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl p-8">
                <div class="text-center mb-6">
                    <p class="text-2xl font-bold text-indigo-600">Masuk ke Akun Anda</p>
                </div>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-100 rounded p-3">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4">
                    <div class="text-sm text-red-700 bg-red-50 border border-red-100 rounded p-3">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="pl-10 pr-3 py-2 block w-full rounded-md border border-gray-200 bg-white text-black focus:ring-2 focus:ring-indigo-300 focus:border-transparent" />
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1H9v-1c0-1.657 1.343-3 3-3z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V9a5 5 0 0110 0v2"></path></svg>
                        </span>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="pl-10 pr-12 py-2 block w-full rounded-md border border-gray-200 bg-white text-black focus:ring-2 focus:ring-indigo-300 focus:border-transparent" />
                        <button type="button" data-target="password" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-indigo-600">Tampil</button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="inline-flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        <span class="ml-2">Ingat saya</span>
                    </label>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Lupa password?</a>
                        @endif
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow">Masuk</button>

                <div class="mt-4">
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" class="flex-1 py-2 px-3 border rounded-md text-sm bg-white hover:shadow">Masuk dengan Google</button>
                        <button type="button" class="flex-1 py-2 px-3 border rounded-md text-sm bg-white hover:shadow">Masuk dengan Facebook</button>
                    </div>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a>
            </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = btn.dataset.target;
                var input = document.getElementById(id);
                if(!input) return;
                if(input.type === 'password'){
                    input.type = 'text';
                    btn.textContent = 'Sembunyikan';
                } else {
                    input.type = 'password';
                    btn.textContent = 'Tampil';
                }
            });
        });
    </script>
</body>
</html>
