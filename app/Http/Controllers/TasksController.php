<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    //

    public function index(Request $request) {
        $tasks = Task::all();

        return response()->json($tasks,200);
    }

    public function show(Request $request, Task $task) {
        return response()->json($task, 200);
    }

    public function store(Request $request) {
      $task = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required'
        ]);

        // Create task
        $task = Task::create($task);

        return response()->json($task, 200);
    }

    public function update(Request $request,Task $task) {
        $updatedTask = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'completed' => 'boolean|required'
        ]);
        
        $task->update($updatedTask);
        
        return response()->json($task, 200);
    }


    public function destroy(Request $request, Task $task) {
        $task->delete();
        return response()->json("task deleted", 200);
    }
}
