<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $search = $request->input('search');

        $products = Product::query();

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('grade', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $products->orderBy('grade')->orderBy('subject')->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'grade' => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'publisher' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // upload foto
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = uniqid('products_', true) . '.' . $file->extension();
            $destination = public_path('img/products');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $this->authorizeAdmin();

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'grade' => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'publisher' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->file('image')) {

            // hapus image lama jika ada
            if ($product->image) {
                $oldImage = public_path('img/products/' . $product->image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // upload image baru
            $file = $request->file('image');
            $filename = uniqid('products_', true) . '.' . $file->extension();
            $destination = public_path('img/products');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        // hapus image jika ada
        if ($product->image) {
            $oldImage = public_path('img/products/' . $product->image);

            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
