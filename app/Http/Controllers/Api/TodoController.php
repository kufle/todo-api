<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id',auth()->id())->get();

        return response()->json([
            'message' => 'List of todos',
            'data' => $todos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Todo created successfully',
            'data' => $todo,
        ], 201);
    }

    public function show(Todo $todo)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $todo,
        ]);
    }

    public function update(Todo $todo, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        $todo->update([
            'title' => $request->title,
        ]);

        return response()->json([
            'data' => $todo,
        ]);
    }

    public function destroy(Todo $todo)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully',
        ]);
    }
}
