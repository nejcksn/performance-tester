<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return response()->json(Order::with(['user', 'products'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $order = Order::create(['user_id' => $validated['user_id']]);

            foreach ($validated['products'] as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }

            return response()->json($order->load('products'), Response::HTTP_CREATED);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order) : JsonResponse
    {
        return response()->json($order->load(['user', 'products']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order) : JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order) : JsonResponse
    {
        $order->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
