<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => Post::where('is_faker', 1)->inRandomOrder()->first()?->id ?? Post::factory()->create()->id,
            'user_id' => User::where('is_faker', 1)->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'content' => $this->faker->paragraph(),
            'is_faker' => 1,
        ];
    }
}
