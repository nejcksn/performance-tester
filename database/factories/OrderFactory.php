<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'total_price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Выбираем случайные продукты
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();

            $total = 0;
            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $order->products()->attach($product->id, ['quantity' => $quantity]);
                $total += $product->price * $quantity;
            }

            // Обновляем общую сумму заказа
            $order->update(['total_price' => $total]);
        });
    }
}
