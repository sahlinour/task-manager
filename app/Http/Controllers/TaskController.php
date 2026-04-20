<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('Tasks.tasks', compact('tasks'));
    }

    public function dashboard()
    {
        $tasks = auth()->user()->tasks()->get();

        return view('dashboard', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->count(),
            'completedTasks' => $tasks->where('status', 'completed')->count(),
            'inProgressTasks' => $tasks->where('status', 'in_progress')->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Tasks.create_task');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => auth()->id()
        ]);

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('Tasks.edit_task', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect('/tasks');

    }
}
