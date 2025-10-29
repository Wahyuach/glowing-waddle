<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pakan;
use App\Models\TipePakan;
class PakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipeFattening = TipePakan::where('name', 'Pakan Fattening')->first();
        Pakan::create([
            'name' => 'Pakan Fattening Super',
            'tipe_pakan_id' => $tipeFattening->id,
            'stock' => 500.00,
            'price_per_unit' => 8000,
        ]);
    }
}
