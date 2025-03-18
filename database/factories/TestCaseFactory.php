<?php

namespace Database\Factories;

use App\Models\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestCase>
 */
class TestCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TestCase::class;

    public function definition() 
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
