<?php

namespace App\Services;

use App\Models\Log;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;

class PerformanceTestService {
    public function runTest(int $testCaseId, callable $callback, string $modelClass) : TestResult
    {
        $startTime = microtime(true);

        DB::beginTransaction();
        try {
            $initialCount = $modelClass::count();
            $callback();
            $finalCount = $modelClass::count();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $executionTime = microtime(true) - $startTime;
        $recordCount = $finalCount - $initialCount;

        return TestResult::create([
            'test_case_id' => $testCaseId,
            'execution_time' => $executionTime,
            'record_count' => $recordCount,
        ]);
    }
}
