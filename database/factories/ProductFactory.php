<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition() 
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 5, 200),
        ];
    }
}
