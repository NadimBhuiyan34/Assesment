<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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
       
       

        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality noise cancelling wireless headphones.',
                'price' => 2500,
                'discount_price' => 1000,
                'stock' => 100,
                'is_featured' => true,
                'specifications' => ['color' => 'black', 'connectivity' => 'Bluetooth'],
                'tags' => ['electronics', 'audio', 'wireless'],
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with heart rate monitor.',
                'price' => 3000,
                'discount_price' => 100,
                'stock' => 50,
                'specifications' => ['color' => 'silver', 'waterproof' => 'yes'],
                'tags' => ['wearable', 'tech', 'fitness'],
            ],
            [
                'name' => 'Gaming Mouse',
                'description' => 'RGB gaming mouse with adjustable DPI.',
                'price' => 1200,
                'discount_price' => 50,
                'stock' => 200,
                'specifications' => ['dpi' => '12000', 'buttons' => '7'],
                'tags' => ['gaming', 'accessories'],
            ],
            [
                'name' => 'T-shirt - Cotton',
                'description' => 'Soft cotton T-shirt for daily wear.',
                'price' => 500,
                'stock' => 200,
                'specifications' => ['size' => 'L', 'material' => 'cotton'],
                'tags' => ['clothing', 'tshirt', 'cotton'],
            ],
            [
                'name' => 'Leather Wallet',
                'description' => 'Premium quality leather wallet for men.',
                'price' => 850,
                'discount_price' => 100,
                'stock' => 70,
                'is_featured' => true,
                'specifications' => ['material' => 'leather', 'color' => 'brown'],
                'tags' => ['accessories', 'wallet'],
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable Bluetooth speaker with deep bass.',
                'price' => 1800,
                'stock' => 120,
                'specifications' => ['battery' => '10h', 'waterproof' => 'IPX6'],
                'tags' => ['audio', 'bluetooth', 'speaker'],
            ],
            [
                'name' => 'Laptop Backpack',
                'description' => 'Water-resistant backpack fits 15-inch laptop.',
                'price' => 2200,
                'discount_price' => 99,
                'stock' => 40,
                'specifications' => ['size' => '15-inch', 'material' => 'polyester'],
                'tags' => ['bags', 'laptop'],
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Breathable and lightweight running shoes.',
                'price' => 3000,
                'stock' => 80,
                'specifications' => ['size' => '42', 'color' => 'blue'],
                'tags' => ['shoes', 'running'],
            ],
            [
                'name' => 'Digital Camera',
                'description' => 'Compact digital camera with 20MP lens.',
                'price' => 8500,
                'discount_price' => 99,
                'stock' => 30,
                'is_featured' => true,
                'specifications' => ['megapixels' => '20', 'zoom' => '10x'],
                'tags' => ['camera', 'photography'],
            ],
            [
                'name' => 'Electric Kettle',
                'description' => '1.5L stainless steel electric kettle.',
                'price' => 1600,
                'stock' => 100,
                'specifications' => ['capacity' => '1.5L', 'power' => '1500W'],
                'tags' => ['kitchen', 'appliances'],
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'id' => Str::uuid(),
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'description' => $p['description'] ?? null,
                'price' => $p['price'],
                'discount_price' => $p['discount_price'] ?? null,
                'stock' => $p['stock'],
                'is_featured' => $p['is_featured'] ?? false,
                'is_active' => true,
                'weight' => rand(1, 3),
                'length' => rand(10, 40),
                'width' => rand(5, 20),
                'height' => rand(5, 20),
                'tags' => $p['tags'],
                'specifications' => $p['specifications'],
                'status' => true,
            ]);
        }
    }
}
