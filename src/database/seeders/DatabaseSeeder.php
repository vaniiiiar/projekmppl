<?php

namespace Database\Seeders;

use App\Models\Orderitem;
use App\Models\PageConfig;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Exports\MonthlyIncomeExport;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create()
        
        $this->call([
            ProductSeeder::class,
            FooterSeeder::class,
            LogoSeeder::class,
            PageConfigSeeder::class,
            SeoSeeder::class,
            OrderItemSeeder::class,

        ]);
        $this->seedUsers();
    }

    private function seedUsers(): void
    {
        // Create Admin user if not exists
        $adminEmail = 'admin@admin.com';
        if (! User::where('email', $adminEmail)->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('super_admin');
        };
    }
}