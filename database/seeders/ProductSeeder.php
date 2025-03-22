<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categoriesMap = config('categories');

        $jsonPath = storage_path('app/json/');
        $files = glob($jsonPath . '*.json');

        foreach ($files as $file) {
            $filename = basename($file, '.json');

            if (!isset($categoriesMap[$filename])) {
                continue;
            }

            $category = Category::where('name', $categoriesMap[$filename])->first();
            if (!$category) {
                continue;
            }

            $products = json_decode(file_get_contents($file), true);
            foreach ($products as $item) {

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

                foreach ($item as $key => $value) {
                    if (!in_array($key, ['id', 'name', 'price', 'brand']) && !empty($value)) {
                        $value = json_encode($value);
                        ProductSpec::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'spec_key' => $key
                            ],
                            [
                                'spec_value' => $value,
                            ]
                        );
                    }
                }
            }
        }
    }
}
