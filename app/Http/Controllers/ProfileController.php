<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }
    public function index()
    {
        $user = Auth::user();

        // Fetch the subscription status
        $subscriptionStatus = $user->subscription_status ?? 'inactive'; // Default is 'inactive'
        
        // Get snap token from session if it exists
        $snap_token = session('snap_token', '');

        return view('profile.index', compact('user', 'subscriptionStatus', 'snap_token'));
    }

    
    public function subscribe(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user->isMitra()) {  
                return redirect()->route('profil.index')
                    ->with('error', 'You are not authorized to subscribe.');
            }

            // Generate a unique order ID with prefix for easy identification
            $order_id = 'SUB-' . date('Ymd-His') . '-' . $user->id;
            $amount = 1000; //harga langganan Rp 1.000,00

            // Prepare customer details
            $nameParts = explode(' ', $user->name, 2);
            $customer_details = [
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $user->email,
                'phone' => $user->phone ?? '', // Add phone field to users table if needed
            ];

            // Generate snap token using Midtrans service
            $snap_token = $this->midtrans->createTransaction($order_id, $amount, $customer_details);

            // Log token for debug (can be removed later)
            Log::info('Generated snap token for user ' . $user->id . ': ' . substr($snap_token, 0, 40));

            // Store transaction data in session
            session([
                'payment_data' => [
                    'order_id' => $order_id,
                    'amount' => $amount,
                    'snap_token' => $snap_token
                ]
            ]);

            // Return to profile page with success message
            return redirect()->route('profil.index')
                ->with('snap_token', $snap_token);

        } catch (\Exception $e) {
            Log::error('Subscription Error: ' . $e->getMessage());
            
            return redirect()->route('profil.index')
                ->with('error', 'Payment initialization failed. Please try again later.');
        }
    }



    public function update(Request $request)
    {
        $user = Auth::user(); 

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

       
        return redirect()->route('profil.index')->with('success', 'Profile updated successfully.');
    }


    public function resetPassword(Request $request)
    {
        $user = Auth::user(); 

 
        $validated = $request->validate([
            'current_password' => 'required|string',  
            'password' => 'required|string|confirmed|min:8',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profil.index')->with('success', 'Password updated successfully.');
    }


    /**
     * Handle client notification after Midtrans Snap payment success.
     * This endpoint is called from the browser (onSuccess) and will
     * mark the authenticated user's subscription as active.
     */
    public function paymentComplete(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Optionally validate order_id / transaction_id from request
        $orderId = $request->input('order_id') ?? session('payment_data.order_id');
        $transactionId = $request->input('transaction_id');

        // Basic sanity check: ensure we have an order id
        if (empty($orderId)) {
            return response()->json(['message' => 'Missing order_id'], 400);
        }

        // Update user's subscription status
        try {
            $user->subscription_status = 'active';
            $user->save();

            // clear session payment data
            session()->forget('payment_data');
            session()->forget('snap_token');

            return response()->json(['message' => 'Subscription activated', 'order_id' => $orderId]);
        } catch (\Exception $e) {
            Log::error('PaymentComplete Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update subscription'], 500);
        }
    }

}
