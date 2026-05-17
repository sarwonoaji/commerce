<div class="space-y-8">
    <div>
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-900">PT ABC Admin</a>
        <p class="mt-2 text-sm text-slate-500">Panel manajemen produk LKS.</p>
    </div>

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            Produk LKS
        </a>
        <a href="{{ route('admin.orders.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            Pesanan
        </a>
        <a href="{{ route('products.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">
            Toko Publik
        </a>
    </nav>
</div>
