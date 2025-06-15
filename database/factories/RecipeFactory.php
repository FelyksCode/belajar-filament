<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Grilled Chicken Breast',
            'Spaghetti Carbonara',
            'Chocolate Chip Cookies',
            'Caesar Salad',
            'Beef Stir Fry',
            'Tomato Soup',
            'Fish Tacos',
            'Mushroom Risotto',
            'Apple Pie',
            'Thai Green Curry',
            'BBQ Ribs',
            'Caprese Salad',
            'Chicken Noodle Soup',
            'Beef Burgers',
            'Pancakes'
        ]);

        $ingredients = [];
        for ($i = 0; $i < fake()->numberBetween(4, 8); $i++) {
            $ingredients[] = fake()->numberBetween(1, 3) . ' ' . fake()->randomElement([
                'cups flour',
                'tbsp olive oil',
                'lbs chicken breast',
                'cloves garlic',
                'cups milk',
                'eggs',
                'tsp salt',
                'tsp black pepper',
                'onions diced',
                'cups cheese grated',
                'tbsp butter',
                'cups vegetable broth'
            ]);
        }

        $instructions = [];
        for ($i = 0; $i < fake()->numberBetween(3, 6); $i++) {
            $instructions[] = fake()->sentence(12);
        }

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title . '-' . fake()->randomNumber(3)),
            'description' => fake()->paragraph(3),
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'prep_time' => fake()->numberBetween(10, 60),
            'cook_time' => fake()->numberBetween(15, 120),
            'servings' => fake()->numberBetween(2, 8),
            'difficulty' => fake()->randomElement(['easy', 'medium', 'hard']),
            'image' => '/storage/images/recipe-placeholder.jpg',
            'is_popular' => fake()->boolean(30), // 30% chance of being popular
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
