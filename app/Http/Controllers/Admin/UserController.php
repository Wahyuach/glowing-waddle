<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}