<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomeBanner;

class HomeBannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeBanner::create([
            'name'=>'First Banner',
            'link'=>'https://google.com',
            'image'=>'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/banner1.png'
        ]);
        HomeBanner::create([
            'name'=>'Second Banner',
            'link'=>'https://github.com',
            'image'=>'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/banner1.png'
        ]);
        HomeBanner::create([
            'name'=>'Third Banner',
            'link'=>'https://facebook.com',
            'image'=>'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/banner1.png'
        ]);
        HomeBanner::create([
            'name'=>'Fourth Banner',
            'link'=>'https://duckduckgo.com',
            'image'=>'https://studylancer-bucket.blr1.cdn.digitaloceanspaces.com/system/banner1.png'
        ]);
    }
}
