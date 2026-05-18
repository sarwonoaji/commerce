<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MidtransValidateKeysCommand extends Command
{
    protected $signature = 'midtrans:validate-keys {--regenerate}';
    protected $description = 'Validate Midtrans Server Key and Client Key format';

    public function handle()
    {
        $this->line('🔐 MIDTRANS KEY VALIDATION\n');

        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        $merchantId = config('midtrans.merchant_id');
        $isProduction = config('midtrans.is_production');

        // Display current config
        $this->line('Current Configuration:');
        $this->line('─────────────────────────────────────────');
        $this->displayKey('Server Key', $serverKey);
        $this->displayKey('Client Key', $clientKey);
        $this->line('Merchant ID: ' . ($merchantId ? substr($merchantId, 0, 4) . '...' : '❌ NOT SET'));
        $this->line('Environment: ' . ($isProduction ? '🌐 PRODUCTION' : '🏠 SANDBOX'));
        $this->newLine();

        // Validate format
        $this->line('Validating Key Format:');
        $this->line('─────────────────────────────────────────');

        $serverKeyValid = $this->validateServerKeyFormat($serverKey);
        $clientKeyValid = $this->validateClientKeyFormat($clientKey);

        if (!$serverKeyValid || !$clientKeyValid) {
            $this->error('❌ Key format is INVALID!');
            $this->newLine();
            $this->line('Expected format:');
            $this->line('  Server Key: Mid-server-xxxxxxx');
            $this->line('  Client Key: Mid-client-xxxxxxx');
            $this->newLine();
            $this->displayInstructions();
            return 1;
        }

        $this->info('✅ Key format is valid');
        $this->newLine();

        // Test with real API call
        $this->line('Testing API Connection:');
        $this->line('─────────────────────────────────────────');

        $this->testApiConnection($serverKey, $isProduction);

        $this->newLine();
        return 0;
    }

    private function displayKey($label, $key)
    {
        if (!$key) {
            $this->error("$label: ❌ NOT SET");
            return;
        }

        if (strlen($key) > 30) {
            $display = substr($key, 0, 15) . '...' . substr($key, -10);
        } else {
            $display = $key;
        }

        $this->line("$label: $display");
    }

    private function validateServerKeyFormat($key)
    {
        if (!$key) return false;
        if (strpos($key, 'Mid-server-') !== 0) return false;
        if (strlen($key) < 20) return false;
        return true;
    }

    private function validateClientKeyFormat($key)
    {
        if (!$key) return false;
        if (strpos($key, 'Mid-client-') !== 0) return false;
        if (strlen($key) < 20) return false;
        return true;
    }

    private function testApiConnection($serverKey, $isProduction)
    {
        try {
            $baseUrl = $isProduction 
                ? 'https://api.midtrans.com'
                : 'https://app.sandbox.midtrans.com';

            $client = new Client([
                'timeout' => 10,
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000,
                ],
                'item_details' => [
                    [
                        'id' => 'TEST',
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

            $response = $client->post("$baseUrl/snap/v1/transactions", [
                'auth' => [$serverKey, ''],
                'json' => $payload,
            ]);

            if ($response->getStatusCode() === 201) {
                $this->info('✅ API Connection Successful!');
                $body = json_decode($response->getBody());
                $this->line('Snap Token Generated Successfully');
                return true;
            }

        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response && $response->getStatusCode() === 401) {
                $this->error('❌ API Error 401 - UNAUTHORIZED');
                $this->newLine();
                $this->error('This means your Server Key is INVALID or INCORRECT!');
                $this->newLine();
                $this->line('Possible causes:');
                $this->line('1. Server Key was copied incorrectly');
                $this->line('2. Server Key has been revoked');
                $this->line('3. Server Key is from different merchant');
                $this->line('4. Environment mismatch (Sandbox vs Production)');
                $this->newLine();
                $this->displayInstructions();
                return false;
            } elseif ($e->getCode() === 0 && strpos($e->getMessage(), 'Could not resolve host') !== false) {
                $this->error('❌ Network Error - Cannot resolve host');
                $this->line('Please check your internet connection');
                return false;
            } else {
                $this->error('❌ API Error: ' . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    private function displayInstructions()
    {
        $this->line('📚 SOLUTION:');
        $this->line('═════════════════════════════════════════');
        $this->line('1. Go to: https://dashboard.midtrans.com');
        $this->line('2. Login with your account');
        $this->line('3. Select Environment: SANDBOX or PRODUCTION');
        $this->line('   (match with MIDTRANS_IS_PRODUCTION setting)');
        $this->line('4. Go to: Settings → Access Keys');
        $this->line('5. Copy Server Key EXACTLY (no spaces!)');
        $this->line('6. Copy Client Key EXACTLY (no spaces!)');
        $this->line('7. Update .env file:');
        $this->line('   MIDTRANS_SERVER_KEY=Mid-server-xxxxxxx');
        $this->line('   MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxx');
        $this->line('   MIDTRANS_MERCHANT_ID=M417490285');
        $this->line('8. Clear cache: php artisan config:cache');
        $this->line('9. Run again: php artisan midtrans:validate-keys');
        $this->line('═════════════════════════════════════════');
    }
}
