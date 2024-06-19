<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\StudentDetails;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Animesh Kuzur',
            'email' => 'animesh.amank21@gmail.com',
            'phone' => '8447310212',
            'country_id' => 95,
            'avatar'=>'https://api.dicebear.com/7.x/initials/svg?seed=Animesh',
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'approved_at' => Carbon::now()->toDateTimeString(),
        ]);
        $user->assignRole('student');

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'studylancer.noreply@gmail.com',
            'phone' => '9876543210',
            'country_id' => 95,
            'password' => bcrypt('password'),
            'avatar'=>'https://api.dicebear.com/7.x/initials/svg?seed=Super Admin',
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'approved_at' => Carbon::now()->toDateTimeString(),
        ]);
        $user->assignRole('super-admin');
    }
}
