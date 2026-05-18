<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Config;

class MidtransTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midtrans:test';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Test Midtrans API configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing Midtrans Configuration...\n');

        // Load config
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        $merchantId = config('midtrans.merchant_id');
        $isProduction = config('midtrans.is_production');

        // Check if keys exist
        $this->line('📋 Configuration Status:');
        $this->line('  Server Key: ' . ($serverKey ? '✅ Set' : '❌ Not Set'));
        $this->line('  Client Key: ' . ($clientKey ? '✅ Set' : '❌ Not Set'));
        $this->line('  Merchant ID: ' . ($merchantId ? '✅ Set' : '❌ Not Set'));
        $this->line('  Environment: ' . ($isProduction ? '🌐 Production' : '🏠 Sandbox'));
        $this->newLine();

        // Validate keys format
        $this->line('🔐 Key Validation:');
        if ($serverKey && strpos($serverKey, 'Mid-server-') !== 0) {
            $this->error('  ❌ Server Key format invalid (should start with "Mid-server-")');
        } else {
            $this->line('  ✅ Server Key format valid');
        }

        if ($clientKey && strpos($clientKey, 'Mid-client-') !== 0) {
            $this->error('  ❌ Client Key format invalid (should start with "Mid-client-")');
        } else {
            $this->line('  ✅ Client Key format valid');
        }
        $this->newLine();

        // Check for missing config
        $this->line('✔️ Required Configuration Check:');
        $missing = [];
        if (!$serverKey) $missing[] = 'MIDTRANS_SERVER_KEY';
        if (!$clientKey) $missing[] = 'MIDTRANS_CLIENT_KEY';
        if (!$merchantId) $missing[] = 'MIDTRANS_MERCHANT_ID';

        if (empty($missing)) {
            $this->line('  ✅ All required keys are set!');
        } else {
            $this->error('  ❌ Missing configuration:');
            foreach ($missing as $key) {
                $this->error('     - ' . $key . ' (add to .env file)');
            }
        }
        $this->newLine();

        // Try API connection
        if ($serverKey && $clientKey) {
            $this->line('🌐 Testing API Connection...');
            
            try {
                Config::$serverKey = $serverKey;
                Config::$clientKey = $clientKey;
                Config::$isProduction = $isProduction;

                // Create test transaction
                $transactionDetails = [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000,
                ];

                $itemDetails = [
                    [
                        'id' => 'ITEM-001',
                        'price' => 10000,
                        'quantity' => 1,
                        'name' => 'Test Item',
                    ],
                ];

                $customerDetails = [
                    'first_name' => 'Test',
                    'email' => 'test@example.com',
                ];

                $payload = [
                    'transaction_details' => $transactionDetails,
                    'item_details' => $itemDetails,
                    'customer_details' => $customerDetails,
                ];

                $response = \Midtrans\Snap::getSnapToken($payload);

                if ($response) {
                    $this->info('  ✅ API Connection Successful!');
                    $this->line('  Snap Token generated: ' . substr($response, 0, 20) . '...');
                } else {
                    $this->error('  ❌ Failed to generate Snap Token');
                }
            } catch (\Exception $e) {
                $this->error('  ❌ API Connection Failed:');
                $this->error('     Error: ' . $e->getMessage());
                
                // Additional hints
                if (strpos($e->getMessage(), '401') !== false) {
                    $this->line('\n💡 Error 401 usually means:');
                    $this->line('   1. Server/Client key is incorrect');
                    $this->line('   2. Environment (Sandbox/Production) mismatch');
                    $this->line('   3. Merchant ID is not set');
                    $this->line('\n👉 Solution:');
                    $this->line('   - Verify keys from Midtrans Dashboard');
                    $this->line('   - Ensure MIDTRANS_IS_PRODUCTION matches your key');
                    $this->line('   - Set MIDTRANS_MERCHANT_ID in .env');
                }
            }
        } else {
            $this->warning('⚠️  Cannot test API - Server/Client key not configured');
        }

        $this->newLine();
        $this->info('✨ Test Complete!');
        $this->line('📚 For more help, see: MIDTRANS_SETUP.md');
    }
}
