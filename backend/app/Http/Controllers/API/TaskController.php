<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    /**
     * GET /api/tasks
     * Liste toutes les tâches de l'utilisateur connecté
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return response()->json($tasks);
    }

    /**
     * GET /api/tasks/{id}
     * Affiche une tâche si elle appartient à l'utilisateur
     */
    public function show($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($task);
    }

    /**
     * POST /api/tasks
     * Crée une nouvelle tâche et déclenche un event broadcast
     */


    public function store(Request $request)
{
    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'status'      => 'required|string|in:pending,todo,done',
        'due_at'      => 'nullable|date',
    ]);

    // Associer la tâche à l'utilisateur connecté
    $task = auth('api')->user()->tasks()->create($data);

    return response()->json([
        'message' => 'Task created successfully',
        'task'    => $task
    ], 201);
}


    /**
     * PUT /api/tasks/{id}
     * Met à jour une tâche si elle appartient à l'utilisateur
     */
    public function update(Request $request, $id)
{
    $task = Task::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

    $data = $request->validate([
        'title'        => 'sometimes|string|max:255',
        'description'  => 'sometimes|nullable|string',
        'status'       => 'sometimes|in:pending,todo,done',
        'due_at'       => 'sometimes|nullable|date',
        'completed_at' => 'sometimes|nullable|date',
    ]);

    $task->update($data);

    return response()->json([
        'message' => 'Task updated successfully',
        'task'    => $task,
    ]);
}

    /**
     * DELETE /api/tasks/{id}
     * Supprime une tâche si elle appartient à l'utilisateur
     */
    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
