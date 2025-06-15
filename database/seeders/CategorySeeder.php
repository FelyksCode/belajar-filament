<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Meat Dishes',
                'slug' => 'meat-dishes',
                'description' => 'Delicious recipes featuring beef, pork, lamb, and other meats',
                'image' => 'https://via.placeholder.com/400x300?text=Meat+Dishes',
            ],
            [
                'name' => 'Vegetarian',
                'slug' => 'vegetarian',
                'description' => 'Plant-based recipes without any meat',
                'image' => 'https://via.placeholder.com/400x300?text=Vegetarian',
            ],
            [
                'name' => 'Seafood',
                'slug' => 'seafood',
                'description' => 'Fresh fish and seafood recipes',
                'image' => 'https://via.placeholder.com/400x300?text=Seafood',
            ],
            [
                'name' => 'Desserts',
                'slug' => 'desserts',
                'description' => 'Sweet treats and desserts for every occasion',
                'image' => 'https://via.placeholder.com/400x300?text=Desserts',
            ],
            [
                'name' => 'Asian',
                'slug' => 'asian',
                'description' => 'Traditional and modern Asian cuisine',
                'image' => 'https://via.placeholder.com/400x300?text=Asian',
            ],
            [
                'name' => 'Italian',
                'slug' => 'italian',
                'description' => 'Classic Italian dishes and flavors',
                'image' => 'https://via.placeholder.com/400x300?text=Italian',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
