<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('grade')->orderBy('subject')->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'grade' => $product->grade,
                'subject' => $product->subject,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session('cart', []);
        $total = collect($cart)->reduce(fn ($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Store selected cart items to session and redirect to checkout page.
     */
    public function proceedToCheckout(Request $request)
    {
        $data = $request->validate([
            'selected' => 'required|array|min:1',
            'selected.*' => 'integer',
        ]);

        $cart = session('cart', []);

        $selected = [];
        foreach ($data['selected'] as $id) {
            foreach ($cart as $item) {
                if ((int) $item['id'] === (int) $id) {
                    $selected[$id] = $item;
                    break;
                }
            }
        }

        if (empty($selected)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        session(['checkout_cart' => $selected]);

        return redirect()->route('checkout.index');
    }

    public function cartRemove(Product $product)
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk di keranjang berhasil dihapus.');
    }

    public function checkout()
    {
        // Prefer the selected checkout cart if present, otherwise use full cart
        $cart = session('checkout_cart', session('cart', []));

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Tambahkan produk terlebih dahulu.');
        }

        $total = collect($cart)->reduce(fn ($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function checkoutSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
        ]);

        $checkoutCart = session('checkout_cart', session('cart', []));

        if (empty($checkoutCart)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item untuk diproses.');
        }

        // prepare items and total
        $items = [];
        $total = 0;
        foreach ($checkoutCart as $item) {
            $items[] = [
                'id' => $item['id'] ?? null,
                'title' => $item['title'] ?? null,
                'price' => $item['price'] ?? 0,
                'quantity' => $item['quantity'] ?? 1,
            ];

            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        // store order
        $order = \App\Models\Order::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'items' => $items,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => 'midtrans',
            'payment_status' => 'pending',
            'created_by' => $request->user()->id,
            'created_by_name' => $request->user()->name,
        ]);

        // also persist items in order_items table for easier querying
        foreach ($items as $it) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $it['id'] ?? null,
                'title' => $it['title'] ?? null,
                'price' => $it['price'] ?? 0,
                'quantity' => $it['quantity'] ?? 1,
                'subtotal' => ($it['price'] ?? 0) * ($it['quantity'] ?? 1),
            ]);
        }

        // clear cart sessions
        Session::forget(['cart', 'checkout_cart']);

        // redirect to payment page
        return redirect()->route('payment.checkout', $order->id);
    }
}
