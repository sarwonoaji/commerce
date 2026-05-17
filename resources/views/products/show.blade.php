@extends('layouts.shop')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr]">
        <div class="overflow-hidden rounded-[2rem] bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
            <div class="relative overflow-hidden">
                <img src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/placeholder.png') }}" alt="{{ $product->title }}" class="h-[520px] w-full object-cover transition duration-500 hover:scale-105" />
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/90 to-transparent p-6 text-white">
                    <div class="inline-flex flex-wrap gap-2">
                        <span class="rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em]">{{ $product->grade }}</span>
                        <span class="rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em]">{{ $product->subject }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-8 sm:p-10">
                <div class="space-y-2">
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">{{ $product->title }}</h1>
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-500">{{ $product->publisher }}</p>
                </div>

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-3xl font-semibold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="mt-2 text-sm text-slate-500">Stok tersedia: <span class="font-semibold text-slate-900">{{ $product->stock }}</span></p>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-full bg-slate-100 px-4 py-3 text-sm font-medium text-slate-700">
                        SKU: {{ $product->sku }}
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.5rem] bg-slate-50 p-5">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Penggunaan</h2>
                        <p class="mt-3 text-slate-700">{{ $product->subject }} untuk kelas {{ $product->grade }}.</p>
                    </div>
                    <div class="rounded-[1.5rem] bg-slate-50 p-5">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Penerbit</h2>
                        <p class="mt-3 text-slate-700">{{ $product->publisher }}</p>
                    </div>
                </div>

                <div class="rounded-[1.5rem] bg-slate-50 p-6">
                    <h2 class="text-lg font-semibold text-slate-900">Deskripsi Produk</h2>
                    <p class="mt-3 text-slate-600 leading-7">{{ $product->description }}</p>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
                    @csrf
                    <div class="grid gap-2">
                        <label class="text-sm font-medium text-slate-700">Jumlah</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-[2rem] bg-white p-6 shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <h2 class="text-xl font-semibold text-slate-900">Ringkasan Produk</h2>
                <div class="mt-5 space-y-4 text-sm text-slate-600">
                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-4">
                        <span class="font-medium text-slate-800">Judul</span>
                        <span>{{ $product->title }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-4">
                        <span class="font-medium text-slate-800">Jenjang</span>
                        <span>{{ $product->grade }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-4">
                        <span class="font-medium text-slate-800">Mata Pelajaran</span>
                        <span>{{ $product->subject }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-4">
                        <span class="font-medium text-slate-800">Penerbit</span>
                        <span>{{ $product->publisher }}</span>
                    </div>
                </div>
            </div>
            <div class="rounded-[2rem] bg-slate-900 p-6 text-white shadow-[0_24px_80px_rgba(15,23,42,0.15)]">
                <h3 class="text-lg font-semibold">Mengapa pilih PT ABC?</h3>
                <p class="mt-4 text-sm leading-6 text-slate-300">Produk resmi, kualitas terjamin, dan dukungan pembelajaran yang sesuai kurikulum. Belanja sekarang untuk persiapan sekolah yang lebih tenang.</p>
            </div>
        </aside>
    </section>
@endsection
