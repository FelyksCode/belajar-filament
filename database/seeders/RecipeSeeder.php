<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            // Create 8-12 recipes per category
            Recipe::factory()
                ->count(fake()->numberBetween(8, 12))
                ->create(['category_id' => $category->id]);
        }

        // Ensure we have some popular recipes
        Recipe::inRandomOrder()
            ->limit(15)
            ->update(['is_popular' => true]);
    }
}
