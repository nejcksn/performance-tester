<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(TestCase::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $testCase = TestCase::create($validated);

        return response()->json($testCase, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(TestCase $testCase): JsonResponse
    {
        return response()->json($testCase);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestCase $testCase): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $testCase->update($validated);

        return response()->json($testCase);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestCase $testCase): JsonResponse
    {
        $testCase->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
