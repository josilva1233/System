<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\MongoTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $task = Task::create($request->all());
        MongoTask::create($request->all());

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        $mongoTask = MongoTask::where('title', $task->title)->first();
        if ($mongoTask) {
            $mongoTask->update($request->all());
        }

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        MongoTask::where('title', $task->title)->delete();

        return response()->json(null, 204);
    }
}
