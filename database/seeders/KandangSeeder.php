<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandang;
use App\Models\TipeKandang;
use App\Models\Kavling;

class KandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada Kavling dan TipeKandang terlebih dahulu
        $kavling = Kavling::first();
        $tipeKandang = TipeKandang::first();

        if (!$kavling || !$tipeKandang) {
            $this->command->info('Data referensi (Kavling atau TipeKandang) tidak lengkap. Seeder Kandang dilewati.');
            return;
        }

        Kandang::firstOrCreate(
            ['kandang_id' => 'KDG-A01-A'], // Sediakan ID unik di sini
            [
                'kavling_id' => $kavling->no_kavling,
                'tipe_kandang_id' => $tipeKandang->id,
                'kapasitas' => 5,
                // 'current_population' tidak perlu di-seed karena dihitung via accessor
                'notes' => 'Kandang A di Kavling A01.', // Menambahkan notes
            ]
        );
        Kandang::firstOrCreate(
            ['kandang_id' => 'KDG-A01-B'], // Sediakan ID unik di sini
            [
                'kavling_id' => $kavling->no_kavling,
                'tipe_kandang_id' => $tipeKandang->id,
                'kapasitas' => 5,
                'notes' => 'Kandang B di Kavling A01.',
            ]
        );
        Kandang::firstOrCreate(
            ['kandang_id' => 'KDG-A01-C'], // Sediakan ID unik di sini
            [
                'kavling_id' => $kavling->no_kavling,
                'tipe_kandang_id' => $tipeKandang->id,
                'kapasitas' => 5,
                'notes' => 'Kandang C di Kavling A01.',
            ]
        );

        $this->command->info('Seeder Kandang berhasil dijalankan.');
    }
}
