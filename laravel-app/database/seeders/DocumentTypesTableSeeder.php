<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentType::create(['type'=>'10th Marksheet']);
        DocumentType::create(['type'=>'12th Marksheet']);
        DocumentType::create(['type'=>'Passport']);
        DocumentType::create(['type'=>'Registration Certificate']);
        DocumentType::create(['type'=>'Government Approved ID']);
        DocumentType::create(['type'=>'Councellor Certificate']);
        DocumentType::create(['type'=>'Councellor Verification Selfie']);
        DocumentType::create(['type'=>'English Proficiency Test']);
        DocumentType::create(['type'=>'Others']);
    }
}