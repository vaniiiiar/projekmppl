<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageConfig;

class PageConfigSeeder extends Seeder
{
    public function run(): void
    {
        if(PageConfig::count() == 0) {
            PageConfig::create([
                'title' => 'Selamat datang di Okan Coffee Shop!',
                'detail' => 'Temukan cita rasa kopi terbaik dan aneka minuman segar lainnya. Nikmati momen santai di tempat kami yang cozy.',
                'image' => 'default-image.jpg',
            ]);
        }
    }
}