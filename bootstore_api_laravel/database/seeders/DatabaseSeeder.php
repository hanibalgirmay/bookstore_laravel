<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\UserPoint;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $user =User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Book::factory(30)->create();
        UserPoint::factory(1)->create(['user_id' => $user->id, 'points' => 100]);
    }
}
