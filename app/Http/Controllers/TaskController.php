<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query();

        if ($request->filled('status')) {
            $tasks->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $tasks->whereDate('created_at', $request->date);
        }

        $tasks = $tasks->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'asc'))->get();

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $task = Task::query()->create($validated);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        if ($validated['status'] === 'completed' && !$task->completed_at) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
