@extends('layouts.shop')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full">
            @if ($order->payment_status === 'success' || $order->status === 'paid')
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-green-600 mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-gray-600 mb-6">Terima kasih telah melakukan pemesanan. Pesanan Anda telah berhasil dibayar.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">No. Pesanan:</span>
                            <span class="font-semibold text-gray-900">ORDER-{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold text-green-600">Dibayar</span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-6">Email konfirmasi telah dikirim ke <span class="font-semibold">{{ $order->email }}</span></p>

                    <div class="space-y-3">
                        <a href="{{ route('orders.show', $order->id) }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-xl transition">
                            Lihat Detail Pesanan
                        </a>
                        <a href="{{ route('products.index') }}" class="block w-full border border-emerald-500 text-emerald-500 hover:bg-emerald-50 font-semibold py-3 rounded-xl transition">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            @elseif ($order->payment_status === 'pending')
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                            <svg class="w-8 h-8 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-yellow-600 mb-2">Pembayaran Tertunda</h1>
                    <p class="text-gray-600 mb-6">Pembayaran Anda sedang diproses. Mohon tunggu sebentar.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">No. Pesanan:</span>
                            <span class="font-semibold text-gray-900">ORDER-{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold text-yellow-600">Menunggu</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button onclick="location.reload()" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-xl transition">
                            Refresh Status
                        </button>
                        <a href="{{ route('products.index') }}" class="block w-full border border-yellow-500 text-yellow-600 hover:bg-yellow-50 font-semibold py-3 rounded-xl transition">
                            Kembali ke Toko
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-red-600 mb-2">Pembayaran Gagal</h1>
                    <p class="text-gray-600 mb-6">Pembayaran Anda tidak dapat diproses. Status: <span class="font-semibold">{{ ucfirst($order->payment_status) }}</span></p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">No. Pesanan:</span>
                            <span class="font-semibold text-gray-900">ORDER-{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold text-red-600">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition">
                            Coba Pembayaran Lagi
                        </a>
                        <a href="{{ route('products.index') }}" class="block w-full border border-red-500 text-red-600 hover:bg-red-50 font-semibold py-3 rounded-xl transition">
                            Kembali ke Toko
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
