<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceItemController;
use App\Http\Controllers\ServiceOrderController;

Route::get("/", [HomeController::class, "index"]);
//Route::get("/internal-events", [InternalEventController::class, "Index"]);
//Route::match(["get", "post"], "/tasks", [TaskController::class, "Index"]); 

/* --------- Clients --------- */
Route::get('/clients', [ClientController::class, 'Index']);
Route::get('/clients/create', [ClientController::class, 'Create']);
Route::post('/clients/create', [ClientController::class, 'Store']);
Route::get('/clients/edit/{id}', [ClientController::class, 'Edit']);
Route::post('/clients/edit/{id}', [ClientController::class, 'Update']);
Route::post('/clients/delete/{id}', [ClientController::class, 'Delete']);

/* --------- Employees --------- */
Route::get('/employees', [EmployeeController::class, 'Index']);
Route::get('/employees/create', [EmployeeController::class, 'Create']);
Route::post('/employees/create', [EmployeeController::class, 'Store']);
Route::get('/employees/edit/{id}', [EmployeeController::class, 'Edit']);
Route::post('/employees/edit/{id}', [EmployeeController::class, 'Update']);
Route::post('/employees/delete/{id}', [EmployeeController::class, 'Delete']);

/* --------- Service Categories --------- */
Route::get('/serviceCategories', [ServiceCategoryController::class, 'Index']);
Route::get('/serviceCategories/create', [ServiceCategoryController::class, 'Create']);
Route::post('/serviceCategories/create', [ServiceCategoryController::class, 'Store']);
Route::get('/serviceCategories/edit/{id}', [ServiceCategoryController::class, 'Edit']);
Route::post('/serviceCategories/edit/{id}', [ServiceCategoryController::class, 'Update']);
Route::post('/serviceCategories/delete/{id}', [ServiceCategoryController::class, 'Delete']);

/* --------- Service Items --------- */
Route::get('/serviceItems', [ServiceItemController::class, 'Index']);
Route::get('/serviceItems/create', [ServiceItemController::class, 'Create']);
Route::post('/serviceItems/create', [ServiceItemController::class, 'Store']);
Route::get('/serviceItems/edit/{id}', [ServiceItemController::class, 'Edit']);
Route::post('/serviceItems/edit/{id}', [ServiceItemController::class, 'Update']);
Route::post('/serviceItems/delete/{id}', [ServiceItemController::class, 'Delete']);

/* --------- Service Orders --------- */
Route::get('/serviceOrders', [ServiceOrderController::class, 'Index']);
Route::get('/serviceOrders/create', [ServiceOrderController::class, 'Create']);
Route::post('/serviceOrders/create', [ServiceOrderController::class, 'Store']);
Route::get('/serviceOrders/edit/{id}', [ServiceOrderController::class, 'Edit']);
Route::post('/serviceOrders/edit/{id}', [ServiceOrderController::class, 'Update']);
Route::post('/serviceOrders/delete/{id}', [ServiceOrderController::class, 'Delete']);


