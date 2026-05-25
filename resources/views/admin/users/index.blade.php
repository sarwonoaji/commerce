@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Buat User</a>
                </div>

                <form class="mb-0" method="GET" action="{{ route('admin.users.index') }}">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari" class="mt-1 block rounded-xl border border-slate-300 bg-white px-4 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                        <button class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Cari</button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="text-left">
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ ucfirst($user->role) }}</td>
                                <td class="px-4 py-3 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" title="Edit user" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-900 transition">
                                        <span class="sr-only">Edit user</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 15.25V18h2.75l7.764-7.764-2.75-2.75L2 15.25zm1 1H3v-1.25l6.086-6.086 1.25 1.25L3 16.25z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus user" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-900 transition" onclick="return confirm('Hapus user ini?')">
                                            <span class="sr-only">Hapus user</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 4a1 1 0 012 0v8a1 1 0 11-2 0V6zm4 0a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Tidak ada user untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="mt-4 border-t border-slate-200 pt-4">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection
