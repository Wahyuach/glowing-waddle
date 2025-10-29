<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Abk;

class AbkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Abk::create([
            'name' => 'Ahmad Subarjo',
            'phone_number' => '089876543210',
            'address'=> 'Jalan Kenangan no 11',
        ]);
    }
}
