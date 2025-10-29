<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kejadian;

class KejadianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { { // Gunakan firstOrCreate
            Kejadian::create(['name' => 'Mati']);
            Kejadian::create(['name' => 'Melahirkan']);
            Kejadian::create(['name' => 'Sakit']);
            Kejadian::create(['name' => 'Disembelih']);
            Kejadian::create(['name' => 'Pindah Kandang']);
            Kejadian::create(['name' => 'Ganti Tag']);
            Kejadian::create(['name' => 'Vaksin']);
            Kejadian::create(['name' => 'Birahi']);
            Kejadian::create(['name' => 'Domba Masuk']);
            Kejadian::create(['name' => 'Rekam IB']);
            Kejadian::create(['name' => 'Hamil']);
            Kejadian::create(['name' => 'Lepas Sapih']);
            Kejadian::create(['name' => 'Terjual']);
            Kejadian::create(['name' => 'Timbang 30 Hari']);
            Kejadian::create(['name' => 'Timbang 60 Hari']);
            Kejadian::create(['name' => 'Timbang 90 Hari']);
            Kejadian::create(['name' => 'Timbang 100 Hari']);
            Kejadian::create(['name' => 'Timbang 180 Hari']);
            Kejadian::create(['name' => 'Timbang 360 Hari']);
        }
    }
}
