<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Main categories with images
        $mainCategories = [
            [
                'id' => Str::uuid(),
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Devices and gadgets',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing and accessories',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Furniture and appliances',
            ],
        ];

        // Insert main categories
        foreach ($mainCategories as $cat) {
            Category::create([
                'id' => $cat['id'],
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'description' => $cat['description'],
                'parent_id' => null,
                'status' => true,
            ]);
        }

        // Child categories with parent_slug to resolve parent_id
        $childCategories = [
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile-phones',
                'parent_slug' => 'electronics',
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'parent_slug' => 'electronics',
            ],
            [
                'name' => 'Men',
                'slug' => 'men-fashion',
                'parent_slug' => 'fashion',
            ],
            [
                'name' => 'Women',
                'slug' => 'women-fashion',
                'parent_slug' => 'fashion',
            ],
        ];

        foreach ($childCategories as $child) {
            $parent = Category::where('slug', $child['parent_slug'])->first();

            if ($parent) {
                Category::create([
                    'id' => Str::uuid(),
                    'name' => $child['name'],
                    'slug' => $child['slug'],
                    'description' => null,
                    'parent_id' => $parent->id,
                    'status' => true,
                ]);
            }
        }
    }
}
