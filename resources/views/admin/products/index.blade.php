@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('description', 'CRUD produk LKS untuk admin PT ABC.')
@section('action')
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Tambah Produk</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden p-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <label for="search" class="sr-only">Cari Produk</label>
                    <input id="search" name="search" type="text" value="{{ $search ?? '' }}" placeholder="Cari judul, kelas, mata pelajaran, publisher, atau SKU" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Stok</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->grade }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">Belum ada produk. Tambahkan produk baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $products->links() }}
        </div>
    </div>
@endsection
