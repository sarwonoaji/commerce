@extends('layouts.shop')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white p-8 shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Keranjang Belanja</h1>
                    <p class="mt-2 max-w-2xl text-slate-600">Tinjau pesanan kamu sebelum lanjut ke checkout. Ubah jumlah atau hapus produk dengan mudah.</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-slate-50 px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Lanjut Belanja</a>
            </div>

            @if(empty($cart))
                <div class="mt-10 rounded-[1.75rem] bg-slate-50 p-10 text-center text-slate-600">
                    <p class="text-lg font-medium text-slate-900">Keranjang kamu masih kosong</p>
                    <p class="mt-3">Tambahkan produk LKS dari katalog agar bisa melanjutkan pembelian.</p>
                </div>
            @else
                <div class="mt-10 grid gap-6 xl:grid-cols-[1.5fr_0.5fr]">
                    <div class="space-y-4">
                        @foreach($cart as $item)
                            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                    <div class="flex items-start">
                                        <input type="checkbox" class="cart-select mt-2 mr-4 h-5 w-5 rounded border-slate-300" value="{{ $item['id'] }}" data-price="{{ $item['price'] }}" data-quantity="{{ $item['quantity'] }}" id="select-{{ $item['id'] }}">
                                    </div>
                                    <img src="{{ $item['image'] ? asset('img/products/' . $item['image']) : asset('img/placeholder.png') }}" alt="{{ $item['title'] }}" class="h-24 w-24 rounded-3xl object-cover" />
                                    <div class="flex-1">
                                        <div class="text-lg font-semibold text-slate-900">{{ $item['title'] }}</div>
                                        <div class="mt-1 text-sm text-slate-500">{{ $item['grade'] }} · {{ $item['subject'] }}</div>
                                        <div class="mt-3 grid gap-2 sm:grid-cols-3 sm:items-center">
                                            <div class="rounded-3xl bg-white px-4 py-3 text-sm text-slate-700">Jumlah: {{ $item['quantity'] }}</div>
                                            <div class="rounded-3xl bg-white px-4 py-3 text-sm text-slate-700">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                            <div class="rounded-3xl bg-white px-4 py-3 text-sm text-slate-700">Subtotal: Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-rose-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[1.75rem] bg-slate-900 p-6 text-white shadow-lg">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Ringkasan Pesanan</p>
                            <div class="mt-6 space-y-4">
                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <span>Subtotal</span>
                                    <span id="summary-subtotal">Rp 0</span>
                                </div>
                                <div class="rounded-3xl bg-slate-800 p-4 text-sm text-slate-300">
                                    <p class="font-medium text-slate-100">Estimasi ongkos kirim</p>
                                    <p class="mt-2 text-xs text-slate-400">Biaya pengiriman akan dihitung di halaman checkout.</p>
                                </div>
                                <div class="rounded-3xl bg-slate-800 p-4 text-sm text-slate-300">
                                    <p class="font-medium text-slate-100">Total</p>
                                    <p id="summary-total" class="mt-2 text-xl font-semibold text-white">Rp 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <form id="checkout-selected-form" action="{{ route('cart.checkout') }}" method="POST" style="display:none;">
                                @csrf
                                {{-- selected[] inputs appended by JS --}}
                            </form>

                            <button id="checkout-selected-btn" class="inline-flex w-full items-center justify-center rounded-[1.5rem] bg-amber-500 px-6 py-4 text-sm font-semibold text-white transition hover:bg-amber-600">Checkout Item yang Dipilih</button>

                            <a href="{{ route('checkout.index') }}" class="inline-flex w-full items-center justify-center rounded-[1.5rem] border border-slate-200 bg-white px-6 py-4 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Checkout Semua</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        (function(){
            const btn = document.getElementById('checkout-selected-btn');
            const form = document.getElementById('checkout-selected-form');
            const subtotalEl = document.getElementById('summary-subtotal');
            const totalEl = document.getElementById('summary-total');

            const fmt = (n) => n.toLocaleString('id-ID');

            function computeSummary(){
                const checkedBoxes = Array.from(document.querySelectorAll('.cart-select:checked'));
                let subtotal = 0;
                checkedBoxes.forEach(cb => {
                    const price = parseFloat(cb.dataset.price) || 0;
                    const qty = parseInt(cb.dataset.quantity) || 1;
                    subtotal += price * qty;
                });

                if (subtotalEl) subtotalEl.textContent = 'Rp ' + fmt(subtotal);
                if (totalEl) totalEl.textContent = 'Rp ' + fmt(subtotal);

                if (btn) {
                    const disabled = checkedBoxes.length === 0;
                    btn.disabled = disabled;
                    btn.classList.toggle('opacity-60', disabled);
                    btn.classList.toggle('cursor-not-allowed', disabled);
                }
            }

            // attach listeners
            document.querySelectorAll('.cart-select').forEach(cb => cb.addEventListener('change', computeSummary));

            // initialize
            computeSummary();

            btn?.addEventListener('click', function(){
                const checked = Array.from(document.querySelectorAll('.cart-select:checked')).map(cb => cb.value);
                if (!checked.length) {
                    alert('Pilih minimal satu item untuk dilanjutkan ke checkout.');
                    return;
                }

                // clear previous inputs
                form.querySelectorAll('input[name="selected[]"]').forEach(n => n.remove());

                checked.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected[]';
                    input.value = id;
                    form.appendChild(input);
                });

                form.submit();
            });
        })();
    </script>
@endsection

