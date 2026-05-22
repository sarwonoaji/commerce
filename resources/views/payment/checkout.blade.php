@extends('layouts.shop')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Konfirmasi Pembayaran</h1>
            
            <div class="space-y-4 mb-8">
                <div class="flex justify-between text-slate-600 pb-3 border-b border-slate-200">
                    <span>No. Pesanan</span>
                    <span class="font-semibold text-slate-900">ORDER-{{ $order->id }}</span>
                </div>
                <div class="flex justify-between text-slate-600 pb-3 border-b border-slate-200">
                    <span>Nama Pemesan</span>
                    <span class="font-semibold text-slate-900">{{ $order->name }}</span>
                </div>
                <div class="flex justify-between text-slate-600 pb-3 border-b border-slate-200">
                    <span>Email</span>
                    <span class="font-semibold text-slate-900 text-sm">{{ $order->email }}</span>
                </div>
                <div class="flex justify-between text-slate-600 pb-3 border-b border-slate-200">
                    <span>Alamat</span>
                    <span class="font-semibold text-slate-900 text-sm text-right">{{ substr($order->address, 0, 30) }}...</span>
                </div>
            </div>

            <div class="bg-indigo-50 rounded-xl p-4 mb-8">
                <p class="text-sm text-slate-600 mb-2">Total Pembayaran</p>
                <p class="text-3xl font-bold text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>

            <div id="loading" class="text-center mb-4">
                <div class="inline-flex items-center">
                    <svg class="animate-spin h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-slate-600">Mempersiapkan pembayaran...</span>
                </div>
            </div>

            <button 
                id="pay-button"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition disabled:opacity-50 disabled:cursor-not-allowed"
                disabled
            >
                Bayar Sekarang
            </button>

            <a href="{{ route('products.index') }}" class="block text-center text-sm text-slate-600 hover:text-slate-900 mt-4">
                Batalkan Pesanan
            </a>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    @php
        $snapScriptUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapScriptUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get snap token from server
            fetch('{{ route("payment.snap-token", $order->id) }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const snapToken = data.snap_token;
                    
                    // Hide loading, show button
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('pay-button').disabled = false;
                    
                    // Handle pay button click
                    document.getElementById('pay-button').addEventListener('click', function() {
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                // Payment success
                                window.location.href = '{{ route("payment.status", $order->id) }}';
                            },
                            onPending: function(result) {
                                // Payment pending
                                window.location.href = '{{ route("payment.status", $order->id) }}';
                            },
                            onError: function(result) {
                                // Payment error
                                alert('Pembayaran gagal. Silakan coba lagi.');
                            },
                            onClose: function() {
                                // Customer closed the popup without finishing the payment
                                console.log('Customer closed the payment popup');
                            }
                        });
                    });
                } else {
                    alert('Gagal mengambil snap token: ' + data.message);
                    window.location.href = '{{ route("products.index") }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                window.location.href = '{{ route("products.index") }}';
            });
        });
    </script>
@endsection
