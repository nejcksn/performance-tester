<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name')->unique();
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name')->unique();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('surname')->unique();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

};
