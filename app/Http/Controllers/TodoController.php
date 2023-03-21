<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TodoController extends Controller
{
    // Show All Todos
    public function index()
    {   
        return view('todos.index', [            
            'todos' => Todo::latest()->select('todos.*')
                        ->filter(request(['category', 'search', 'owner', 'status']))
                        ->paginate(5)->withQueryString()
        ]);
    }

    // Show Single Todo
    public function show(Todo $todo){
        return view('todos.show', [
            'todo' => $todo
        ]);
    }

    // Show Create Form
    public function create(){
        return view('todos.create', [
            'categories' => Category::all()
        ]);
    }

    // Store Todo Data
    public function store(Request $request){
        $formData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $formData['user_id'] = auth()->id();

        Todo::create($formData);

        return redirect('/')->with('message', 'Task was created successfully!');
    }

    // Edit Todo Data
    public function edit(Todo $todo){
        return view('todos.edit', [ 'todo' => $todo, 'categories' => Category::all()]);
    }

    // Update Todo Data
    public function update(Request $request, Todo $todo){    
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $todo)) {
            abort(403, 'Unauthorized Action');
        }

        $formData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);        

        $todo->update($formData);
        
        return redirect('/')->with('message', 'Task was updated successfully!');
    }

    public function destroy(Todo $todo){
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $todo)) {
            abort(403, 'Unauthorized Action');
        }

        $todo->delete();

        return back()->with('message', 'Task was deleted successfully! <a href="/todos/'.$todo->id.'/restore">UNDO</a>');
    }

    public function restore($todo){        
        $trashed_todo = Todo::withTrashed()->find($todo);
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $trashed_todo)) {
            abort(403, 'Unauthorized Action');
        }

        if($trashed_todo && $trashed_todo->trashed()){            
            $trashed_todo->restore();
        }
        
        return back()->with('message', 'Task was restored successfully!');
    }

    // Show Share Form
    public function share(Todo $todo){        
        return view('todos.share', [
            'todo' => $todo,
            'users' => User::all(['id','name'])->except(auth()->user()->id),
            'shared_users' => $todo->shared_users()->get(['user_id']),
        ]);
    }

    // Update Sharing
    public function share_update(Request $request, Todo $todo){ 
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $todo)) {
            abort(403, 'Unauthorized Action');
        }

        // Distinguish between Share and Unshare
        $share_to_ids = [];
        foreach($request['shared_users'] as $user_id){                
            if($user_id == 0){
                $share_to_ids = [];
                break;
            } else {
                $share_to_ids[] = $user_id;
            }            
        }

        // Update sharing
        $message = 'Task was shared successfully!';
        if(empty($share_to_ids)){            
            $todo->shared_users()->detach();
            $message = 'Sharing was cancelled successfully!';
        } else {
            $todo->shared_users()->sync($share_to_ids);
        } 
        
        return redirect('/')->with('message', $message);        
    }

    // Set task as completed
    public function complete(Todo $todo){ 
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $todo)) {
            abort(403, 'Unauthorized Action');
        }

        $todo->completed = true;
        $todo->save();
        
        return redirect('/')->with('message', 'Task was completed!');        
    }

    // Set task as NOT completed
    public function reopen(Todo $todo){ 
        // Make sure user is an owner
        if (! Gate::allows('update-todo', $todo)) {
            abort(403, 'Unauthorized Action');
        }
        $todo->completed = false;
        $todo->save();
                
        return redirect('/')->with('message', 'Task was REOPENED!');        
    }
}
