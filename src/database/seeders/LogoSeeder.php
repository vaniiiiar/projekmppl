<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logo;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Logo::count() == 0) {
            Logo::create([
                'title' => 'Okan',
                'image' => 'front/images/logo.jpeg',
            ]);
        }
    }
}
