<?php

namespace App\Http\Controllers;


use App\Http\Requests\ToDoCreateRequest;
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
                'message' => "ToDo of id {$todo->id} created succesfuly"
            ], 200);
        }
    }

    function update(ToDoUpdateRequest $request){

        $request->validated();

        $todo = ToDo::where("id", $request->id)->first();

        $todo->name = ($request->has("name")) ? $request->name : $todo->name;
        $todo->description = ($request->has("description")) ? $request->description : $todo->description;
        $todo->complete_date = ($request->has("complete_date")) ? $request->complete_date : $todo->complete_date;

        $status = $todo->save();

        if(!$status){
            return response([
                'status' => false,
                'message' => "ToDo not updated"
            ], 500);
        }else{
            return response([
                'status' => true,
                'message' => "ToDo of id {$todo->id} updated",
                'todo' => $todo
            ], 200);
        }


    }
}
