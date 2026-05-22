<div class="space-y-8 rounded-xl p-4">
    <div>
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold">PT ABC Admin</a>
        <p class="mt-2 text-sm">Panel manajemen produk LKS.</p>
    </div>

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            Produk LKS
        </a>
        <a href="{{ route('admin.orders.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            Pesanan
        </a>
        <a href="{{ route('products.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('products.index') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            Toko Publik
        </a>
    </nav>
</div>
