<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfileStatus;

class ProfileStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = ProfileStatus::create([
            'status' => 'none',
        ]);
        $status = ProfileStatus::create([
            'status' => 'select.countries',
        ]);
        $status = ProfileStatus::create([
            'status' => 'basic.info',
        ]);
        $status = ProfileStatus::create([
            'status' => 'basic.documents',
        ]);
        $status = ProfileStatus::create([
            'status' => 'selfie.verification',
        ]);
        $status = ProfileStatus::create([
            'status' => 'profile.complete',
        ]);
    }
}
