<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;
class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
        $notification = $request->all();

        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash('sha512', $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . $serverKey);

        if ($signatureKey != $notification['signature_key']) {
            Log::warning('Midtrans Webhook: Signature tidak valid.', ['order_id' => $notification['order_id']]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        Log::info('Midtrans Webhook: Notifikasi diterima.', $notification);

        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = $notification['fraud_status'];

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {

            if (strpos($orderId, 'SUB-') === 0) {
                
                $parts = explode('-', $orderId);
                $userId = end($parts);
                
                $user = User::find($userId);

               
                if ($user) {
                    $daysToAdd = 30;
                    
                    $baseDate = ($user->subscription_expires_at && $user->subscription_expires_at > now())
                                    ? $user->subscription_expires_at
                                    : now();
                    
                    $newExpiryDate = $baseDate->addDays($daysToAdd);

                    $user->update([
                        'subscription_expires_at' => $newExpiryDate,
                        'subscription_status' => 'Active'
                    ]);

                    Log::info("Midtrans Webhook: SUKSES. Langganan user {$userId} diperpanjang 30 hari.");
                
                } else {
                    Log::error("Midtrans Webhook: GAGAL. User ID {$userId} dari Order ID {$orderId} tidak ditemukan.");
                }
            }
        }
        
        return response()->json(['status' => 'ok']);
    }
}
