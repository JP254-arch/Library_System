<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // General Fiction & Literature
            'Fiction',
            'Non-Fiction',
            'Mystery & Thriller',
            'Science Fiction',
            'Fantasy',
            'Romance',
            'Historical Fiction',
            'Horror',
            'Classics',
            'Young Adult',

            // Educational & Academic
            'Science & Technology',
            'Mathematics',
            'History',
            'Geography',
            'Literature & Language',
            'Psychology',
            'Philosophy',
            'Economics',
            'Business & Management',
            'Medicine & Health',

            // Professional & Reference
            'Law & Legal Studies',
            'Engineering & Technology',
            'Computer Science',
            'Self-Help & Personal Development',
            'Biography & Memoirs',
            'Art & Design',
            'Cooking & Food',
            'Travel & Adventure',
            'Religion & Spirituality',

            // Special Interest
            'Poetry',
            'Comics / Graphic Novels',
            'Children\'s Books',
            'Adventure & Exploration',
            'Environmental Studies',
            'True Crime',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
