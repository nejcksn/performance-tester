<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCase;
use App\Models\TestResult;
use App\Services\PerformanceTestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerformanceTestController extends Controller
{
    protected PerformanceTestService $testService;

    public function __construct(PerformanceTestService $testService)
    {
        $this->testService = $testService;
    }

    private function getValidatedModel(Request $request)
    {
        $validated = $request->validate([
            'model' => ['required', 'string', 'in:User,Product,ProductSpec,Post,Comment'],
            'limit' => ['sometimes', 'integer', 'min:1'],
            'runs' => ['sometimes', 'integer', 'min:1'],
            'data' => ['sometimes', 'array'],
        ]);

        $validated['runs'] = $validated['runs'] ?? 1;

        $modelClass = 'App\\Models\\' . $validated['model'];

        if (!class_exists($modelClass)) {
            abort(400, 'Invalid model');
        }

        return [$modelClass, $validated];
    }

    public function testCreate(Request $request): JsonResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Тест вставки {$validated['model']}s",
            'description' => "Вставка {$validated['limit']} записей в {$validated['model']}, {$validated['runs']} раз",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::factory($validated['limit'])->create();
        }, $modelClass, $validated['runs']);

        $result = TestResult::where('test_case_id', $testCase->id)->first();

        return response()->json($result);
    }

    public function testRead(Request $request): JsonResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Тест чтения {$validated['model']}s",
            'description' => "Чтение записей из {$validated['model']}, {$validated['runs']} раз",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $query = $modelClass::query();

            if (!empty($validated['limit'])) {
                $query->limit($validated['limit']);
            }

            return $query->get();
        }, $modelClass, $validated['runs']);

        $result = TestResult::where('test_case_id', $testCase->id)->first();

        return response()->json($result);
    }

    public function testUpdate(Request $request): JsonResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Тест обновления {$validated['model']}s",
            'description' => "Обновление {$validated['limit']} записей в {$validated['model']}, {$validated['runs']} раз",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::query()->inRandomOrder()->limit($validated['limit'])->update($validated['data']);
        }, $modelClass, $validated['runs']);

        $result = TestResult::where('test_case_id', $testCase->id)->first();

        return response()->json($result);
    }
    public function testDelete(Request $request): JsonResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Тест удаления {$validated['model']}s",
            'description' => "Удаление {$validated['limit']} записей из {$validated['model']}, {$validated['runs']} раз",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::query()->inRandomOrder()->limit($validated['limit'])->delete();
        }, $modelClass, $validated['runs']);

        $result = TestResult::where('test_case_id', $testCase->id)->first();

        return response()->json($result);
    }
}
