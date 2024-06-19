<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AvailableCountry;

class AvailableCountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = AvailableCountry::create([
            'country_id' => '38',
            'image' => 'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/canada.png',
        ]);

        $country = AvailableCountry::create([
            'country_id' => '13',
            'image' => 'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/australia.png',
        ]);
    }
}
