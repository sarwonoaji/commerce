@extends('layouts.shop')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Pesanan Saya</p>
                    <h1 class="text-3xl font-semibold text-slate-900">Riwayat Pesanan</h1>
                    <p class="mt-2 text-slate-600">Lihat status dan detail pesanan yang telah Anda buat di toko PT ABC.</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @if ($orders->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-700">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-b border-slate-100">
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $order->id }}</td>
                                    <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">{{ $orders->links() }}</div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 p-8 text-center">
                    <p class="text-lg font-semibold text-slate-900">Belum ada pesanan</p>
                    <p class="mt-2 text-slate-600">Anda belum membuat pesanan apapun. Mulai belanja sekarang untuk membuat pesanan baru.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Kembali ke Produk</a>
                </div>
            @endif
        </div>
    </div>
@endsection
