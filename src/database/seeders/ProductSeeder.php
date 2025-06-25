<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Product::count() == 0) {
            // Buat kategori default
            $categories = [
                ['name' => 'Minuman', 'slug' => 'minuman'],
                ['name' => 'Makanan', 'slug' => 'makanan'],
                ['name' => 'Snack', 'slug' => 'snack']
            ];
            
            foreach ($categories as $category) {
                Category::firstOrCreate(
                    ['name' => $category['name']],
                    ['slug' => $category['slug']]
                );
            }

            $categoryIds = Category::pluck('id');

            $products = [
                // Minuman
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Ice Matcha Latte',
                    'description' => 'Matcha premium dari Jepang dengan susu segar',
                    'price' => 28000,
                    'is_available' => true,
                    'image' => 'front/assets/matcha.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Americano',
                    'description' => 'Kopi hitam klasik dengan rasa kuat',
                    'price' => 20000,
                    'is_available' => true,
                    'image' => 'front/assets/americano.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Caramel Macchiato',
                    'description' => 'Espresso dengan susu steamed dan caramel',
                    'price' => 32000,
                    'is_available' => true,
                    'image' => 'front/assets/caramel-macchiato.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Thai Tea',
                    'description' => 'Teh Thailand original dengan susu kental',
                    'price' => 25000,
                    'is_available' => true,
                    'image' => 'front/assets/thai-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Chocolate Hazelnut',
                    'description' => 'Coklat dengan rasa hazelnut yang kaya',
                    'price' => 28000,
                    'is_available' => true,
                    'image' => 'front/assets/choco-hazelnut.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Vanilla Milkshake',
                    'description' => 'Milkshake vanila dengan topping whipped cream',
                    'price' => 27000,
                    'is_available' => true,
                    'image' => 'front/assets/vanilla-milkshake.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Strawberry Mojito',
                    'description' => 'Minuman segar stroberi dengan mint dan soda',
                    'price' => 25000,
                    'is_available' => true,
                    'image' => 'front/assets/strawberry-mojito.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Dalgona Coffee',
                    'description' => 'Kopi kocok Korea dengan susu dingin',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/dalgona.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Matcha Strawberry',
                    'description' => 'Perpaduan matcha dan stroberi segar',
                    'price' => 32000,
                    'is_available' => true,
                    'image' => 'front/assets/matcha-strawberry.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Mojito Ocean Blue',
                    'description' => 'Mojito dengan blue curacao yang menyegarkan',
                    'price' => 28000,
                    'is_available' => true,
                    'image' => 'front/assets/blue-mojito.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Lemon Tea',
                    'description' => 'Teh dengan perasan lemon segar',
                    'price' => 18000,
                    'is_available' => true,
                    'image' => 'front/assets/lemon-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Lychee Tea',
                    'description' => 'Teh dengan buah lychee asli',
                    'price' => 22000,
                    'is_available' => true,
                    'image' => 'front/assets/lychee-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Hot Tea',
                    'description' => 'Teh panas pilihan',
                    'price' => 15000,
                    'is_available' => true,
                    'image' => 'front/assets/hot-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Ice Tea',
                    'description' => 'Es teh segar',
                    'price' => 12000,
                    'is_available' => true,
                    'image' => 'front/assets/ice-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Strawberry Tea',
                    'description' => 'Teh rasa stroberi',
                    'price' => 20000,
                    'is_available' => true,
                    'image' => 'front/assets/strawberry-tea.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Milkshake Mango',
                    'description' => 'Milkshake mangga dengan buah asli',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/mango-milkshake.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Milkshake Red Velvet',
                    'description' => 'Milkshake rasa red velvet lembut',
                    'price' => 32000,
                    'is_available' => true,
                    'image' => 'front/assets/redvelvet-milkshake.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Milkshake Blueberry',
                    'description' => 'Milkshake blueberry dengan buah asli',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/blueberry-milkshake.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Milkshake Taro',
                    'description' => 'Milkshake rasa taro ungu yang unik',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/taro-milkshake.jpg'
                ],
                [
                    'category_id' => $categoryIds[0],
                    'name' => 'Milkshake Caramel',
                    'description' => 'Milkshake dengan saus caramel homemade',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/caramel-milkshake.jpg'
                ],

                // Makanan
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Chicken Wings BBQ',
                    'description' => 'Sayap ayam dengan saus BBQ spesial',
                    'price' => 45000,
                    'is_available' => true,
                    'image' => 'front/assets/wings-bbq.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Beef Burger',
                    'description' => 'Burger dengan patty daging sapi 150gr',
                    'price' => 38000,
                    'is_available' => true,
                    'image' => 'front/assets/beef-burger.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Chicken Katsu Curry',
                    'description' => 'Ayam katsu dengan saus kari Jepang',
                    'price' => 42000,
                    'is_available' => true,
                    'image' => 'front/assets/chicken-curry.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Spaghetti Carbonara',
                    'description' => 'Pasta dengan saus carbonara creamy',
                    'price' => 40000,
                    'is_available' => true,
                    'image' => 'front/assets/carbonara.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Truffle Fries',
                    'description' => 'Kentang goreng dengan truffle oil',
                    'price' => 35000,
                    'is_available' => true,
                    'image' => 'front/assets/truffle-fries.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Salmon Teriyaki',
                    'description' => 'Salmon fillet dengan saus teriyaki',
                    'price' => 55000,
                    'is_available' => true,
                    'image' => 'front/assets/salmon-teriyaki.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Chicken Parmesan',
                    'description' => 'Ayam crispy dengan saus marinara dan keju',
                    'price' => 45000,
                    'is_available' => true,
                    'image' => 'front/assets/chicken-parm.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Beef Steak',
                    'description' => 'Daging sapi premium dengan mashed potato',
                    'price' => 65000,
                    'is_available' => true,
                    'image' => 'front/assets/beef-steak.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Fish and Chips',
                    'description' => 'Ikan goreng tepung dengan kentang',
                    'price' => 40000,
                    'is_available' => true,
                    'image' => 'front/assets/fish-chips.jpg'
                ],
                [
                    'category_id' => $categoryIds[1],
                    'name' => 'Chicken Caesar Salad',
                    'description' => 'Salad dengan ayam, crouton dan dressing caesar',
                    'price' => 38000,
                    'is_available' => true,
                    'image' => 'front/assets/caesar-salad.jpg'
                ],

                // Snack
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'French Fries',
                    'description' => 'Kentang goreng krispi',
                    'price' => 25000,
                    'is_available' => true,
                    'image' => 'front/assets/french-fries.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Onion Rings',
                    'description' => 'Bawang bombay goreng tepung',
                    'price' => 22000,
                    'is_available' => true,
                    'image' => 'front/assets/onion-rings.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Mozzarella Sticks',
                    'description' => 'Stick keju mozzarella goreng',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/mozzarella-sticks.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Chicken Popcorn',
                    'description' => 'Potongan ayam goreng crispy',
                    'price' => 28000,
                    'is_available' => true,
                    'image' => 'front/assets/chicken-popcorn.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Nachos Cheese',
                    'description' => 'Nachos dengan saus keju leleh',
                    'price' => 32000,
                    'is_available' => true,
                    'image' => 'front/assets/nachos.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Garlic Bread',
                    'description' => 'Roti panggang dengan bawang putih',
                    'price' => 20000,
                    'is_available' => true,
                    'image' => 'front/assets/garlic-bread.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Choco Banana Toast',
                    'description' => 'Roti panggang dengan pisang dan coklat',
                    'price' => 25000,
                    'is_available' => true,
                    'image' => 'front/assets/choco-banana.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Cireng Isi Pedas',
                    'description' => 'Cireng isi sambal oncom khas Bandung',
                    'price' => 18000,
                    'is_available' => true,
                    'image' => 'front/assets/cireng.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Dimsum Set',
                    'description' => '5 pcs dimsum ayam dengan saus',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/dimsum.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Croissant',
                    'description' => 'Croissant original dengan selai',
                    'price' => 22000,
                    'is_available' => true,
                    'image' => 'front/assets/croissant.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Churros',
                    'description' => 'Churros renyah dengan saus coklat',
                    'price' => 25000,
                    'is_available' => true,
                    'image' => 'front/assets/churros.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Pancake Stack',
                    'description' => '3 lapis pancake dengan maple syrup',
                    'price' => 28000,
                    'is_available' => true,
                    'image' => 'front/assets/pancake.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Waffle',
                    'description' => 'Waffle crispy dengan topping buah',
                    'price' => 30000,
                    'is_available' => true,
                    'image' => 'front/assets/waffle.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Brownies',
                    'description' => 'Brownies coklat kukus lembut',
                    'price' => 20000,
                    'is_available' => true,
                    'image' => 'front/assets/brownies.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Cheesecake Slice',
                    'description' => 'Potongan cheesecake New York style',
                    'price' => 35000,
                    'is_available' => true,
                    'image' => 'front/assets/cheesecake.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Tiramisu',
                    'description' => 'Tiramisu klasik Italia',
                    'price' => 35000,
                    'is_available' => true,
                    'image' => 'front/assets/tiramisu.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Macarons Box',
                    'description' => '6 pcs macaron berbagai rasa',
                    'price' => 45000,
                    'is_available' => true,
                    'image' => 'front/assets/macarons.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Donut',
                    'description' => 'Donut lembut dengan berbagai topping',
                    'price' => 18000,
                    'is_available' => true,
                    'image' => 'front/assets/donut.jpg'
                ],
                [
                    'category_id' => $categoryIds[2],
                    'name' => 'Cupcake',
                    'description' => 'Cupcake dengan buttercream',
                    'price' => 20000,
                    'is_available' => true,
                    'image' => 'front/assets/cupcake.jpg'
                ]
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }
    }
}