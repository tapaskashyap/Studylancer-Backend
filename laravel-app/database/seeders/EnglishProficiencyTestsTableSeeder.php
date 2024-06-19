<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EnglishProficiencyTest;

class EnglishProficiencyTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EnglishProficiencyTest::create(['name'=>'IELTS General']);
        EnglishProficiencyTest::create(['name'=>'IELTS Academic']);
        EnglishProficiencyTest::create(['name'=>'TOEFL']);
        EnglishProficiencyTest::create(['name'=>'PTE']);
    }
}
