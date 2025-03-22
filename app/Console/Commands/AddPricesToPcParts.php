<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddPricesToPcParts extends Command
{
    protected $signature = 'json:add-prices';
    protected $description = 'Добавляет цены в JSON-файлы PC parts, если они отсутствуют';

    public function handle()
    {
        $directory = storage_path('app/json/'); // Папка с JSON-файлами

        if (!is_dir($directory)) {
            $this->error("Папка json/ не найдена!");
            return;
        }

        // Ценовые диапазоны (в долларах)
        $priceRanges = [
            "cpu" => [100, 800],
            "gpu" => [200, 2000],
            "ram" => [30, 300],
            "hdd" => [50, 500],
            "ssd" => [50, 500],
            "motherboard" => [80, 500],
            "power-supply" => [40, 250],
            "case" => [30, 400],
            "cooler" => [20, 150],
            "case-accessory" => [10, 100],
            "case-fan" => [10, 80],
            "cpu-cooler" => [20, 250],
            "external-hard-drive" => [50, 500],
            "fan-controller" => [15, 100],
            "headphones" => [20, 300],
            "internal-hard-drive" => [50, 500],
            "keyboard" => [15, 250],
            "memory" => [30, 300],
            "monitor" => [100, 1500],
            "mouse" => [10, 200],
            "optical-drive" => [20, 100],
            "os" => [50, 200],
            "sound-card" => [30, 300],
            "speakers" => [20, 500],
            "thermal-paste" => [5, 50],
            "ups" => [50, 500],
            "video-card" => [200, 2000],
            "webcam" => [20, 300],
            "wired-network-card" => [10, 150],
            "wireless-network-card" => [15, 200]
        ];

        // Обрабатываем все файлы JSON
        $files = glob($directory . '*.json');
        foreach ($files as $file) {
            $filename = basename($file, '.json');

            if (!isset($priceRanges[$filename])) {
                $this->warn("Пропущен: $filename.json (нет диапазона цен)");
                continue;
            }

            $data = json_decode(file_get_contents($file), true);
            if (!$data) {
                $this->error("Ошибка чтения $filename.json!");
                continue;
            }

            [$min, $max] = $priceRanges[$filename];

            foreach ($data as &$item) {
                if (!isset($item['price'])) {
                    $item['price'] = mt_rand($min * 100, $max * 100) / 100;
                }
            }

            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("Обновлено: $filename.json");
        }

        $this->info("Все файлы обновлены!");
    }
}
