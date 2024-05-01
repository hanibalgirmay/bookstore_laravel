<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'price' => rand(10, 100),
            'author' => $this->faker->name(),
            'cover_image' => 'https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._AC_SX184_.jpg',
            // 'tag' => $this->faker->randomElements(['fiction', 'non-fiction', 'science', 'essay']),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
