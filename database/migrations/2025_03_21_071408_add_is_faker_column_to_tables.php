<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_faker')->after('remember_token')->default(0);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_faker')->after('content')->default(0);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_faker')->after('content')->default(0);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_faker')->after('name')->default(0);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_faker')->after('image')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_faker');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_faker');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('is_faker');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_faker');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_faker');
        });
    }

};
