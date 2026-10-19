<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Review;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {

        User::factory(10)->create();

        Book::factory(33)->create()->each(function ($book) {

                Review::factory()->count(random_int(5, 30))->goodrate()->for($book)->create();
                Review::factory()->count(random_int(5, 30))->badrate()->for($book)->create();
                Review::factory()->count(random_int(5, 30))->softrate()->for($book)->create();
        });

        

        Review::factory(10)->create();
/* 
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}
