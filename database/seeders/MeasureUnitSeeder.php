<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasureUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $measureUnits = [
            'kg',
            'g',
            'l',
            'ml'
        ];

        foreach ($measureUnits as $measureUnit) {
            \DB::table('measure_units')->insert([
                'value' => $measureUnit,
            ]);
        }
    }
}
