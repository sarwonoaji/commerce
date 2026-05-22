<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $ordersQuery = Order::with('createdBy')->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $query = $request->input('q');
            $ordersQuery->where(function ($builder) use ($query) {
                $builder->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('status', 'like', "%{$query}%")
                    ->orWhere('created_by_name', 'like', "%{$query}%");
            });
        }

        $orders = $ordersQuery->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeAdmin();

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $this->authorizeAdmin();

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan dihapus.');
    }

    /**
     * Update order status (admin action)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $valid = ['pending', 'dikemas', 'dikirim', 'selesai', 'batal'];

        $data = $request->validate([
            'status' => 'required|string|in:' . implode(',', $valid),
        ]);

        $order->status = $data['status'];
        $order->save();

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan diperbarui.');
    }
}
