<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(30)->create();
        \App\Models\Comment::factory(50)->create();
        
        \App\Models\Category::factory(5)->create();
        \App\Models\Product::factory(20)->create();
        \App\Models\Order::factory(15)->create();

        \App\Models\Log::factory(10)->create();
        \App\Models\TestCase::factory(5)->create();
        \App\Models\TestResult::factory(10)->create();
    }
}
