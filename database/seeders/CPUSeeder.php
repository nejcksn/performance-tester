<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;

class CPUSeeder extends Seeder
{
    public function run()
    {
        // Название файла и соответствие категории
        $filename = 'cpu';
        $categoryName = config('categories')[$filename] ?? null;

        if (!$categoryName) {
            $this->command->error("Категория для файла '{$filename}.json' не найдена в config('categories')");
            return;
        }

        // Получаем категорию
        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            $this->command->error("Категория '{$categoryName}' не найдена в базе данных");
            return;
        }

        // Путь к файлу
        $filePath = storage_path("app/json/{$filename}.json");

        if (!file_exists($filePath)) {
            $this->command->error("Файл '{$filename}.json' не найден по пути {$filePath}");
            return;
        }

        // Загружаем продукты
        $products = json_decode(file_get_contents($filePath), true);

        if (!is_array($products)) {
            $this->command->error("Неверный формат JSON в '{$filename}.json'");
            return;
        }

        // Пример: берём только первый продукт (без foreach)
        $item = $products[0] ?? null;

        if (!$item || empty($item['name'])) {
            $this->command->error("Нет данных о продукте или отсутствует имя");
            return;
        }

        // Получаем бренд, если есть
        $brand = null;
        if (!empty($item['brand'])) {
            $brand = Brand::where('name', $item['brand'])->first();
        }

        // Создание/обновление продукта
        $product = Product::updateOrCreate(
            ['name' => $item['name']],
            [
                'category_id' => $category->id,
                'brand_id' => $brand?->id,
                'price' => $item['price'] ?? rand(50, 500),
            ]
        );

        // Генерация slug
        $product->generateSlug();

        // Добавление характеристик
        collect($item)
            ->except(['id', 'name', 'price', 'brand'])
            ->filter()
            ->each(function ($value, $key) use ($product) {
                ProductSpec::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'spec_key' => $key
                    ],
                    [
                        'spec_value' => json_encode($value),
                    ]
                );
            });
    }
}
