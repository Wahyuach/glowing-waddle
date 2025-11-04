<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index()
    {
        // Data user manual
        $user = (object)[
            'name' => 'Nama Pengguna',
            'email' => 'user@example.com',
            'subscription' => (object)[
                'is_active' => true,
                'expired_at' => now()->addDays(30)  // masa aktif 30 hari ke depan
            ]
        ];

        return view('profile.index', compact('user'));
    }
}