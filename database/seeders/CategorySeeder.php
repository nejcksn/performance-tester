<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = config('categories');
        foreach ($categories as $key => $value) {
            $category = Category::firstOrCreate(['name' => $value]);

            $category->generateSlug();
        }
    }
}
