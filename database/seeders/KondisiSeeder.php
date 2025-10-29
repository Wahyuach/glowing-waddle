<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kondisi;

class KondisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kondisi::create(['name' => 'Hamil']);
        Kondisi::create(['name' => 'Mati']);
        Kondisi::create(['name' => 'Menyusui']);
        Kondisi::create(['name' => 'Sehat']);
    }
}
