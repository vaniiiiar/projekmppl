<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada minimal 3 kategori
        $defaultCategories = ['Minuman', 'Makanan', 'Snack'];
        foreach ($defaultCategories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );
        }

        $categories = Category::all();

        $menuNames = [
            'Espresso', 'Latte', 'Cappuccino', 'Americano', 'Mocha',
            'Macchiato', 'Flat White', 'Green Tea Latte', 'Thai Tea', 'Lemon Tea',
            'Chocolate Milk', 'Mineral Water', 'Chicken Burger', 'Beef Sandwich', 'French Fries',
            'Cheese Fries', 'Pasta Carbonara', 'Spaghetti Bolognese', 'Grilled Chicken', 'Caesar Salad',
            'Fish & Chips', 'Chicken Wings', 'Muffin', 'Croissant', 'Donut',
            'Chocolate Cake', 'Cheesecake', 'Tiramisu', 'Waffle', 'Pancake',
            'Fruit Salad', 'Iced Matcha', 'Iced Coffee', 'Hot Chocolate', 'Affogato',
            'Ice Cream Sundae', 'Toast Bread', 'Garlic Bread', 'Nachos', 'Onion Rings',
            'Milkshake', 'Strawberry Smoothie', 'Blueberry Pie', 'Avocado Juice', 'Orange Juice',
            'Kopi Susu Gula Aren', 'Roti Bakar Coklat', 'Kopi Tubruk', 'Kopi Hitam', 'Teh Tarik'
        ];

        

        foreach ($menuNames as $name) {
            $category = $categories->random();

            Product::create([
                'category_id'   => $category->id,
                'name'          => $name,
                'description'   => 'Deskripsi menu ' . $name . ', enak dan cocok untuk semua kalangan.',
                'price'         => rand(15000, 50000),
                'is_available'  => rand(0, 1),
                'image'         => 'front/images/dummy.jpg', // pastikan file dummy.jpg tersedia
            ]);
        }
    }
}
