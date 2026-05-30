<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->get();

        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Todo::create([
            'title' => $request->title,
            'completed' => false,
        ]);

        return back();
    }

    public function toggle(Todo $todo)
    {
        $todo->update([
            'completed' => ! $todo->completed,
        ]);

        return back();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return back();
    }
}
