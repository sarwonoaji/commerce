@extends('layouts.shop')

@section('content')
    <section class="space-y-8">
        <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
            <div class="grid gap-8 lg:grid-cols-[1.4fr_1fr] lg:items-center">
                <div class="max-w-2xl">
                    <p class="mb-3 text-sm uppercase tracking-[0.35em] text-slate-500">PT ABC E-Commerce</p>
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">Toko LKS & Buku Sekolah</h1>
                    <p class="mt-4 text-slate-600 leading-7">Temukan LKS dan buku sekolah yang dirancang untuk mendukung pembelajaran SD, SMP, dan SMA. Belanja materi latihan, soal ujian, dan buku persiapan sekolah secara mudah.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">Lihat Keranjang</a>
                        <a href="#products" class="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Lihat Produk</a>
                    </div>
                </div>
                <div class="rounded-[1.75rem] bg-slate-50 p-6 shadow-inner shadow-slate-200/40">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm text-slate-500">Produk Tersedia</p>
                            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $products->count() }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm text-slate-500">Ketersediaan Stok</p>
                            <p class="mt-3 text-3xl font-semibold text-slate-900">Cepat, lengkap, siap kirim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="products" class="space-y-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Katalog Produk</p>
                    <h2 class="text-3xl font-semibold text-slate-900">Pilihan LKS Terbaru</h2>
                </div>
                <p class="text-sm text-slate-500">Temukan LKS sesuai jenjang, mata pelajaran, dan kebutuhan belajar.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($products as $product)
                    <article class="group overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative overflow-hidden bg-slate-100">
                            <img loading="lazy" decoding="async" src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/placeholder.png') }}" alt="{{ $product->title }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105" />
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/80 to-transparent p-4 text-white">
                                <p class="text-sm uppercase tracking-[0.3em] text-slate-100">{{ $product->grade }} • {{ $product->subject }}</p>
                            </div>
                        </div>
                        <div class="p-6 sm:p-7">
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
                                        <button type="submit" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Beli</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </section>
@endsection
