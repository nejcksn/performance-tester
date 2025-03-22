<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class
        ]);

        User::factory(20)->create();
        Post::factory(30)->create();
        Comment::factory(50)->create();
        Order::factory(50)->create();
    }

}
