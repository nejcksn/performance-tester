<?php

namespace Database\Factories;

use App\Models\TestResult;
use App\Models\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestResult>
 */
class TestResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TestResult::class;

    public function definition()
    {
        return [
            'test_case_id' => TestCase::inRandomOrder()->first()->id ?? TestCase::factory()->create()->id,
            'execution_time' => $this->faker->randomFloat(6, 0.001, 10), // Время от 1 мс до 10 секунд
            'record_count' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
