<?php

namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Log::class;

    public function definition() 
    {
        return [
            'event' => $this->faker->word(),
            'message' => $this->faker->sentence(),
        ];
    }
}
