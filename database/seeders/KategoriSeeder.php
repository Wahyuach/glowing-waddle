<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create(['name' => 'Breeding Domba']);
        Kategori::create(['name' => 'Breeding Kambing']);
        Kategori::create(['name' => 'Fattening']);
    }
}
