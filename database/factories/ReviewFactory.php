<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'review' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 6),
            'book_id' => Book::factory(),
        ];
    }

    public function badrate(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
        ]);
    }

    public function goodrate(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(5, 6),
        ]);
    }

    public function softrate(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(3, 4),
        ]);
    }
}