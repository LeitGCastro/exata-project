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
    public function index() : Response {
        return Inertia::render('Dashboard', [
            'tasks' => Auth::user()->getTasks()
        ]);
    }

    public function taskForm($task_id) : Response {
        $task = Task::findOrFail($task_id);        

        return Inertia::render('Dashboard', [
            'tasks' => Auth::user()->getTasks(),
            'task' => $task
        ]);
    }

    public function store(Request $request) : RedirectResponse {

        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $newTask = Task::create([
            'title' => $validated['title'],
            'user_id' => $request->user()->id,
        ]);    
                
        return Redirect::route('dashboard')->with('success', 'Tarefa criada com sucesso!');
    }

    public function update(Request $request, $task_id) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $task = Task::findOrFail($task_id);
        if (!Gate::allows('update-task', $task)) abort(403);

        $task->status = $validated['status'];
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->save();

        return Redirect::route('dashboard')->with('success', 'Tarefa atualizada');
    }

    public function updateStatus(Request $request, $task_id) {
        $validated = $request->validate([
            'status' => 'required|string|max:255'
        ]);

        $task = Task::findOrFail($task_id);
        if (!Gate::allows('update-task', $task)) abort(403);

        $task->status = $validated['status'];
        $task->save();

        return Redirect::route('dashboard')->with('success', 'Status atualizado');
    }

    public function delete($task_id) {

        $task = Task::findOrFail($task_id);
        if (!Gate::allows('delete-task', $task)) abort(403);

        $task->delete();

        return Redirect::route('dashboard')->with('success', 'Tarefa removida');
    }
}
