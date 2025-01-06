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

        $tasks = $tasks->orderBy(
            $request->get('sort_by', 'created_at'), 
            $request->get('order', 'asc')
        )->where('user_id', '=', auth()->user()->id)
        ->get();

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

        if ($request->status === 'completed' && !$task->completed_at) {
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
    
    public function updateStatus(int $taskId)
    {
        $task = Task::query()->findOrFail($taskId);

        $task->update([
            'completed' => true,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Status atualizado com sucesso.',
            'task' => $task,
        ], 200);
    }
}
