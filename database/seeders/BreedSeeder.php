<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Breed;
use App\Models\Species;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $domba = Species::where('name', 'Domba')->first();
        Breed::create(['name' => 'Garut', 'species_id' => $domba->id]);
        Breed::create(['name' => 'Merino', 'species_id' => $domba->id]);
    }
}
