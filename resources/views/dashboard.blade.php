@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('description', 'Selamat datang di dashboard admin PT ABC. Gunakan menu di samping untuk mengelola produk LKS yang tersedia di toko.')
@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Dashboard Admin</h1>
                    <p class="mt-1 text-sm text-slate-600">{{ __('Anda sekarang dapat mengelola produk, melihat statistik penjualan, dan memperbarui persediaan LKS.') }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kelola Produk LKS</a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Selamat Datang</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Gunakan menu di samping untuk menambahkan, mengubah, atau menghapus produk LKS.') }}</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Info Admin</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Pastikan data stok dan harga produk selalu terbaru agar pelanggan mendapatkan informasi yang akurat.') }}</p>
            </div>
        </div>
    </div>
@endsection