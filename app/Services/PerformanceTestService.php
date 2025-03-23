<?php

namespace App\Services;

//use App\Models\Log;
use Illuminate\Support\Facades\Log;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;

class PerformanceTestService {

    public function updateTestResults(int $testCaseId): void
    {
        $times = DB::table('test_executions')
            ->where('test_case_id', $testCaseId)
            ->pluck('execution_time');

        $recordCounts = DB::table('test_executions')
            ->where('test_case_id', $testCaseId)
            ->pluck('record_count');

        $testCount = $times->count();

        if ($times->isEmpty()) {
            return;
        }

        $minTime = $times->min();
        $avgTime = $times->avg();
        $maxTime = $times->max();
        $avgRecords = $recordCounts->avg();

        TestResult::updateOrCreate(
            ['test_case_id' => $testCaseId],
            [
                'min_time' => $minTime,
                'avg_time' => $avgTime,
                'max_time' => $maxTime,
                'record_count' => $avgRecords,
                'test_count' => $testCount,
            ]
        );
    }

    public function runTest(int $testCaseId, callable $callback, string $modelClass): void
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

        // Запись в test_executions
        DB::table('test_executions')->insert([
            'test_case_id' => $testCaseId,
            'execution_time' => $executionTime,
            'created_at' => now(),
            'record_count' => $recordCount,
        ]);
    }

    public function runMultipleTests(int $testCaseId, callable $callback, string $modelClass, int $runs): void
    {
        for ($i = 0; $i < $runs; $i++) {
            $this->runTest($testCaseId, $callback, $modelClass);
        }

        $this->updateTestResults($testCaseId);
    }

}
