<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Mengubah status subskripsi user (mitra).
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(User $user)
    {

        if ($user->role !== 'mitra') {
            return redirect()->back()->with('error', 'Hanya status mitra yang bisa diubah.');
        }

        $newStatus = $user->subscription_status === 'Active' ? 'Inactive' : 'Active';

        $user->update([
            'subscription_status' => $newStatus
        ]);

        return redirect()->back()->with('success', "Status mitra {$user->name} berhasil diubah menjadi {$newStatus}.");
    }


    public function addSubscriptionTime(Request $request, User $user)
    {
       
        $request->validate([
            'days' => 'required|integer|in:7,30',
        ]);

       
        if ($user->role !== 'mitra') {
            return redirect()->back()->with('error', 'Hanya mitra yang bisa ditambah waktunya.');
        }

        $daysToAdd = (int)  $request->input('days');

      
        $baseDate = ($user->subscription_expires_at && $user->subscription_expires_at > now())
            ? $user->subscription_expires_at
            : now();

        
        $newExpiryDate = $baseDate->addDays($daysToAdd);

      
        $user->update([
            'subscription_expires_at' => $newExpiryDate,
            'subscription_status' => 'Active' 
        ]);

        return redirect()->back()->with('success', "Berhasil menambahkan {$daysToAdd} hari untuk {$user->name}. Langganan aktif sampai {$newExpiryDate->format('d M Y')}.");
    }
}
