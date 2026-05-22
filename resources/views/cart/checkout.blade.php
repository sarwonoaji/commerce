@extends('layouts.shop')

@section('content')
    <div class="grid gap-8 lg:grid-cols-[0.75fr_0.45fr]">
        <section class="overflow-hidden rounded-[2rem] bg-white p-8 shadow-[0_24px_80px_rgba(15,23,42,0.06)]">
            <h1 class="text-3xl font-semibold text-slate-900 mb-4">Checkout</h1>
            <p class="text-sm text-slate-600 mb-6">Lengkapi data pengiriman untuk menyelesaikan pemesanan. Pastikan alamat dan kontak dapat dihubungi.</p>

            <form action="{{ route('checkout.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Alamat Pengiriman</label>
                    <textarea name="address" rows="4" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-200" required></textarea>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Kembali ke Keranjang</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-[1.5rem] bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-600">Bayar Sekarang</button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <div class="overflow-hidden rounded-[1.75rem] bg-white p-6 shadow-[0_18px_60px_rgba(15,23,42,0.06)]">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Ringkasan Pesanan</h2>

                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="flex items-center gap-3">
                            <img src="{{ isset($item['image']) && $item['image'] ? asset('img/products/' . $item['image']) : asset('img/placeholder.png') }}" alt="{{ $item['title'] }}" class="h-16 w-12 rounded-md object-cover" />
                            <div class="flex-1">
                                <div class="text-sm font-medium text-slate-900">{{ $item['title'] }}</div>
                                <div class="text-xs text-slate-500">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="text-sm font-semibold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 border-t border-slate-100 pt-4">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm text-slate-600">
                        <span>Estimasi Ongkos Kirim</span>
                        <span>—</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
@endsection
