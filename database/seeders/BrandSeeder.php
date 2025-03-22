<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{

    public function run(): void
    {
        $brands = config('brands');

        foreach ($brands as $key => $value) {
            $brand = Brand::firstOrCreate([
                'name' => $value['name']
            ], [
                'description' => $value['description'],
                'country' => $value['country'],
                'founded_year' => $value['founded_year'],
            ]);

            $brand->generateSlug();
        }
    }
}
