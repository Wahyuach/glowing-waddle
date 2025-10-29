<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Di Kandang']);
        Status::create(['name' => 'Disembelih']);
        Status::create(['name' => 'Mati']);
        Status::create(['name' => 'Terjual']);
        Status::create(['name' => 'Terjual Smartqurban']);
    }
}
