@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="max-w-6xl">
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
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center rounded-md bg-slate-900 px-3 py-2 text-sm font-medium text-white">Lihat</a>
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
