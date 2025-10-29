<?php

namespace Database\Seeders;

use App\Models\Kavling;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Panggil seeder yang tidak memiliki ketergantungan terlebih dahulu
            // Urutan ini sangat penting untuk mencegah error foreign key
            InvestorSeeder::class,
            AbkSeeder::class,
            TipePakanSeeder::class,
            TipeKandangSeeder::class,
            SpeciesSeeder::class,
            KondisiSeeder::class,
            StatusSeeder::class,
            KategoriSeeder::class,
            TipeDombaSeeder::class,
            JenisDombaSeeder::class,

            // Panggil seeder yang memiliki ketergantungan
            KavlingSeeder::class, // Tergantung pada InvestorSeeder dan AbkSeeder
            PakanSeeder::class, // Tergantung pada TipePakanSeeder
            BreedSeeder::class, // Tergantung pada SpeciesSeeder (jika ada)
            SubKategoriSeeder::class, // Tergantung pada KategoriSeeder
            KandangSeeder::class, // Tergantung pada KavlingSeeder dan TipeKandangSeeder
        ]);

        // Panggil seeder yang paling banyak ketergantungannya di akhir
        $this->call([
            TernakSeeder::class, // Tergantung pada banyak seeder di atas
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}