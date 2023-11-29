<?php

namespace App\Http\Controllers;


use App\Http\Requests\ToDoCreateRequest;
use App\Http\Requests\ToDoDeleteRequest;
use App\Http\Requests\ToDoUpdateRequest;
use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    function create(ToDoCreateRequest $request){
        $request->validated();

        $todo = new ToDo($request->all());

        $todo->user_id = Auth::id();

        $status = $todo->save();

        if(!$status){
            return response([
                'status' => false,
                'message' => "ToDo not created"
            ], 500);
        }else{
            return response([
                'status' => true,
                'message' => "ToDo created successfully"
            ], 200);
        }
    }

    function update(ToDoUpdateRequest $request){

        $request->validated();

        $todo = ToDo::where("id", $request->id)->first();

        $todo->name = ($request->has("name")) ? $request->name : $todo->name;
        $todo->description = ($request->has("description")) ? $request->description : $todo->description;
        $todo->completeDate = ($request->has("completeDate")) ? $request->completeDate : $todo->completeDate;

        $status = $todo->save();

        if(!$status){
            return response([
                'status' => false,
                'message' => "ToDo not updated"
            ], 500);
        }else{
            return response([
                'status' => true,
                'message' => "ToDo \"{$todo->name}\" updated",
                'todo' => $todo
            ], 200);
        }


    }

    function get(){

        $user = Auth::user();

        if(!$user){
            return response([
                'status' => false,
                'message' => "User not found"
            ], 500);
        }

        return response([
            'status' => true,
            'message' => "lists of todos",
            'todo' => $user->toDos
        ], 200);


    }

    function delete(ToDoDeleteRequest $request){
        $request->validated();

        $todo = ToDo::findOrFail($request->id);


        $status = $todo->delete();

        if(!$status){
            return response([
                'status' => false,
                'message' => "ToDo of id {$request->id} not deleted"
            ], 500);
        }else{
            return response([
                'status' => true,
                'message' => "ToDo of id {$todo->id} deleted successfully"
            ], 200);
        }

    }
}
