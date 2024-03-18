<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relationships = [
            'sunny',
            'cloudy',
            'rainy',
            'stormy'
        ];

        foreach ($relationships as $value) {
            \App\Models\Relationship::create([
                'value' => $value
            ]);
        }
    }
}
