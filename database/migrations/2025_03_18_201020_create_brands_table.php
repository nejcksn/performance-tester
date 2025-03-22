<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('country')->nullable();
            $table->year('founded_year')->nullable();
            $table->boolean('is_faker')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
