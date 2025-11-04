<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        // Respect environment flag to choose production or sandbox
        $isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
        // Log the selected mode for easier debugging
        \Illuminate\Support\Facades\Log::info('Midtrans mode', ['is_production' => $isProduction]);
    }

    public function createTransaction($order_id, $amount, $customer_details)
    {
        try {
            // Ensure configuration is loaded
            if (empty(Config::$serverKey)) {
                throw new \Exception('Midtrans Server Key is not configured');
            }

            // Prepare transaction details with required fields
            $transaction_details = [
                'order_id' => $order_id,
                'gross_amount' => (int) $amount, // Ensure amount is integer
            ];

            // Format customer details with validation
            $customer_details = [
                'first_name' => $customer_details['first_name'] ?? 'Guest',
                'last_name' => $customer_details['last_name'] ?? '',
                'email' => $customer_details['email'] ?? '',
                'phone' => $customer_details['phone'] ?? '',
            ];

            // Create complete transaction parameters
            $params = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'enable_payments' => ['credit_card', 'bca_va', 'bni_va', 'bri_va'],
                'credit_card' => [
                    'secure' => true,
                    'channel' => 'migs',
                ],
            ];

            // Request Midtrans to create the transaction
            $snap_token = Snap::getSnapToken($params);

            if (empty($snap_token)) {
                throw new \Exception('Failed to generate Snap Token');
            }

            return $snap_token;
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            throw $e;
        }
    }

    // You can also add methods for other operations like capturing payment, refund, etc.
}
