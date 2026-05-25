@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="mx-auto max-w-4xl flex h-[80vh] flex-col rounded-2xl bg-white shadow-sm">
            <!-- Header: product summary -->
            <div class="flex items-center gap-4 border-b px-6 py-4">
                <img src="{{ $message->product->image ? asset('img/products/' . $message->product->image) : asset('img/placeholder.png') }}" alt="{{ $message->product->title }}" class="h-16 w-16 rounded-md object-cover" />
                <div>
                    <div class="text-lg font-semibold">{{ $message->product->title }}</div>
                    <div class="text-sm text-slate-500">Rp {{ number_format($message->product->price, 0, ',', '.') }}</div>
                </div>
                <div class="ml-auto text-sm text-slate-500">{{ $message->user->name }} • {{ $message->user->email }}</div>
            </div>

            <!-- Messages area -->
            <div id="chatList" class="flex-1 overflow-auto px-6 py-4">
                <div class="flex flex-col gap-4">
                    @php
                        $items = collect();
                        // push original message as an object compatible with replies
                        $items->push((object)[
                            'is_user' => true,
                            'user' => $message->user,
                            'body' => $message->body,
                            'created_at' => $message->created_at,
                        ]);
                        foreach($message->replies->sortBy('created_at') as $r) {
                            $items->push($r);
                        }
                    @endphp

                    @foreach($items as $item)
                        @php
                            // true = customer, false = admin
                            $isCustomer = isset($item->is_user) ? $item->is_user : ($item->user->id === $message->user_id);
                        @endphp

                        <div class="flex {{ $isCustomer ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-[70%]">
                                <div class="inline-block rounded-2xl px-4 py-3 {{ $isCustomer ? 'bg-white text-slate-900 ring-1 ring-slate-100' : 'bg-emerald-100 text-slate-900' }}">
                                    <div class="text-sm">{{ $item->body }}</div>
                                </div>
                                <div class="mt-1 text-xs text-slate-400 {{ $isCustomer ? 'text-left' : 'text-right' }}">{{ \Illuminate\Support\Str::lower($item->created_at->format('H:i • d M Y')) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Input area (sticky bottom) -->
            <div class="border-t px-6 py-4">
                <form action="{{ route('admin.messages.reply', $message) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <input name="body" type="text" required placeholder="Tulis pesan..." class="flex-1 rounded-full border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100" />
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Kirim</button>
                    <a href="{{ route('admin.messages.index') }}" class="ml-2 inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Auto-scroll chat to bottom on load
        document.addEventListener('DOMContentLoaded', function() {
            const chat = document.getElementById('chatList');
            if (chat) chat.scrollTop = chat.scrollHeight;
        });
    </script>
@endsection
