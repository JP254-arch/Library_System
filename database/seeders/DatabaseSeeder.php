<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => '12345678',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'role' => 'member'
        ]);

        Author::factory(10)->create();
        Category::factory(8)->create();
        Book::factory(50)->create();
    }
}
