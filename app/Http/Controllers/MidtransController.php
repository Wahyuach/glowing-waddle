<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    // Display payment page
    public function showPaymentPage()
    {
        return view('payment');  // You can create a 'payment.blade.php' view
    }

    // Handle payment initiation
    public function initiatePayment(Request $request)
    {
        // Example data (replace with dynamic order data)
        $order_id = 'ORDER-' . time();
        $amount = 100000;  // Amount in IDR
        $customer_details = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        // Create a transaction and get the snap token
        $snap_token = $this->midtrans->createTransaction($order_id, $amount, $customer_details);

        // Return the token to the frontend for payment
        return view('payment', compact('snap_token')); // Pass the snap token to the view
    }
}
