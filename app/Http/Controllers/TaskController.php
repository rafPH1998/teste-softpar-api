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
        
        return response()->json(['tasks' => $tasks]);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

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
        try {
            $task = Task::findOrFail($taskId);

            $task->update([
              'completed' => !$task->completed, 
              'status' => $task->completed ? 'pending' : 'completed',
              'completed_at' => !$task->completed ? now() : null,
            ]);
    
            return response()->json([
                'message' => 'Status atualizado com sucesso.',
                'task' => $task,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o status da tarefa.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
