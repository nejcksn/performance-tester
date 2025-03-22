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
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'total_price' => 0, // Начальное значение 0, пересчитаем позже
            'is_faker' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();

            $total = 0;
            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $product->price, // Добавляем цену в order_product
                ]);
                $total += $product->price * $quantity;
            }

            // Обновляем сумму заказа
            $order->update(['total_price' => $total]);
        });
    }

}
