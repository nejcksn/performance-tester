<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::where('is_faker', 1)->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(10),
            'is_faker' => 1,
        ];
    }
}
