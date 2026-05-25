@extends('layouts.admin')

@section('title', 'Pesan Pelanggan')
@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Pesan Pelanggan</h1>
        </div>

        <div class="mt-6 overflow-hidden rounded-lg border">
            <table class="w-full table-auto">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Pesan</th>
                        <th class="px-4 py-3">Dikirim</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $message->user->name }}<div class="text-sm text-slate-500">{{ $message->user->email }}</div></td>
                            <td class="px-4 py-3">{{ $message->product->title }}</td>
                            <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($message->body, 80) }}</td>
                            <td class="px-4 py-3">{{ $message->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.messages.show', $message) }}" title="Lihat pesan" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-900 transition">
                                    <span class="sr-only">Lihat pesan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3C6 3 2.73 5.11 1 8c1.73 2.89 5 5 9 5s7.27-2.11 9-5c-1.73-2.89-5-5-9-5zm0 8a3 3 0 110-6 3 3 0 010 6z" />
                                        </svg>
                                </a>
                                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus pesan" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-900 transition" onclick="return confirm('Hapus pesan ini?')">
                                        <span class="sr-only">Hapus pesan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 4a1 1 0 012 0v8a1 1 0 11-2 0V6zm4 0a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada pesan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $messages->links() }}</div>
    </div>
@endsection
