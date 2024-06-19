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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    
        $this->call(CountriesTableSeeder::class);
        $this->call(DocumentTypesTableSeeder::class);
        $this->call(TermsAndConditionsTableSeeder::class);
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(ProfileStatusesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TimeSlotsTableSeeder::class);
        $this->call(AvailableCountriesTableSeeder::class);
        $this->call(HomeBannersTableSeeder::class);
        $this->call(EnglishProficiencyTestsTableSeeder::class);
        $this->call(WeekdaysTableSeeder::class);
    }
}
