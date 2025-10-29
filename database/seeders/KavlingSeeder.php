<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kavling;
use App\Models\Investor;
use App\Models\Abk;


class KavlingSeeder extends Seeder
{
    public function run(): void
    {
        $investor = Investor::first();
        $abk = Abk::first();

        Kavling::firstOrCreate(
            ['no_kavling' => 'A-01'],
            [
                'kapasitas' => 30,
                'status_kepemilikan' => 'Dimiliki',
                'investor_id' => $investor->id,
                'abk_id'=> $abk->id,
            ]
        );
    }
}
