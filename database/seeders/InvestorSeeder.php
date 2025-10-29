<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Investor;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Investor::create([
            'name' => 'Budi Santoso',
            'phone_number' => '081234567890',
            'address' => 'Jalan Kencana',
        ]);
    }
}
