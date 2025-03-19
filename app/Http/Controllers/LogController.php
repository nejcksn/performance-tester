<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return response()->json(Log::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'operation' => 'required|string|max:50',
            'execution_time' => 'required|numeric|min:0',
            'created_at' => 'nullable|date',
        ]);

        $log = Log::create($validated);

        return response()->json($log, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Log $log) : JsonResponse
    {
        return response()->json($log);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Log $log) : JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log) : JsonResponse
    {
        $log->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
