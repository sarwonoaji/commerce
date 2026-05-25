<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageReplyController extends Controller
{
    public function store(Request $request, Message $message)
    {
        if (!Auth::check() || Auth::id() !== $message->user_id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        MessageReply::create([
            'message_id' => $message->id,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->back()->with('success', 'Balasan Anda telah dikirim.');
    }
}
