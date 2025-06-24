<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seo;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Seo::count()==0){
            Seo::create([
                'title' => 'Sepatu',
                'description' => 'Adidas',
                'keywords' => '',
                'cannonical_url' => 'http://localhost',
                'robots' => 'index, follow',
                'og_image' => '',
            ]);
        } 
    }
}
