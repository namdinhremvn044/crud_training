<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
        $quantity = fake()->numberBetween(20, 100);
        $borrowed = fake()->numberBetween(0, $quantity);

        return [
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->sentence(
                fake()->numberBetween(2, 5)
            ),

            'author_id' => Author::inRandomOrder()->first()->id,

            'price' => fake()->numberBetween(50000, 600000),

            'quantity' => $quantity,

            'borrowed_quantity' => $borrowed,

            'available_quantity' => $quantity - $borrowed,

            'publish_date' => fake()->dateTimeBetween(
                '-5 years',
                'now'
            ),

            'description' => fake()->paragraph(),

            'cover_image' => null,

            'status' => fake()->randomElement([
                'available',
                'unavailable'
            ]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($book) {
            $categoryIds = Category::query()
                ->inRandomOrder()
                ->value('id');

            $book->categories()->sync(
                $categoryIds
            );
        });
    }

}
