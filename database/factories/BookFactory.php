<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $total = $this->faker->numberBetween(1,10);
        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
            'description' => $this->faker->paragraph(),
            'total_copies' => $total,
            'available_copies' => $total,
            'published_at' => $this->faker->date(),
        ];
    }
}
