<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipePakan; // Pastikan ini diimpor

class TipePakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan firstOrCreate untuk mencegah duplikasi
        TipePakan::firstOrCreate(
            ['name' => 'Pakan Fattening']
        );

        TipePakan::firstOrCreate(
            ['name' => 'Pakan Breeding']
        );

        TipePakan::firstOrCreate(
            ['name' => 'Pakan Hamil + Nyusu']
        );

        // Anda bisa menambahkan data lain di sini dengan pola yang sama
        // TipePakan::firstOrCreate(['name' => 'Pakan Anak Domba']);
    }
}