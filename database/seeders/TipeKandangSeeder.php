<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipeKandang; // Pastikan ini diimpor dengan benar

class TipeKandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeKandang::firstOrCreate(
            ['name' => 'Fattening']
        );

        TipeKandang::firstOrCreate(
            ['name' => 'Breeding Domba']
        );

        TipeKandang::firstOrCreate(
            ['name' => 'Breeding Kambing']
        );
    }
}