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
        // 1. Cek dulu, jangan sampai si user ini 'admin' baru (yang lagi login)
        // Kita cuma mau ganti status 'mitra'
        if ($user->role !== 'mitra') {
            return redirect()->back()->with('error', 'Hanya status mitra yang bisa diubah.');
        }

        // 2. Balik statusnya: 'Active' jadi 'Inactive', 'Inactive' jadi 'Active'
        $newStatus = $user->subscription_status === 'Active' ? 'Inactive' : 'Active';

        // 3. Update statusnya di database
        $user->update([
            'subscription_status' => $newStatus
        ]);

        // 4. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', "Status mitra {$user->name} berhasil diubah menjadi {$newStatus}.");
    }
}