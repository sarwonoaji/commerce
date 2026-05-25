@extends('layouts.shop')

@section('content')
    <section class="space-y-8">
        <div class="rounded-[2rem] bg-white p-6 shadow-xl ring-1 ring-slate-200">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <nav class="text-sm text-slate-500" aria-label="Breadcrumb">
                            <ol class="flex flex-wrap items-center gap-2">
                                <li><a href="{{ route('products.index') }}" class="font-medium hover:text-slate-900">Home</a></li>
                                <li class="text-slate-400">/</li>
                                <li class="font-medium text-slate-900">{{ $product->title }}</li>
                            </ol>
                        </nav>
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">
                            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">{{ $product->title }}</h1>
                            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">Detail Produk</div>
                        </div>
                        <p class="max-w-2xl text-base text-slate-600">{{ $product->publisher }} · {{ $product->grade }} · {{ $product->subject }}</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="rounded-3xl bg-slate-50 px-4 py-3 text-sm text-slate-600 shadow-sm ring-1 ring-slate-100">SKU: {{ $product->sku }}</div>
                        <div class="rounded-3xl px-4 py-3 text-sm font-semibold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }} shadow-sm ring-1 ring-slate-100">
                            {{ $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                        </div>
                    </div>
                </div>

                <div class="grid gap-8 xl:grid-cols-[1.5fr_0.95fr]">
                    <div class="space-y-6">
                        <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-4 shadow-sm">
                            <button id="lightboxTrigger" type="button" class="group relative block overflow-hidden rounded-[1.5rem] bg-slate-100">
                                <img id="mainImage" src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/placeholder.png') }}" alt="{{ $product->title }}" class="h-[520px] w-full object-cover transition duration-500 group-hover:scale-105" />
                                <span class="pointer-events-none absolute inset-x-0 bottom-4 mx-auto flex w-max items-center gap-2 rounded-full bg-slate-950/80 px-4 py-2 text-sm text-white shadow-lg">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0-4l-4.553-2.276A1 1 0 009 8.618v6.764a1 1 0 001.447.894L11 14m4 0H9"/></svg>
                                    Zoom image
                                </span>
                            </button>

                            @if(isset($product->additional_images) && is_array($product->additional_images) && count($product->additional_images))
                                <div class="mt-4 flex gap-3 overflow-x-auto pb-1">
                                    @foreach($product->additional_images as $image)
                                        <button type="button" data-src="{{ asset('img/products/' . $image) }}" class="thumbnail shrink-0 overflow-hidden rounded-3xl ring-1 ring-slate-200 transition hover:ring-indigo-500">
                                            <img src="{{ asset('img/products/' . $image) }}" alt="Thumbnail {{ $product->title }}" class="h-20 w-28 object-cover" />
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                                <h2 class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Tentang Produk</h2>
                                <p class="mt-3 text-slate-700">{{ $product->subject }} untuk jenjang {{ $product->grade }} dari penerbit {{ $product->publisher }}.</p>
                            </div>
                            <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                                <h2 class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Kategori</h2>
                                <p class="mt-3 text-slate-700">{{ $product->subject }} • {{ $product->grade }}</p>
                            </div>
                        </div>

                        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                            <h2 class="text-lg font-semibold text-slate-900">Deskripsi Produk</h2>
                            <div class="mt-4 space-y-4 text-slate-600 leading-7">{!! nl2br(e($product->description)) !!}</div>
                        </div>

                        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
                            <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                                <div class="flex items-center justify-between gap-4">
                                    <h2 class="text-lg font-semibold text-slate-900">Produk Terkait</h2>
                                    <a href="{{ route('products.index') }}?subject={{ urlencode($product->subject) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Lihat semua</a>
                                </div>
                                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                    @foreach($relatedProducts as $related)
                                        <a href="{{ route('products.show', $related) }}" class="group overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:shadow-lg">
                                            <div class="overflow-hidden rounded-3xl bg-white">
                                                <img src="{{ $related->image ? asset('img/products/' . $related->image) : asset('img/placeholder.png') }}" alt="{{ $related->title }}" class="h-32 w-full object-cover transition duration-500 group-hover:scale-105" />
                                            </div>
                                            <div class="mt-4">
                                                <p class="text-sm font-semibold text-slate-900">{{ $related->title }}</p>
                                                <p class="mt-2 text-sm text-slate-500">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <aside class="space-y-4">
                        <div class="sticky top-24 space-y-4">
                            <div class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm uppercase tracking-[0.22em] text-slate-500">Harga</p>
                                        <p class="mt-3 text-3xl font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="rounded-3xl bg-indigo-50 px-3 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-700">Termurah</div>
                                </div>

                                <div class="mt-6 space-y-4 text-sm text-slate-600">
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-3">
                                        <span class="font-medium text-slate-800">Stok</span>
                                        <span>{{ $product->stock }}</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-3">
                                        <span class="font-medium text-slate-800">Kondisi</span>
                                        <span>Baru</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-3">
                                        <span class="font-medium text-slate-800">Pengiriman</span>
                                        <span>2-5 hari</span>
                                    </div>
                                </div>

                                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6 space-y-4">
                                    @csrf
                                    <div class="grid gap-3">
                                        <label for="quantity" class="text-sm font-medium text-slate-700">Jumlah</label>
                                        <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" @if($product->stock < 1) disabled @endif class="w-full rounded-3xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:bg-slate-100" />
                                    </div>
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-3xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 disabled:cursor-not-allowed disabled:bg-slate-300" @if($product->stock < 1) disabled @endif>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h12.1a1 1 0 00.9-1.5L17 13M7 13V6a1 1 0 011-1h10a1 1 0 011 1v7"/></svg>
                                        Tambahkan ke Keranjang
                                    </button>
                                    <a href="{{ route('checkout.index') }}" class="block text-center text-sm font-semibold text-indigo-600 hover:text-indigo-800">Beli Sekarang</a>
                                </form>
                                <div class="mt-4">
                                    @if(session('success'))
                                        <div class="rounded-md bg-emerald-50 p-3 text-emerald-700">{{ session('success') }}</div>
                                    @endif
                                    <button id="openChatBtn" type="button" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Tanya Admin</button>
                                </div>
                            </div>

                            <div class="rounded-[1.75rem] bg-slate-50 p-6 text-slate-700 shadow-sm ring-1 ring-slate-100">
                                <h3 class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Layanan</h3>
                                <ul class="mt-4 space-y-3 text-sm">
                                    <li class="flex items-start gap-3">
                                        <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">✓</span>
                                        <span>Belanja aman dan terpercaya.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">✓</span>
                                        <span>Pengiriman cepat dan terpantau.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div class="fixed inset-x-0 bottom-0 z-20 bg-white/95 px-4 py-4 shadow-[0_-12px_40px_rgba(15,23,42,0.08)] backdrop-blur-sm sm:px-6 lg:hidden" style="padding-bottom: calc(env(safe-area-inset-bottom) + 1rem);">
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mx-auto flex max-w-4xl items-center gap-3">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" @if($product->stock < 1) disabled @endif class="w-24 rounded-3xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:bg-slate-100" />
                <button type="submit" class="flex-1 rounded-3xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-slate-300" @if($product->stock < 1) disabled @endif>Tambah ke Keranjang</button>
                <a href="{{ route('checkout.index') }}" class="rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 text-center">Beli</a>
            </form>
        </div>

        <div class="h-[90px] lg:hidden"></div>

        <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 p-4" aria-hidden="true">
            <button id="lightboxClose" type="button" class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-900 shadow-lg">×</button>
            <img id="lightboxImage" src="" alt="Preview" class="max-h-[90vh] max-w-full rounded-3xl shadow-2xl" />
        </div>

        @if(isset($userMessages) && $userMessages->isNotEmpty())
            <div class="mt-6 rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <h2 class="text-lg font-semibold text-slate-900">Percakapan Anda tentang produk ini</h2>
                <div class="mt-4 space-y-4">
                    @foreach($userMessages as $um)
                        <div class="rounded-lg border p-4">
                            <div class="text-sm text-slate-700">Anda • {{ $um->created_at->diffForHumans() }}</div>
                            <div class="mt-2 whitespace-pre-line text-slate-700">{{ $um->body }}</div>

                            @if($um->replies->isNotEmpty())
                                <div class="mt-4 space-y-3">
                                    @foreach($um->replies as $reply)
                                        <div class="rounded-lg bg-slate-50 p-3">
                                            <div class="text-sm font-semibold">{{ $reply->user->name }} <span class="text-xs text-slate-500">• {{ $reply->created_at->diffForHumans() }}</span></div>
                                            <div class="mt-1 text-slate-700">{{ $reply->body }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('messages.reply.store', $um) }}" method="POST" class="mt-4">
                                @csrf
                                <textarea name="body" rows="3" required class="w-full rounded-lg border border-slate-200 p-3 text-sm" placeholder="Balas pesan..."></textarea>
                                <div class="mt-2 text-right">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-3xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Kirim Balasan</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div id="chatModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
            <div class="w-full max-w-xl rounded-2xl bg-white p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Kirim Pesan ke Admin</h3>
                    <button id="closeChatBtn" type="button" class="text-slate-700">×</button>
                </div>
                <form action="{{ route('products.messages.store', $product) }}" method="POST" class="mt-4">
                    @csrf
                    <div>
                        <label for="body" class="sr-only">Pesan</label>
                        <textarea id="body" name="body" rows="4" required class="w-full rounded-lg border border-slate-200 p-3 text-sm"></textarea>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-3xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Kirim</button>
                        <button id="cancelChatBtn" type="button" class="inline-flex items-center gap-2 rounded-3xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        const mainImage = document.getElementById('mainImage');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxTrigger = document.getElementById('lightboxTrigger');
        const lightboxClose = document.getElementById('lightboxClose');

        function openLightbox(src) {
            lightboxImage.src = src;
            lightbox.classList.remove('hidden');
            lightbox.setAttribute('aria-hidden', 'false');
        }

        if (lightboxTrigger) {
            lightboxTrigger.addEventListener('click', () => openLightbox(mainImage.src));
        }

        document.querySelectorAll('.thumbnail').forEach((button) => {
            button.addEventListener('click', () => {
                const src = button.dataset.src;
                if (!src) return;
                mainImage.src = src;
                openLightbox(src);
            });
        });

        if (lightboxClose) {
            lightboxClose.addEventListener('click', () => {
                lightbox.classList.add('hidden');
                lightbox.setAttribute('aria-hidden', 'true');
            });
        }

        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                lightbox.classList.add('hidden');
                lightbox.setAttribute('aria-hidden', 'true');
            }
        });

        // Chat modal
        const chatModal = document.getElementById('chatModal');
        const openChatBtn = document.getElementById('openChatBtn');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const cancelChatBtn = document.getElementById('cancelChatBtn');

        function openChat() {
            chatModal.classList.remove('hidden');
        }

        function closeChat() {
            chatModal.classList.add('hidden');
        }

        if (openChatBtn) openChatBtn.addEventListener('click', openChat);
        if (closeChatBtn) closeChatBtn.addEventListener('click', closeChat);
        if (cancelChatBtn) cancelChatBtn.addEventListener('click', closeChat);

        chatModal.addEventListener('click', (e) => {
            if (e.target === chatModal) closeChat();
        });
    </script>
@endsection
