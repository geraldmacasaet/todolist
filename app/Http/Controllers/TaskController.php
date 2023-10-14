<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Tasks not deleted
        $pendingTasks = Task::where('user_id', auth()->user()->id)
            ->where('is_done', 0)
            ->get();

        $doneTasks = Task::where('user_id', auth()->user()->id)
            ->where('is_done', 1)
            ->get();

        //Tasks deleted
        $deletedTasks = Task::where('user_id', auth()->user()->id)
            ->where('deleted_at', '!=', 'null')
            ->withTrashed()
            ->get();

        //return to Dashboard
        return view('dashboard', ['pendingTasks' => $pendingTasks, 'doneTasks' => $doneTasks, 'deletedTasks' => $deletedTasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate Form Requests
        $request->validate(
            [
                'description' => 'required|max:255'
            ],
            [
                'description.required' => "Task is required.",
                'description.max' => 'Task character count should not be longer than 255.'
            ]
        );

        //Save Form Input to Task Model (tasks table)
        $task = Task::create([
            'description' => $request->description,
            'is_done' => false,
            'user_id' => auth()->user()->id
        ]);

        // Return to Named Route Task Index
        return to_route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {

        //Get the Task model using id
        $task = Task::find($task->id);

        //Assign value of $request->is_done to $task->is_done
        $task->is_done = $request->is_done;

        //Save the changes
        $task->save();

        return to_route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Find the model using id and delete
        Task::find($task->id)->delete();

        return to_route('tasks.index');
    }

    public function restore($id)
    {

        // Find the model using id INCLUDING trashed or deleted entries and RESTORE or nullify the deleted_at column
        Task::withTrashed()->find($id)->restore();

        return to_route('tasks.index');
    }
}
