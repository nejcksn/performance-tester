<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() 
    {
        Log::factory(10)->create([
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ]);
    }
}
