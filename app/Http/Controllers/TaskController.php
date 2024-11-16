<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function getAll() : Response {
        $user = Auth::user();

        // Gate::authorize('view');

        
        if ($user->isAdmin()) {
            $tasks = Task::all();
        } else {
            $tasks = $user->tasks;
        }

        return Inertia::render('Dashboard', [
            'tasks' => $tasks 
        ]);
    }
}
