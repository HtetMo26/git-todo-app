<?php

namespace App\Http\Controllers;

use App\ToDo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index() {
        $todos = ToDo::where('user_id',Auth::user()->id)->get();
        $users = User::where('id',Auth::user()->id)->get();

        return view('todopage', compact('todos', 'users'));

    }

    public function storeData(Request $request) {
        $request->validate([
            'taskname' => 'required'
        ]);

        $newTask = new ToDo;
        $newTask->create([
            'name' => $request->taskname,
            'status' => 0,
            'user_id' => Auth::user()->id
        ]);

        return back()->with('success', 'Task created successfully!');

    }

    public function deleteData(Request $request) {        
        $todo = ToDo::find($request->id);
        $todo->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function show(Request $request) {
        $editToDo = ToDo::find($request->id);

        return view('edit-task', compact('editToDo'));
    }

    public function updateData(Request $request, $id) {
        $request->validate([
            'updatetask' => 'required'
        ]);

       $name = $request->updatetask; 
       ToDo::find($id)->update(['name'=>$name]);

       return redirect('/todopage')->with('success', 'Task updated successfully!');
    }   

    public function updateStatus(Request $request) {
        $status = $request->checkstatus;
        $id = $request->todoid;
        ToDo::find($id)->update(['status'=>$status]);

        return back()->with('success','Task marked as complete.');
    }
}
