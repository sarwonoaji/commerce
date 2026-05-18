<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransTestPayload extends Command
{
    protected $signature = 'midtrans:test-payload {order_id}';
    protected $description = 'Test Midtrans payload dengan order specific';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        $this->line('🔍 Testing Midtrans Payload for Order #' . $orderId);
        $this->newLine();

        // Load order
        $order = Order::with('orderItems')->find($orderId);

        if (!$order) {
            $this->error('❌ Order tidak ditemukan');
            return 1;
        }

        // Display order data
        $this->line('📋 Order Data:');
        $this->line('─────────────────────────────────────────');
        $this->line('Order ID: ' . $order->id);
        $this->line('Name: ' . $order->name);
        $this->line('Email: ' . $order->email);
        $this->line('Total: ' . $order->total);
        $this->line('Status: ' . $order->status);
        $this->newLine();

        // Display items
        $this->line('📦 Order Items:');
        $this->line('─────────────────────────────────────────');
        
        if ($order->orderItems->isEmpty()) {
            $this->error('❌ NO ITEMS IN THIS ORDER!');
            return 1;
        }

        foreach ($order->orderItems as $item) {
            $this->line('  - ' . $item->title . ' (ID: ' . $item->id . ')');
            $this->line('    Price: ' . $item->price . ' x ' . $item->quantity . ' = ' . ($item->price * $item->quantity));
        }
        $this->newLine();

        // Build payload
        $this->line('🔧 Building Midtrans Payload:');
        $this->line('─────────────────────────────────────────');

        $item_details = [];
        foreach ($order->orderItems as $item) {
            $item_details[] = [
                'id' => 'ITEM-' . $item->id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name' => substr(trim($item->title ?? 'Item'), 0, 50),
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => substr($order->name ?? 'Customer', 0, 50),
                'email' => $order->email,
            ],
        ];

        $this->line('Payload JSON:');
        $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->newLine();

        // Try to get snap token
        $this->line('🌐 Attempting to Get Snap Token:');
        $this->line('─────────────────────────────────────────');

        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$clientKey = config('midtrans.client_key');
            Config::$isProduction = config('midtrans.is_production');

            $snapToken = Snap::getSnapToken($payload);

            if ($snapToken) {
                $this->info('✅ Success! Snap Token generated:');
                $this->line('Token: ' . substr($snapToken, 0, 50) . '...');
                return 0;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->newLine();
            
            // Parse error
            if (strpos($e->getMessage(), '401') !== false) {
                $this->line('💡 This is an authentication error - check your keys');
            } elseif (strpos($e->getMessage(), 'invalid') !== false) {
                $this->line('💡 This is a validation error - check payload structure');
            } elseif (strpos($e->getMessage(), 'required') !== false) {
                $this->line('💡 Missing required field in payload');
            }

            return 1;
        }

        return 1;
    }
}
