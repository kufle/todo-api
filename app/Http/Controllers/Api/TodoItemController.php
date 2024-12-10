<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoItemController extends Controller
{
    public function index(Todo $todo)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        
        $todos = TodoItem::where('todo_id', $todo->id)->get();

        return response()->json([
            'message' => 'List of todos '. $todo->title,
            'title' => $todo->title,
            'data' => $todos,
        ]);
    }

    public function store(Todo $todo, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        $todoItem = TodoItem::create([
            'todo_id' => $todo->id,
            'title' => $request->title,
            'checked' => 0
        ]);

        return response()->json([
            'message' => 'Todo Item created successfully',
            'todo_id' => $todo->id,
            'data' => $todoItem,
        ], 201);
    }

    public function show(Todo $todo, TodoItem $item)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'List of todos '.$todo->title,
            'title' => $todo->title,
            'data' => $item,
        ]);
    }

    public function update(Todo $todo, TodoItem $item, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        $item->update([
            'title' => $request->title
        ]);

        return response()->json([
            'message' => 'Todo Item Updated '.$item->title,
            'title' => $todo->title,
            'data' => $item,
        ]);
    }

    public function updateCheck(Todo $todo, TodoItem $item)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        $item->update([
            'checked' => !$item->checked
        ]);

        return response()->json([
            'message' => 'Checked Updated '.$todo->title,
            'title' => $todo->title,
            'data' => $item,
        ]);
    }

    public function destroy(Todo $todo, TodoItem $item)
    {
        if($todo->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }

        $item->delete();

        return response()->json([
            'message' => 'Todo Item deleted successfully',
        ]);
    }
}
