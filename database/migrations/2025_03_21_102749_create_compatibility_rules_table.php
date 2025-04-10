<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_1')->constrained('categories')->onDelete('cascade');
            $table->foreignId('category_2')->constrained('categories')->onDelete('cascade');
            $table->string('rule');
            $table->boolean('is_faker')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibility_rules');
    }
};
