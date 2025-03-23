<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return response()->json(Comment::with(['user', 'post'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = Comment::create($validated);

        return response()->json($comment, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment) : JsonResponse
    {
        return response()->json($comment->load(['user', 'post']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment) : JsonResponse
    {
        $validated = $request->validate([
            'body' => 'sometimes|string',
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment) : JsonResponse
    {
        $comment->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
