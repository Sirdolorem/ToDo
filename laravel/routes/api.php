<?php

use App\Http\Controllers\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("/auth/register", [UserController::class, "register"]);
Route::post("/auth/login", [UserController::class, "login"]);
Route::post("/auth/delete", [UserController::class, "delete"]);
Route::post("/todo/create", [ToDoController::class, "create"])->middleware("auth:sanctum");
Route::post("/todo/update", [ToDoController::class, "update"])->middleware("auth:sanctum");

