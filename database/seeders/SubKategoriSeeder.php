<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\SubKategori;

class SubKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { { // Gunakan firstOrCreate
            SubKategori::create(['name' => 'Cempe (0-1 Bulan)']);
            SubKategori::create(['name' => 'Cempe Prasapih(1-3 Bulan)']);
            SubKategori::create(['name' => 'Lepas Sapih (3-6 Bulan)']);
            SubKategori::create(['name' => 'Bakalan (6-12 Bulan)']);
            SubKategori::create(['name' => 'Dara (6-12 Bulan)']);
            SubKategori::create(['name' => 'Dewasa (>12 Bulan)']);
            SubKategori::create(['name' => 'Afkir']);
            SubKategori::create(['name' => 'Freemartin']);
            SubKategori::create(['name' => 'Pejantan']);
            SubKategori::create(['name' => 'Pertama']);
            SubKategori::create(['name' => 'Kedua']);
        }
    }
}
