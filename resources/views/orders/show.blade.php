@extends('layouts.shop')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white p-8 shadow-xl ring-1 ring-slate-200">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Detail Pesanan</p>
                    <h1 class="text-3xl font-semibold text-slate-900">Pesanan #{{ $order->id }}</h1>
                    <p class="mt-2 text-slate-600">Tanggal: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center rounded-full border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">Kembali ke Riwayat</a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-2">
                <h2 class="text-xl font-semibold text-slate-900">Rincian Pesanan</h2>
                <div class="mt-4 space-y-4 text-sm text-slate-600">
                    <div>
                        <p class="text-slate-500">Nama</p>
                        <p class="font-semibold text-slate-900">{{ $order->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Email</p>
                        <p class="font-semibold text-slate-900">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Alamat</p>
                        <p class="font-semibold text-slate-900">{{ $order->address }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Status</p>
                        <p class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-900">{{ $order->status }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-slate-900">Item Pesanan</h3>
                    <div class="mt-4 space-y-3">
                        @if($order->orderItems->count())
                            @foreach($order->orderItems as $item)
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $item->title }}</p>
                                            <p class="text-sm text-slate-500">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-semibold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($order->items ?? [] as $item)
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $item['title'] ?? 'Produk' }}</p>
                                            <p class="text-sm text-slate-500">Qty: {{ $item['quantity'] ?? 1 }}</p>
                                        </div>
                                        <p class="font-semibold text-slate-900">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <aside class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="text-xl font-semibold text-slate-900">Ringkasan Pembayaran</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pengiriman</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="flex justify-between font-semibold text-slate-900">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
