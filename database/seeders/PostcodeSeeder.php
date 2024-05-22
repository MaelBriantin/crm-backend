<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\Postcode;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = Sector::factory()->count(25)->create();

        foreach ($sectors as $sector) {
            Postcode::factory()->sameSector($sector->id)->count(25)->create();
        } 
    }
}
