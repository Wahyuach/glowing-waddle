<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisDomba;

class JenisDombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { { // Gunakan firstOrCreate
            JenisDomba::create(['name' => 'Domba Ekor Tipis']);
            JenisDomba::create(['name' => 'Domba Ekor Gemuk']);
            JenisDomba::create(['name' => 'Domba Dorper F1']);
            JenisDomba::create(['name' => 'Domba Dorper F2']);
            JenisDomba::create(['name' => 'Domba Garut']);
            JenisDomba::create(['name' => 'Domba Priangan']);
            JenisDomba::create(['name' => 'Silangan DEG-Dorper']);
            JenisDomba::create(['name' => 'Silangan DEG-Garut']);
            JenisDomba::create(['name' => 'Kambing Jawa Randu']);
        }
    }
}
