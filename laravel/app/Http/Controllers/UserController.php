<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function register(UserCreateRequest $request){
        $request->validated();
        $user = new User($request->all());
        $status = $user->save();

        if(!$status){
            return response([
                'status' => false,
                'message' => "User not created"
            ], 500);
        }else{
            return response([
                'status' => true,
                'token' => $user->createToken("authToken")->plainTextToken,
                'message' => "User created successfully"
            ], 200);
        }
    }



    function login(UserLoginRequest $request){
        $request->validated();
        if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("authToken")->plainTextToken
            ], 200);
    }

    function delete(userDeleteRequest $request){
        $request->validated();

        $user = User::findOrFail($request->id);

            if($user->delete()){
                return response()->json([
                    'status' => true,
                    "message' => 'User deleted of id {$request->id}",
                    'token' => $user->createToken("authToken")->plainTextToken
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    "message' => 'Error when deleting of id {$request->id}"
                ], 500);
            }

    }
}
