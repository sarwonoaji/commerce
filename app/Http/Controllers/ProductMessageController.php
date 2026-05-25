<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductMessageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim ke admin.');
    }
}
