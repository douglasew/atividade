<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessageJob;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    //
    public function index()
    {
        //
        $search = request('search');

        if ($search) {
            $data = Task::where('title', 'like', '%' . $search . '%')
                ->paginate(8);
        } else {
            $data = Task::paginate(8);
        }

        return view('tasks.show', [
            'tasks' => $data, 'search' => $search
        ]);
    }

    public function create(): View
    {
        //
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:255',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        dispatch(new SendMessageJob())->onQueue('default');

        return Redirect::to('tasks');
    }

    public function destroy(string $id): RedirectResponse
    {
        //
        $task = Task::find($id);
        $task->delete();

        return Redirect::to('tasks');
    }
}
