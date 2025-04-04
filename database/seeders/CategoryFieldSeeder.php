<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Database\Seeder;

class CategoryFieldSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'GPU' => [
                ['name' => 'chipset', 'label' => 'Chipset', 'type' => 'text'],
                ['name' => 'memory', 'label' => 'Memory (GB)', 'type' => 'number'],
                ['name' => 'core_clock', 'label' => 'Core Clock (MHz)', 'type' => 'number'],
                ['name' => 'boost_clock', 'label' => 'Boost Clock (MHz)', 'type' => 'number'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['name' => 'length', 'label' => 'Length (mm)', 'type' => 'number'],
                ['name' => 'interface', 'label' => 'Interface', 'type' => 'text'],
                ['name' => 'tdp', 'label' => 'TDP (W)', 'type' => 'number'],
                ['name' => 'recommended_psu', 'label' => 'Recommended PSU (W)', 'type' => 'number'],
                ['name' => 'power_connectors', 'label' => 'Power Connectors', 'type' => 'text'],
                ['name' => 'slot_width', 'label' => 'Slot Width', 'type' => 'text'],
                ['name' => 'vram_type', 'label' => 'VRAM Type', 'type' => 'text'],
                ['name' => 'bus_width', 'label' => 'Bus Width (bit)', 'type' => 'number'],
                ['name' => 'directx_support', 'label' => 'DirectX Support', 'type' => 'text'],
                ['name' => 'opengl_support', 'label' => 'OpenGL Support', 'type' => 'text'],
                ['name' => 'ray_tracing_support', 'label' => 'Ray Tracing Support', 'type' => 'checkbox'],
                ['name' => 'cooling_type', 'label' => 'Cooling Type', 'type' => 'text'],
                ['name' => 'ports', 'label' => 'Ports', 'type' => 'textarea'],
                ['name' => 'sli_crossfire_support', 'label' => 'SLI/Crossfire Support', 'type' => 'checkbox'],
            ],
            'Case' => [
                ['name' => 'type', 'label' => 'Type', 'type' => 'text'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['name' => 'psu', 'label' => 'PSU', 'type' => 'text'],
                ['name' => 'side_panel', 'label' => 'Side Panel', 'type' => 'text'],
                ['name' => 'external_volume', 'label' => 'External Volume (L)', 'type' => 'number'],
                ['name' => 'internal_35_bays', 'label' => 'Internal 3.5 Bays', 'type' => 'number'],
                ['name' => 'supported_motherboards', 'label' => 'Supported Motherboards', 'type' => 'text'],
                ['name' => 'psu_type', 'label' => 'PSU Type', 'type' => 'text'],
                ['name' => 'psu_max_length', 'label' => 'PSU Max Length (mm)', 'type' => 'number'],
                ['name' => 'gpu_max_length', 'label' => 'GPU Max Length (mm)', 'type' => 'number'],
                ['name' => 'cpu_cooler_max_height', 'label' => 'CPU Cooler Max Height (mm)', 'type' => 'number'],
                ['name' => 'radiator_support', 'label' => 'Radiator Support', 'type' => 'text'],
                ['name' => 'gpu_vertical_mount', 'label' => 'GPU Vertical Mount', 'type' => 'checkbox'],
                ['name' => 'storage_support_3_5', 'label' => 'Storage Support 3.5" Bays', 'type' => 'number'],
                ['name' => 'storage_support_2_5', 'label' => 'Storage Support 2.5" Bays', 'type' => 'number'],
            ],
            'Case Fans' => [
                ['name' => 'size', 'label' => 'Size (mm)', 'type' => 'number'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['name' => 'pwm', 'label' => 'PWM', 'type' => 'checkbox'],
                ['name' => 'airflow_cfm', 'label' => 'Airflow (CFM)', 'type' => 'number'],
                ['name' => 'noise_level_dB', 'label' => 'Noise Level (dB)', 'type' => 'number'],
                ['name' => 'thickness', 'label' => 'Thickness (mm)', 'type' => 'number'],
                ['name' => 'connector_type', 'label' => 'Connector Type', 'type' => 'text'],
                ['name' => 'rgb', 'label' => 'RGB', 'type' => 'checkbox'],
                ['name' => 'bearing_type', 'label' => 'Bearing Type', 'type' => 'text'],
                ['name' => 'static_pressure_mmH2O', 'label' => 'Static Pressure (mmH2O)', 'type' => 'number'],
                ['name' => 'fan_positions', 'label' => 'Fan Positions', 'type' => 'text'],
            ],
            'CPU' => [
                ['name' => 'core_count', 'label' => 'Core Count', 'type' => 'number'],
                ['name' => 'core_clock', 'label' => 'Core Clock (GHz)', 'type' => 'number'],
                ['name' => 'boost_clock', 'label' => 'Boost Clock (GHz)', 'type' => 'number'],
                ['name' => 'tdp', 'label' => 'TDP (W)', 'type' => 'number'],
                ['name' => 'graphics', 'label' => 'Graphics', 'type' => 'text'],
                ['name' => 'smt', 'label' => 'SMT', 'type' => 'checkbox'],
                ['name' => 'socket', 'label' => 'Socket', 'type' => 'text'],
                ['name' => 'lithography', 'label' => 'Lithography (nm)', 'type' => 'number'],
                ['name' => 'l3_cache', 'label' => 'L3 Cache (MB)', 'type' => 'number'],
                ['name' => 'max_memory', 'label' => 'Max Memory (GB)', 'type' => 'number'],
                ['name' => 'memory_types', 'label' => 'Memory Types', 'type' => 'text'],
                ['name' => 'memory_channels', 'label' => 'Memory Channels', 'type' => 'number'],
                ['name' => 'pcie_lanes', 'label' => 'PCIe Lanes', 'type' => 'number'],
                ['name' => 'cooler_included', 'label' => 'Cooler Included', 'type' => 'checkbox'],
            ],
            'CPU Coolers' => [
                ['name' => 'cooling_type', 'label' => 'Cooling Type', 'type' => 'text'],
                ['name' => 'socket_compatibility', 'label' => 'Socket Compatibility', 'type' => 'text'],
                ['name' => 'fan_connector', 'label' => 'Fan Connector', 'type' => 'text'],
                ['name' => 'tdp_supported', 'label' => 'TDP Supported (W)', 'type' => 'number'],
                ['name' => 'rgb', 'label' => 'RGB', 'type' => 'checkbox'],
                ['name' => 'rpm', 'label' => 'RPM', 'type' => 'number'],
                ['name' => 'noise_level_dB', 'label' => 'Noise Level (dB)', 'type' => 'number'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
            ],
            'Storage (HDD/SSD)' => [
                ['name' => 'capacity', 'label' => 'Capacity (GB)', 'type' => 'number'],
                ['name' => 'price_per_gb', 'label' => 'Price per GB ($)', 'type' => 'number'],
                ['name' => 'type', 'label' => 'Type', 'type' => 'text'],
                ['name' => 'form_factor', 'label' => 'Form Factor', 'type' => 'text'],
                ['name' => 'interface', 'label' => 'Interface', 'type' => 'text'],
                ['name' => 'nvme', 'label' => 'NVMe', 'type' => 'checkbox'],
                ['name' => 'power_consumption', 'label' => 'Power Consumption (W)', 'type' => 'number'],
                ['name' => 'tbw', 'label' => 'TBW (TB)', 'type' => 'number'],
                ['name' => 'cache', 'label' => 'Cache (MB)', 'type' => 'number'],
                ['name' => 'sequential_read', 'label' => 'Sequential Read (MB/s)', 'type' => 'number'],
                ['name' => 'sequential_write', 'label' => 'Sequential Write (MB/s)', 'type' => 'number'],
            ],
            'Memory (RAM)' => [
                ['name' => 'speed', 'label' => 'Speed (MHz)', 'type' => 'number'],
                ['name' => 'type', 'label' => 'Type', 'type' => 'text'],
                ['name' => 'voltage', 'label' => 'Voltage (V)', 'type' => 'number'],
                ['name' => 'ecc', 'label' => 'ECC', 'type' => 'checkbox'],
                ['name' => 'registered', 'label' => 'Registered', 'type' => 'checkbox'],
                ['name' => 'xmp', 'label' => 'XMP', 'type' => 'checkbox'],
                ['name' => 'modules', 'label' => 'Modules (GB)', 'type' => 'text'],
                ['name' => 'price_per_gb', 'label' => 'Price per GB ($)', 'type' => 'number'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['name' => 'first_word_latency', 'label' => 'First Word Latency (ns)', 'type' => 'number'],
                ['name' => 'cas_latency', 'label' => 'CAS Latency', 'type' => 'number'],
                ['name' => 'timing', 'label' => 'Timing', 'type' => 'text'],
                ['name' => 'heat_spreader', 'label' => 'Heat Spreader', 'type' => 'text'],
            ],
            'Motherboard' => [
                ['name' => 'chipset', 'label' => 'Chipset', 'type' => 'text'],
                ['name' => 'cpu_socket', 'label' => 'CPU Socket', 'type' => 'text'],
                ['name' => 'form_factor', 'label' => 'Form Factor', 'type' => 'text'],
                ['name' => 'memory_slots', 'label' => 'Memory Slots', 'type' => 'number'],
                ['name' => 'ram_max_capacity', 'label' => 'RAM Max Capacity (GB)', 'type' => 'number'],
                ['name' => 'pci_slots', 'label' => 'PCI Slots', 'type' => 'number'],
                ['name' => 'usb_ports', 'label' => 'USB Ports', 'type' => 'number'],
                ['name' => 'sata_ports', 'label' => 'SATA Ports', 'type' => 'number'],
                ['name' => 'm_2_slots', 'label' => 'M.2 Slots', 'type' => 'number'],
                ['name' => 'ethernet', 'label' => 'Ethernet', 'type' => 'text'],
                ['name' => 'audio_chip', 'label' => 'Audio Chip', 'type' => 'text'],
            ],
            'Power Supply (PSU)' => [
                ['name' => 'wattage', 'label' => 'Wattage (W)', 'type' => 'number'],
                ['name' => 'efficiency', 'label' => 'Efficiency', 'type' => 'text'],
                ['name' => 'modular', 'label' => 'Modular', 'type' => 'checkbox'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'text'],
                ['name' => 'fan_size', 'label' => 'Fan Size (mm)', 'type' => 'number'],
                ['name' => 'fan_speed', 'label' => 'Fan Speed (RPM)', 'type' => 'number'],
                ['name' => 'cable_length', 'label' => 'Cable Length (m)', 'type' => 'number'],
                ['name' => 'protection', 'label' => 'Protection', 'type' => 'text'],
                ['name' => 'form_factor', 'label' => 'Form Factor', 'type' => 'text'],
            ],
        ];

        foreach ($categories as $categoryName => $fields) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            foreach ($fields as $field) {
                CategoryField::create([
                    'category_id' => $category->id,
                    'name' => $field['name'],
                    'label' => $field['label'],
                    'type' => $field['type'],
                ]);
            }
        }
    }
}
