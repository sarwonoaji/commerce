<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransDiagnoseCommand extends Command
{
    protected $signature = 'midtrans:diagnose';
    protected $description = 'Diagnose Midtrans configuration issues';

    public function handle()
    {
        $this->line('🔍 MIDTRANS DIAGNOSTIC TOOL\n');

        // 1. Check .env configuration
        $this->line('📋 Step 1: Checking Configuration from .env');
        $this->line('─────────────────────────────────────────');
        
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        $merchantId = config('midtrans.merchant_id');
        $isProduction = config('midtrans.is_production');

        $this->displayConfig('Server Key', $serverKey);
        $this->displayConfig('Client Key', $clientKey);
        $this->line('Merchant ID: ' . ($merchantId ?: '❌ NOT SET'));
        $this->line('Environment: ' . ($isProduction ? '🌐 PRODUCTION' : '🏠 SANDBOX'));
        $this->newLine();

        // 2. Validate key format
        $this->line('🔐 Step 2: Validating Key Format');
        $this->line('─────────────────────────────────────────');

        $serverKeyValid = $this->validateServerKey($serverKey);
        $clientKeyValid = $this->validateClientKey($clientKey);
        
        if ($serverKeyValid && $clientKeyValid) {
            $this->info('✅ Both keys have valid format');
        } else {
            $this->error('❌ Key format validation failed');
            if (!$serverKeyValid) $this->error('   - Server Key format invalid');
            if (!$clientKeyValid) $this->error('   - Client Key format invalid');
        }
        $this->newLine();

        // 3. Check for whitespace
        $this->line('🧹 Step 3: Checking for Whitespace');
        $this->line('─────────────────────────────────────────');

        $serverKeyTrimmed = trim($serverKey);
        $clientKeyTrimmed = trim($clientKey);

        if ($serverKey === $serverKeyTrimmed) {
            $this->line('✅ Server Key: No whitespace');
        } else {
            $this->error('❌ Server Key: Has leading/trailing whitespace!');
        }

        if ($clientKey === $clientKeyTrimmed) {
            $this->line('✅ Client Key: No whitespace');
        } else {
            $this->error('❌ Client Key: Has leading/trailing whitespace!');
        }
        $this->newLine();

        // 4. Test API Connection
        $this->line('🌐 Step 4: Testing API Connection');
        $this->line('─────────────────────────────────────────');

        if (!$serverKey || !$clientKey || !$merchantId) {
            $this->error('❌ Cannot test API - Missing required configuration');
            $this->newLine();
            goto skip_api_test;
        }

        try {
            // Set config
            Config::$serverKey = $serverKey;
            Config::$clientKey = $clientKey;
            Config::$isProduction = $isProduction;

            $this->line('Attempting to create Snap Token...');

            // Create minimal test transaction
            $payload = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000,
                ],
                'item_details' => [
                    [
                        'id' => 'TEST-ITEM',
                        'price' => 10000,
                        'quantity' => 1,
                        'name' => 'Test Item',
                    ],
                ],
                'customer_details' => [
                    'first_name' => 'Test',
                    'email' => 'test@example.com',
                ],
            ];

            $response = Snap::getSnapToken($payload);

            if ($response) {
                $this->info('✅ API Connection Successful!');
                $this->line('Generated Snap Token: ' . substr($response, 0, 30) . '...');
            } else {
                $this->error('❌ Failed to generate token');
            }

        } catch (\Throwable $e) {
            $this->error('❌ API Connection Failed');
            $this->error('Error: ' . $e->getMessage());

            // Parse error for better diagnostics
            $this->parseApiError($e->getMessage());
        }

        skip_api_test:
        $this->newLine();

        // 5. Recommendations
        $this->line('💡 Recommendations');
        $this->line('─────────────────────────────────────────');

        $issues = [];

        if (empty($serverKey)) $issues[] = 'Set MIDTRANS_SERVER_KEY in .env';
        if (empty($clientKey)) $issues[] = 'Set MIDTRANS_CLIENT_KEY in .env';
        if (empty($merchantId)) $issues[] = 'Set MIDTRANS_MERCHANT_ID in .env';

        if (!$serverKeyValid || $serverKey !== $serverKeyTrimmed) {
            $issues[] = 'Verify Server Key format and whitespace';
        }

        if (!$clientKeyValid || $clientKey !== $clientKeyTrimmed) {
            $issues[] = 'Verify Client Key format and whitespace';
        }

        if (empty($issues)) {
            $this->info('✅ All configurations look correct!');
            $this->info('If still getting 401, try regenerating keys from Midtrans Dashboard');
        } else {
            foreach ($issues as $issue) {
                $this->line('• ' . $issue);
            }
        }

        $this->newLine();
        $this->line('📚 Next Steps:');
        $this->line('1. Fix any issues listed above');
        $this->line('2. Run: php artisan config:cache');
        $this->line('3. Run: php artisan cache:clear');
        $this->line('4. Refresh browser and test payment');
        $this->newLine();
    }

    private function displayConfig($label, $value)
    {
        if (!$value) {
            $this->error($label . ': ❌ NOT SET');
            return;
        }

        $displayed = substr($value, 0, 10) . '...' . substr($value, -10);
        $this->line($label . ': ' . $displayed . ' ✅');
    }

    private function validateServerKey($key)
    {
        return $key && strpos($key, 'Mid-server-') === 0;
    }

    private function validateClientKey($key)
    {
        return $key && strpos($key, 'Mid-client-') === 0;
    }

    private function parseApiError($message)
    {
        if (strpos($message, '401') !== false) {
            $this->error('\n🔴 Error 401 - Unauthorized');
            $this->line('Possible causes:');
            $this->line('1. Server/Client key is incorrect');
            $this->line('2. Keys from Sandbox but MIDTRANS_IS_PRODUCTION=true');
            $this->line('3. Keys from Production but MIDTRANS_IS_PRODUCTION=false');
            $this->line('4. Keys have expired or been revoked');
            $this->line('\n✅ Solutions:');
            $this->line('1. Go to https://dashboard.midtrans.com');
            $this->line('2. Check Settings → Access Keys');
            $this->line('3. Make sure you\'re viewing the correct environment');
            $this->line('4. Copy keys exactly without spaces');
            $this->line('5. Update .env and run: php artisan config:cache');
        }
    }
}
