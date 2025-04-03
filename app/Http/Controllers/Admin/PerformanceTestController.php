<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCase;
use App\Models\TestExecution;
use App\Models\TestResult;
use App\Services\PerformanceTestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PerformanceTestController extends Controller
{
    protected PerformanceTestService $testService;
    protected array $models = ['User', 'Product', 'Post', 'Comment'];

    public function __construct(PerformanceTestService $testService)
    {
        $this->testService = $testService;
    }

    public function index()
    {
        $models = $this->models;

        return view('admin.performance_test.index', compact('models'));
    }

    private function getValidatedModel(Request $request): array
    {
        $validated = $request->validate([
            'model' => ['required', 'string', 'in:User,Product,Post,Comment'],
            'limit' => ['required', 'integer', 'min:1'],
            'runs' => ['required', 'integer', 'min:1'],
            'data' => ['sometimes', 'array'],
        ]);

        $validated['runs'] = $validated['runs'] ?? 1;

        $modelClass = 'App\\Models\\' . $validated['model'];

        if (!class_exists($modelClass)) {
            abort(400, 'Invalid model');
        }

        return [$modelClass, $validated];
    }

    public function testCreate(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Insert test for {$validated['model']}s",
            'description' => "Inserting {$validated['limit']} records into {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::factory($validated['limit'])->create();
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

    public function testRead(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Select test for {$validated['model']}s",
            'description' => "Selecting {$validated['limit']} records from {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $query = $modelClass::query();

            if (!empty($validated['limit'])) {
                $query->limit($validated['limit']);
            }

            return $query->get();  // Обычный select
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

    public function testReadChunk(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Chunk test for {$validated['model']}s",
            'description' => "Chunking {$validated['limit']} records from {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::chunk(100, function ($items) {
                // Обрабатываем chunk, в данном случае просто проходим по записям
                foreach ($items as $item) {
                    // Можно добавить дополнительную логику обработки
                }
            });
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

    public function testReadCursor(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Cursor test for {$validated['model']}s",
            'description' => "Using cursor for {$validated['limit']} reading records from {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            foreach ($modelClass::cursor() as $item) {
                // Обрабатываем каждую запись по очереди
            }
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

    public function testReadCache(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Cache test for {$validated['model']}s",
            'description' => "Using cache to read {$validated['limit']} records from {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            Cache::remember("test_cache_{$validated['model']}", 300, function () use ($modelClass, $validated) {
                return $modelClass::limit($validated['limit'])->get();
            });
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

    public function testUpdate(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Update test for {$validated['model']}s",
            'description' => "Updating {$validated['limit']} records in {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::query()->inRandomOrder()->limit($validated['limit'])->update($validated['data']);
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }
    public function testDelete(Request $request): RedirectResponse
    {
        [$modelClass, $validated] = $this->getValidatedModel($request);

        $testCase = TestCase::create([
            'name' => "Delete test for {$validated['model']}s",
            'description' => "Deleting {$validated['limit']} records from {$validated['model']}, {$validated['runs']} times",
        ]);

        $this->testService->runMultipleTests($testCase->id, function () use ($modelClass, $validated) {
            $modelClass::query()->inRandomOrder()->limit($validated['limit'])->delete();
        }, $modelClass, $validated['runs']);

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        return redirect()->route('admin.test_results.show', ['testCase' => $testCase, 'testResults' => $testResults]);
    }

}
