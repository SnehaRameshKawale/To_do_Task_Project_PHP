<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $request->session()->get('tasks',[]);
        return view('index',['tasks'=> $tasks]);
    }

    public function store(Request $request)
    {
        $tasks = $request->session()->get('tasks',[]);
        $input = trim($request->input('tasks'));
        if (!empty($input)) {
            // Split by new line and clean up
            $newTasks = array_filter(array_map('trim', explode("\n", $input)));

            // Merge old and new tasks
            $tasks = array_merge($tasks, $newTasks);

            // Store back into session
            $request->session()->put('tasks', $tasks);

            // Add a flash message
            return redirect()->route('tasks.index')->with('success', 'Tasks added successfully!');
        }
        // If empty input, redirect without changes
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $tasks = $request->session()->get('tasks', []);
        if (isset($tasks[$id])) {
            unset($tasks[$id]);
            $request->session()->put('tasks', array_values($tasks)); // Reindex
        }
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


}
