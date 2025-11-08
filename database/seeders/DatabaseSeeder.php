<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        // Create Test member user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'member',
        ]);

        // Create authors
        Author::factory(10)->create();

        // Seed categories via CategorySeeder
        $this->call(\Database\Seeders\CategorySeeder::class);

        // Create books
        Book::factory(50)->create();
    }
}
