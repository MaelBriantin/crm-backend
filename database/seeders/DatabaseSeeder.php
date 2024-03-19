<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'company_name' => 'TestUserCompany',
            'siret' => '0000000000',
            'siren' => '9999999999',
            'address' => 'Somewhere over the Rainbow',
            'postcode' => '99000',
            'city' => 'Saint-Paradise',
            'phone_number' => '06.06.66.66.60',
            'email' => 'test@example.com',
            'password' => bcrypt('azerty'),
        ]);

        $this->call(RelationshipSeeder::class);
        $this->call(VisitFrequencySeeder::class); 
        $this->call(SectorSeeder::class);
        $this->call(BrandSeeder::class);
    }
}
