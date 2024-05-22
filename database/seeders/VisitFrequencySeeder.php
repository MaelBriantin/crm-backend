<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visitFrequencies = [
            'monthly',
            'bi_monthly',
            'quarterly',
            'biannually',
            'annually'
        ];

        foreach ($visitFrequencies as $value) {
            \App\Models\VisitFrequency::create([
                'value' => $value
            ]);
        }
    }
}
