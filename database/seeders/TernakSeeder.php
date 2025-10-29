<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ternak;
use App\Models\Kandang;

class TernakSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kandang pertama yang ada sebagai contoh
        $kandang = Kandang::first();

        // Pastikan kandang ada sebelum melanjutkan
        if ($kandang) {
            Ternak::firstOrCreate(
                ['tag_number' => 'D-2025-0001'],
                [
                    'tag_lama' => 123, // Domba
                    'species_id' => 1, // Domba
                    'kategori_id' => 2, // Penggemukan
                    'sub_kategori_id' => null, // Tidak ada sub-kategori spesifik
                    'tipe_domba_id' => 1, // Ditambahkan
                    'jenis_domba_id' => 1, // Ditambahkan
                    'gender' => 'Jantan',
                    'date_of_birth' => '2024-01-15',
                    'date_of_entry' => '2025-06-01',
                    'usia_masuk_dalam_bulan' => 6,
                    'entry_weight' => 30.5,
                    'current_weight' => 80.0,
                    'kondisi_id' => 1, // Sehat
                    'status_id' => 1, // Dikandang
                    'kandang_id' => $kandang->kandang_id, // Tambahkan ini
                ]
            );

            Ternak::firstOrCreate(
                ['tag_number' => 'K-2025-0002'],
                [
                    'tag_lama' => 234, // Domba
                    'species_id' => 2, // Kambing
                    'kategori_id' => 1, // Breeding
                    'sub_kategori_id' => 2, // Indukan Produktif
                    'tipe_domba_id' => 2, // Ditambahkan
                    'jenis_domba_id' => 2, // Ditambahkan
                    'gender' => 'Betina',
                    'date_of_birth' => '2023-03-20',
                    'date_of_entry' => '2024-02-01',
                    'usia_masuk_dalam_bulan' => 5,
                    'entry_weight' => 28.0,
                    'current_weight' => 65.5,
                    'kondisi_id' => 1, // Sehat
                    'status_id' => 1, // Dikandang
                    'kandang_id' => $kandang->kandang_id, // Tambahkan ini
                ]
            );
        } else {
            // Beri tahu pengguna jika tidak ada kandang yang bisa digunakan
            $this->command->info('Tidak ada kandang di database. Seeder Ternak dilewati.');
        }
    }
}
