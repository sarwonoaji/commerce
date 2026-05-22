<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans Config
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        
        // Debug: Log keys for troubleshooting
        if (empty($serverKey) || empty($clientKey)) {
            \Log::warning('Midtrans keys not configured', [
                'server_key' => $serverKey ? 'set' : 'empty',
                'client_key' => $clientKey ? 'set' : 'empty',
            ]);
        }
        
        Config::$serverKey = $serverKey;
        Config::$clientKey = $clientKey;
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.enable_3ds');
    }

    /**
     * Show payment checkout page
     */
    public function showCheckout(Order $order)
    {
        return view('payment.checkout', compact('order'));
    }

    /**
     * Get Snap Token for payment
     */
    public function getSnapToken(Order $order)
    {
        try {
            // Validate order
            if (!$order || !$order->exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan',
                ], 404);
            }

            // Load relationships if not loaded
            if (!$order->relationLoaded('orderItems')) {
                $order->load('orderItems');
            }

            // Validate order has items
            if ($order->orderItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak memiliki item',
                ], 400);
            }

            // Validate amount
            if ($order->total <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total order harus lebih dari 0',
                ], 400);
            }

            // Build item details
            $item_details = [];
            foreach ($order->orderItems as $item) {
                $item_details[] = [
                    'id' => 'ITEM-' . $item->id,
                    'price' => (int) $item->price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr(trim($item->title ?? 'Item'), 0, 50),
                ];
            }

            // Build payload and persist the actual Midtrans order ID
            $midtransOrderId = 'ORDER-' . $order->id . '-' . time();

            $payload = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => (int) $order->total,
                ],
                'item_details' => $item_details,
                'customer_details' => [
                    'first_name' => substr($order->name ?? 'Customer', 0, 50),
                    'email' => $order->email,
                ],
            ];

            $order->update(['transaction_id' => $midtransOrderId]);

            \Log::info('Midtrans Payload', [
                'payload' => $payload,
                'midtrans_order_id' => $midtransOrderId,
            ]);

            $snapToken = Snap::getSnapToken($payload);
            
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Token Error', [
                'order_id' => $order->id ?? 'unknown',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil snap token: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Handle payment status callback from Midtrans
     */
    public function handleCallback(Request $request)
    {
        $payloadJson = $request->getContent();
        $notification = json_decode($payloadJson);

        $orderId = explode('-', $notification->order_id)[1]; // Extract order ID from order_id
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Keep the actual Midtrans order id in the order record
        if (empty($order->transaction_id) || $order->transaction_id !== $notification->order_id) {
            $order->update(['transaction_id' => $notification->order_id]);
        }

        try {
            /** @var object $transactionStatus */
            $transactionStatus = Transaction::status($notification->order_id);
            
            $statusCode = $transactionStatus->status_code;
            $paymentStatus = $transactionStatus->transaction_status;
            $updateData = [
                'payment_response' => json_encode($notification),
            ];
            
            // Update order status based on payment status
            if ($paymentStatus === 'capture') {
                if ($statusCode === '200') {
                    // Success
                    $order->update(array_merge($updateData, ['status' => 'paid', 'payment_status' => 'success']));
                }
            } elseif ($paymentStatus === 'settlement') {
                // Settlement successful
                $order->update(array_merge($updateData, ['status' => 'paid', 'payment_status' => 'success']));
            } elseif ($paymentStatus === 'pending') {
                // Payment pending
                $order->update(array_merge($updateData, ['status' => 'pending', 'payment_status' => 'pending']));
            } elseif ($paymentStatus === 'deny') {
                // Payment denied
                $order->update(array_merge($updateData, ['status' => 'failed', 'payment_status' => 'failed']));
            } elseif ($paymentStatus === 'cancel') {
                // Payment cancelled
                $order->update(array_merge($updateData, ['status' => 'cancelled', 'payment_status' => 'cancelled']));
            } elseif ($paymentStatus === 'expire') {
                // Payment expired
                $order->update(array_merge($updateData, ['status' => 'expired', 'payment_status' => 'expired']));
            } elseif ($paymentStatus === 'refund') {
                // Payment refunded
                $order->update(array_merge($updateData, ['status' => 'refunded', 'payment_status' => 'refunded']));
            }

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Check payment status
     */
    public function checkStatus(Order $order)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$clientKey = config('midtrans.client_key');
            
            /** @var object $status */
            $status = Transaction::status($order->transaction_id ?: 'ORDER-' . $order->id);
            
            return response()->json([
                'success' => true,
                'transaction_status' => $status->transaction_status,
                'payment_status' => $order->payment_status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show payment status page
     */
    public function paymentStatus(Order $order)
    {
        return view('payment.status', compact('order'));
    }
}
