@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="max-w-4xl">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold">Pesanan #{{ $order->id }}</h2>
                    <p class="text-sm text-slate-500">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="dikemas">
                        <button class="inline-flex items-center rounded-md bg-sky-500 px-3 py-2 text-sm font-medium text-white">Tandai Dikemas</button>
                    </form>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="dikirim">
                        <button class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white">Tandai Dikirim</button>
                    </form>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="selesai">
                        <button class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-medium text-white">Tandai Selesai</button>
                    </form>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="batal">
                        <button class="inline-flex items-center rounded-md bg-rose-500 px-3 py-2 text-sm font-medium text-white">Batalkan</button>
                    </form>

                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-sm font-medium text-white">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <h3 class="font-semibold">Data Pemesan</h3>
                    <p class="mt-2 text-sm"><strong>Nama:</strong> {{ $order->name }}</p>
                    <p class="text-sm"><strong>Email:</strong> {{ $order->email }}</p>
                    <p class="text-sm"><strong>Dibuat oleh:</strong> {{ $order->created_by_name ?? $order->createdBy?->name ?? 'Guest' }}</p>
                    <p class="text-sm mt-2"><strong>Alamat:</strong><br>{{ $order->address }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <h3 class="font-semibold">Ringkasan</h3>
                    <p class="mt-2 text-sm"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <p class="text-sm"><strong>Status:</strong> {{ $order->status }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold mb-3">Item</h3>
                <div class="space-y-3">
                    @if($order->orderItems && $order->orderItems->count())
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between rounded-lg bg-white p-3 border border-slate-100">
                                <div>
                                    <div class="font-medium">{{ $item->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    @else
                        @foreach($order->items ?? [] as $item)
                            <div class="flex items-center justify-between rounded-lg bg-white p-3 border border-slate-100">
                                <div>
                                    <div class="font-medium">{{ $item['title'] }}</div>
                                    <div class="text-xs text-slate-500">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                </div>
                                <div class="font-semibold">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
