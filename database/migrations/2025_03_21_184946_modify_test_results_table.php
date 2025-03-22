<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn('execution_time'); // Удаление execution_time
            $table->float('min_time')->nullable()->after('test_case_id');
            $table->float('avg_time')->nullable()->after('min_time');
            $table->float('max_time')->nullable()->after('avg_time');
        });
    }

    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->float('execution_time')->nullable()->after('test_case_id'); // Восстановление execution_time
            $table->dropColumn(['min_time', 'avg_time', 'max_time']);
        });
    }
};
