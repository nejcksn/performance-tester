<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Database\Seeder;

class CategoryFieldSeeder extends Seeder
{
    public function run()
    {
        $gpuCategory = Category::where('name', 'GPU')->first();

        if ($gpuCategory) {
            $fields = [
                ['category_id' => $gpuCategory->id, 'name' => 'chipset', 'label' => 'Chipset', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'memory', 'label' => 'Memory (GB)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'core_clock', 'label' => 'Core Clock (MHz)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'boost_clock', 'label' => 'Boost Clock (MHz)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'length', 'label' => 'Length (mm)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'interface', 'label' => 'Interface', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'tdp', 'label' => 'TDP (W)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'recommended_psu', 'label' => 'Recommended PSU (W)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'power_connectors', 'label' => 'Power Connectors', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'slot_width', 'label' => 'Slot Width', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'vram_type', 'label' => 'VRAM Type', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'bus_width', 'label' => 'Bus Width (bit)', 'type' => 'number'],
                ['category_id' => $gpuCategory->id, 'name' => 'directx_support', 'label' => 'DirectX Support', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'opengl_support', 'label' => 'OpenGL Support', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'ray_tracing_support', 'label' => 'Ray Tracing Support', 'type' => 'checkbox'],
                ['category_id' => $gpuCategory->id, 'name' => 'cooling_type', 'label' => 'Cooling Type', 'type' => 'text'],
                ['category_id' => $gpuCategory->id, 'name' => 'ports', 'label' => 'Ports', 'type' => 'textarea'],
                ['category_id' => $gpuCategory->id, 'name' => 'sli_crossfire_support', 'label' => 'SLI/Crossfire Support', 'type' => 'checkbox'],
            ];

            foreach ($fields as $field) {
                CategoryField::create($field);
            }
        }
    }
}
