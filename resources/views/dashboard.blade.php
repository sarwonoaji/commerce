@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('description', 'Selamat datang di dashboard admin PT ABC. Gunakan menu di samping untuk mengelola produk LKS yang tersedia di toko.')
@section('content')
    <div class="space-y-6">
        <!-- <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Dashboard Admin</h1>
                    <p class="mt-1 text-sm text-slate-600">{{ __('Anda sekarang dapat mengelola produk, melihat statistik penjualan, dan memperbarui persediaan LKS.') }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kelola Produk LKS</a>
                </div>
            </div>
        </div> -->
<!-- 
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Selamat Datang</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Gunakan menu di samping untuk menambahkan, mengubah, atau menghapus produk LKS.') }}</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Info Admin</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Pastikan data stok dan harga produk selalu terbaru agar pelanggan mendapatkan informasi yang akurat.') }}</p>
            </div>
        </div> -->
        <div class="grid gap-6 lg:grid-cols-4">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Produk</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $productCount ?? 0 }}</div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Pesanan</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $orderCount ?? 0 }}</div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Pengguna</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $userCount ?? 0 }}</div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Pendapatan</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Pesanan Terbaru</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-600">
                            <th class="py-2">#</th>
                            <th class="py-2">Nama</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr class="border-t">
                                <td class="py-3">{{ $order->id }}</td>
                                <td class="py-3">{{ $order->name }}</td>
                                <td class="py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-3">{{ $order->status }}</td>
                                <td class="py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4" colspan="5">Tidak ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection