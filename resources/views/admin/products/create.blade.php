@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')
@section('description', 'Masukkan data LKS baru untuk ditayangkan di katalog.')
@section('action')
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kembali ke Produk</a>
@endsection

@section('content')
    <div class="max-w-4xl">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Grade</label>
                        <input type="text" name="grade" value="{{ old('grade') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('grade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Mata Pelajaran</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Penerbit</label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('publisher') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('sku') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Harga</label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" min="0" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>
                        @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" required>{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Upload gambar --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Gambar (opsional)</label>
                    <input type="file" name="image" accept="image/*" class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection
