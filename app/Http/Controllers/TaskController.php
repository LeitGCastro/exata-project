<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function getAll() : Response {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $tasks = Task::all();
        } else {
            $tasks = $user->tasks;
        }

        return Inertia::render('Dashboard', [
            'tasks' => $tasks 
        ]);
    }

    public function store(Request $request) : RedirectResponse {

        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        // Lógica para criar a tarefa
        $newTask = Task::create([
            'title' => $validated['title'],
            'user_id' => $request->user()->id,
        ]);    
                
        return Redirect::route('dashboard')->with('success', 'Tarefa criada com sucesso!');
    }

    public function updateStatus(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer',
            'status' => 'required|string|max:255'
        ]);

        $task = Task::findOrFail($validated['id']);
        $task->status = $validated['status'];
        $task->save();

        return response()->json([
            'message' => 'Tarefa atualizada com sucesso!',
            'task' => $task
        ]);
    }
}
