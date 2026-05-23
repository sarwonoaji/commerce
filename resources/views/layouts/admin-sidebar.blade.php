<div class="space-y-8 rounded-xl p-4">
    <div>
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold">PT ABC Admin</a>
    </div>

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-5V14H9v8H4a1 1 0 0 1-1-1V9.5z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10h-6V6a2 2 0 0 0-2-2H9A2 2 0 0 0 7 6v4H3"/><rect x="3" y="10" width="18" height="11" rx="2" ry="2"/></svg>
            Produks
        </a>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v4H3z"/><path d="M5 7v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7"/><path d="M8 11h8"/></svg>
            Pesanan
        </a>
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('products.index') ? 'bg-white text-primary' : 'text-primary-content hover:bg-white/10 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-8 9 8"/><path d="M21 11v10H3V11"/><path d="M7 21V11h10v10"/></svg>
            Toko Publik
        </a>
    </nav>
</div>
