<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Meat Dishes',
            'Vegetarian',
            'Vegan',
            'Seafood',
            'Desserts',
            'Appetizers',
            'Soups',
            'Salads',
            'Pasta',
            'Asian',
            'Italian',
            'Mexican',
            'Breakfast',
            'Snacks',
            'Beverages'
        ]);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->sentence(10),
            'image' => 'https://via.placeholder.com/400x300?text=' . urlencode($name),
        ];
    }
}
