@extends('layouts.shop')

@section('content')
    <section class="space-y-8">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-white to-indigo-50 p-8 shadow-lg ring-1 ring-slate-200">
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600/80">PT ABC E-Commerce</p>
                    <h1 class="mt-2 text-4xl sm:text-5xl font-extrabold text-slate-900 leading-tight">Toko LKS & Buku Sekolah</h1>
                    <p class="mt-4 text-lg text-slate-600">LKS dan buku sekolah untuk SD–SMA: materi latihan, soal ujian, dan buku persiapan yang terpercaya.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">Lihat Keranjang</a>
                        <a href="#products" class="inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Lihat Produk</a>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <div class="grid gap-4 sm:grid-cols-2 w-full max-w-md">
                        <div class="flex items-center gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                            <div class="p-3 rounded-lg bg-indigo-100 text-indigo-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4m-5 4h18"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Produk Tersedia</p>
                                <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $totalProducts ?? $products->count() }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                            <div class="p-3 rounded-lg bg-slate-100 text-slate-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3zM3 11h18v10H3z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Pengiriman</p>
                                <p class="mt-1 text-2xl font-semibold text-slate-900">Cepat & Terpercaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="products" class="space-y-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Katalog Produk</p>
                    <h2 class="text-3xl font-semibold text-slate-900">Pilihan LKS Terbaru</h2>
                </div>
                <div class="flex w-full max-w-lg gap-3 items-center">
                    <form method="GET" action="{{ route('products.index') }}" class="flex w-full items-center gap-3">
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari produk, judul, mata pelajaran..." class="flex-1 rounded-full border border-slate-200 px-4 py-2 shadow-sm focus:ring-2 focus:ring-indigo-300" />
                        <select name="sort" class="rounded-full border border-slate-200 px-3 py-2 text-sm">
                            <option value="">Urutkan</option>
                            <option value="new" {{ request('sort')=='new' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga: Rendah &uarr;</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga: Tinggi &darr;</option>
                        </select>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm text-white">Cari</button>
                    </form>
                </div>
            </div>
            <p class="text-sm text-slate-500">Temukan LKS sesuai jenjang, mata pelajaran, dan kebutuhan belajar.</p>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($products as $product)
                    <article class="group relative overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative overflow-hidden bg-slate-100">
                            <img loading="lazy" decoding="async" src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/placeholder.png') }}" alt="{{ $product->title }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105" />
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/80 to-transparent p-4 text-white">
                                <p class="text-sm uppercase tracking-[0.3em] text-slate-100">{{ $product->grade }} • {{ $product->subject }}</p>
                            </div>

                            <!-- hover actions -->
                            <div class="absolute inset-0 flex items-start justify-end p-4 opacity-0 group-hover:opacity-100 transition">
                                <div class="flex gap-2">
                                    <a href="{{ route('products.show', $product) }}" title="Quick view" class="inline-flex items-center justify-center rounded-full bg-white/90 p-2 shadow">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <button type="button" title="Tambahkan ke wishlist" class="inline-flex items-center justify-center rounded-full bg-white/90 p-2 shadow">
                                        <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-7">
                            @if(isset($product->created_at) && $product->created_at->gt(now()->subDays(30)))
                                <span class="inline-block mb-3 rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">Baru</span>
                            @endif
                            <h3 class="text-xl font-semibold text-slate-900">{{ $product->title }}</h3>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
                            <div class="mt-6 flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-lg font-semibold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-slate-500">Stok: {{ $product->stock }}</p>
                                </div>
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <a href="{{ route('products.show', $product) }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:border-slate-300 hover:bg-slate-50">Detail</a>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline-flex">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-sm text-white">Beli</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if(method_exists($products, 'links'))
                <div class="mt-6">{{ $products->appends(request()->query())->links('pagination::tailwind') }}</div>
            @endif
        </section>
    </section>
@endsection
