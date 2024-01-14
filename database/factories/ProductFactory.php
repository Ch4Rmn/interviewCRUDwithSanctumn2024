<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => fake()->words(3, true), // Generates a random name with 3 words
            'description' => fake()->paragraph(), // Generates a random paragraph as description
            'price' => fake()->randomFloat(2, 10, 1000), // Generates a random price between 10 and 1000 with 2 decimal places
            'image' => fake()->imageUrl(), // Generates a random image URL
            'type' => fake()->randomElement(['normal', 'special']), // Generates either 'normal' or 'special'
            'user_id' => rand(1, 10)
        ];
    }
}
