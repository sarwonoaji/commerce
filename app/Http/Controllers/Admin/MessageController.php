<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\MessageReply;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['product', 'user'])->latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        if (!$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        $message->load(['product', 'user', 'replies.user']);

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan dihapus.');
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        MessageReply::create([
            'message_id' => $message->id,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('admin.messages.show', $message)->with('success', 'Balasan terkirim.');
    }
}
