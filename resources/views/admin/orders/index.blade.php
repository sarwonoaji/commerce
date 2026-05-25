@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Daftar Pesanan</h2>

            <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <label for="orderSearch" class="sr-only">Cari Pesanan</label>
                    <input id="orderSearch" name="q" type="search" value="{{ request('q') }}" placeholder="Cari nama, email, status, pembuat..." class="w-full min-w-0 rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" />
                </div>
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-sm text-slate-600">
                            <th class="py-2">#</th>
                            <th class="py-2">Nama</th>
                            <th class="py-2">Dibuat Oleh</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        @foreach($orders as $order)
                            <tr class="border-t border-slate-100">
                                <td class="py-3">{{ $order->id }}</td>
                                <td class="py-3">{{ $order->name }}</td>
                                <td class="py-3">{{ $order->created_by_name ?? $order->createdBy?->name ?? 'Guest' }}</td>
                                <td class="py-3">{{ $order->email }}</td>
                                <td class="py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-3">{{ $order->status }}</td>
                                <td class="py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" title="Lihat pesanan" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-900 transition">
                                        <span class="sr-only">Lihat pesanan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zm0 8a3 3 0 110-6 3 3 0 010 6z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
@endsection
