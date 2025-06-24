<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Footer;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Footer::count()==0){
            Footer::create([
                'section' => 'service',
                'label' => 'Online Service',
                'url' => 'http://localhost',
                'order' => 1,
            ]);
        } 
    }
}
