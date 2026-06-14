<?php

use App\Http\Controllers\InternalEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"]);
Route::get("/internal-events", [InternalEventController::class, "Index"]);
Route::match(["get", "post"], "/tasks", [TaskController::class, "Index"]); 
