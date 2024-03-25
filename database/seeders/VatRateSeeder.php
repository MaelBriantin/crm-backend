<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vatRates = [
            0,
            5.5,
            10,
            20
        ];

        foreach ($vatRates as $vatRate) {
            \DB::table('vat_rates')->insert([
                'value' => $vatRate,
            ]);
        }
    }
}
