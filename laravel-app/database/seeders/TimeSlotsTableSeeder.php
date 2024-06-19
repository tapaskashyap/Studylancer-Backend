<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\TimeSlot;

class TimeSlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeslot = TimeSlot::create([
            'slot_name' => 'Morning',
            'start' => '07:00:00',
            'end' => '12:00:00',
        ]);
        $timeslot = TimeSlot::create([
            'slot_name' => 'Afternoon',
            'start' => '12:00:00',
            'end' => '17:00:00',
        ]);
        $timeslot = TimeSlot::create([
            'slot_name' => 'Evening',
            'start' => '17:00:00',
            'end' => '21:00:00',
        ]);
        $timeslot = TimeSlot::create([
            'slot_name' => 'Night',
            'start' => '21:00:00',
            'end' => '01:00:00',
        ]);
    }
}
