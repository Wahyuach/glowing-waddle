<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipeDomba;

class TipeDombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { { // Gunakan firstOrCreate
            TipeDomba::create(['name' => 'Lokal']);
            TipeDomba::create(['name' => 'Cross Dorper']);
            TipeDomba::create(['name' => 'Cross Garut']);
            TipeDomba::create(['name' => 'Dorper']);
            TipeDomba::create(['name' => 'Priangan']);
        }
    }
}
