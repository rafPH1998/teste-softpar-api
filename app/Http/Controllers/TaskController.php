<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(protected Task $taskModel)
    { }

    public function index(Request $request)
    {
        $filters = $request->only([
            'status', 
            'date_start', 
            'date_end', 
            'order_by'
        ]);

        $tasks = $this->taskModel->getTasks($filters);
        $totalsByStatus = $this->taskModel->countByStatus($filters);
        
        return response()->json([
            'tasks' => $tasks,
            'totals_by_status' => $totalsByStatus,
        ]);
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
