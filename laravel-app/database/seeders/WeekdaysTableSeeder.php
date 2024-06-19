<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Weekday;

class WeekdaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weekday = Weekday::create([
            'name' => 'Sunday',
            'code' => 'SUN',
        ]);
        $weekday = Weekday::create([
            'name' => 'Monday',
            'code' => 'MON',
        ]);
        $weekday = Weekday::create([
            'name' => 'Tuesday',
            'code' => 'TUE',
        ]);
        $weekday = Weekday::create([
            'name' => 'Wednesday',
            'code' => 'WED',
        ]);
        $weekday = Weekday::create([
            'name' => 'Thursday',
            'code' => 'THU',
        ]);
        $weekday = Weekday::create([
            'name' => 'Friday',
            'code' => 'FRI',
        ]);
        $weekday = Weekday::create([
            'name' => 'Saturday',
            'code' => 'SAT',
        ]);
    }
}
