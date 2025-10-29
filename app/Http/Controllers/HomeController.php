<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ternak; // Import model Ternak
use App\Models\Kavling; // Import model Kavling
use App\Models\Kandang; // Import model Kandang
use App\Models\Pakan; // Import model Pakan
use App\Models\Investor; // Import model Investor
use App\Models\Abk; // Import model Abk
// use Illuminate\Support\Facades\DB; // Tidak perlu lagi jika tidak ada raw queries untuk grafik

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil jumlah data dari setiap model untuk small boxes
        $totalTernak = Ternak::count();
        $totalKavling = Kavling::count();
        $totalKandang = Kandang::count();
        $totalPakan = Pakan::count();
        $totalInvestor = Investor::count();
        $totalAbk = Abk::count();

        return view('home', compact(
            'totalTernak',
            'totalKavling',
            'totalKandang',
            'totalPakan',
            'totalInvestor',
            'totalAbk'
        ));
    }
}
