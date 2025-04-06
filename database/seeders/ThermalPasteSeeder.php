<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;

class ThermalPasteSeeder extends Seeder
{
    public function run()
    {
        $filename = 'thermal-paste';
        $categoryName = config('categories')[$filename] ?? null;

        if (!$categoryName) {
            $this->command->error("Категория для файла '{$filename}.json' не найдена в config('categories')");
            return;
        }

        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            $this->command->error("Категория '{$categoryName}' не найдена в базе данных");
            return;
        }

        $filePath = storage_path("app/json/{$filename}.json");

        if (!file_exists($filePath)) {
            $this->command->error("Файл '{$filename}.json' не найден по пути {$filePath}");
            return;
        }

        $products = json_decode(file_get_contents($filePath), true);

        if (!is_array($products)) {
            $this->command->error("Неверный формат JSON в '{$filename}.json'");
            return;
        }

        // 🔁 Перебор всех товаров в JSON
        foreach ($products as $item) {
            if (empty($item['name'])) {
                continue;
            }

            $brand = null;
            if (!empty($item['brand'])) {
                $brand = Brand::where('name', $item['brand'])->first();
            }

            $product = Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand?->id,
                    'price' => $item['price'] ?? rand(50, 500),
                ]
            );

            $product->generateSlug();

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

        $this->command->info("Загружено продуктов: " . count($products));
    }
}
