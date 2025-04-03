<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCase;
use App\Models\TestExecution;
use App\Models\TestResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testResults = TestResult::orderBy('created_at', 'desc')->get();

        return view('admin.test_results.index', compact('testResults'));
    }

    public function show(TestCase $testCase)
    {
        $allowedViews = ['overall', 'detail'];
        $view = request('view', 'overall');
        if (!in_array($view, $allowedViews)) {
            return redirect()->route('admin.test_results.show', ['testCase' => $testCase]); // Если роль невалидная - редирект
        }

        $testResults = TestResult::where('test_case_id', $testCase->id)->first();

        $testExecutions = $view === 'detail' ? TestExecution::where('test_case_id', $testCase->id)->get() : [];

        return view('admin.test_results.show', compact('testCase', 'testResults', 'testExecutions', 'view'));
    }

    public function graph(Request $request)
    {
        $validated = $request->validate([
            'testResults' => 'required|array',
            'testResults.*' => 'integer|exists:test_results,id',
            'dataTypes' => 'required|array',
            'dataTypes.*' => 'in:min_time,avg_time,max_time',
        ]);

        $testResultIds = $validated['testResults'];
        $selectedDataTypes = $validated['dataTypes'];

        $testResults = TestResult::whereIn('id', $testResultIds)->get();

        return view('admin.test_results.graph', [
            'labels'   => $testResults->pluck('testCase.description'),
            'minTimes' => in_array('min_time', $selectedDataTypes) ? $testResults->pluck('min_time') : [],
            'avgTimes' => in_array('avg_time', $selectedDataTypes) ? $testResults->pluck('avg_time') : [],
            'maxTimes' => in_array('max_time', $selectedDataTypes) ? $testResults->pluck('max_time') : [],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'test_case_id' => 'required|exists:test_cases,id',
            'execution_time' => 'required|numeric|min:0',
            'status' => 'required|string|max:20',
            'created_at' => 'nullable|date',
        ]);

        $testResult = TestResult::create($validated);

        return response()->json($testResult, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestResult $testResult): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestResult $testResult): JsonResponse
    {
        $testResult->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
