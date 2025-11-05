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

           
            KavlingSeeder::class,
            PakanSeeder::class,
            BreedSeeder::class,
            SubKategoriSeeder::class, 
            KandangSeeder::class,
        ]);

      
        $this->call([
            TernakSeeder::class, 
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role'  => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::factory()->create([
            'name' => 'mitra',
            'email' => 'mitra@gmail.com',
            'role'  => 'mitra',
            'password' => Hash::make('mitra123'),
        ]);
    }
}