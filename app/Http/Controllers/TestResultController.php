<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return response()->json(TestResult::with('testCase')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
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
     * Display the specified resource.
     */
    public function show(TestResult $testResult) : JsonResponse
    {
        return response()->json($testResult->load('testCase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestResult $testResult) : JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestResult $testResult) : JsonResponse
    {
        $testResult->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
