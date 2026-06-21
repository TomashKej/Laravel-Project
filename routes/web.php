<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceItemController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PositionController;

/* --------- Home --------- */
Route::get("/", [HomeController::class, "index"]);

Route::middleware('auth')->group(function () {

    /* --------- Clients --------- */
    Route::get('/clients', [ClientController::class, 'Index']);
    Route::get('/clients/create', [ClientController::class, 'Create']);
    Route::post('/clients/create', [ClientController::class, 'Store']);
    Route::get('/clients/edit/{id}', [ClientController::class, 'Edit']);
    Route::get('/clients/details/{id}', [ClientController::class, 'Details']);
    Route::post('/clients/edit/{id}', [ClientController::class, 'Update']);
    Route::post('/clients/delete/{id}', [ClientController::class, 'Delete']);

    /* --------- Employees --------- */
    Route::get('/employees', [EmployeeController::class, 'Index']);
    Route::get('/employees/create', [EmployeeController::class, 'Create']);
    Route::post('/employees/create', [EmployeeController::class, 'Store']);
    Route::get('/employees/edit/{id}', [EmployeeController::class, 'Edit']);
    Route::get('/employees/details/{id}', [EmployeeController::class, 'Details']);
    Route::post('/employees/edit/{id}', [EmployeeController::class, 'Update']);
    Route::post('/employees/delete/{id}', [EmployeeController::class, 'Delete']);

    /* --------- Service Categories --------- */
    Route::get('/serviceCategories', [ServiceCategoryController::class, 'Index']);
    Route::get('/serviceCategories/create', [ServiceCategoryController::class, 'Create']);
    Route::post('/serviceCategories/create', [ServiceCategoryController::class, 'Store']);
    Route::get('/serviceCategories/edit/{id}', [ServiceCategoryController::class, 'Edit']);
    Route::get('/serviceCategories/details/{id}', [ServiceCategoryController::class, 'Details']);
    Route::post('/serviceCategories/edit/{id}', [ServiceCategoryController::class, 'Update']);
    Route::post('/serviceCategories/delete/{id}', [ServiceCategoryController::class, 'Delete']);

    /* --------- Service Items --------- */
    Route::get('/serviceItems', [ServiceItemController::class, 'Index']);
    Route::get('/serviceItems/create', [ServiceItemController::class, 'Create']);
    Route::post('/serviceItems/create', [ServiceItemController::class, 'Store']);
    Route::get('/serviceItems/edit/{id}', [ServiceItemController::class, 'Edit']);
    Route::get('/serviceItems/details/{id}', [ServiceItemController::class, 'Details']);
    Route::post('/serviceItems/edit/{id}', [ServiceItemController::class, 'Update']);
    Route::post('/serviceItems/delete/{id}', [ServiceItemController::class, 'Delete']);

    /* --------- Service Orders --------- */
    Route::get('/serviceOrders', [ServiceOrderController::class, 'Index']);
    Route::get('/serviceOrders/create', [ServiceOrderController::class, 'Create']);
    Route::post('/serviceOrders/create', [ServiceOrderController::class, 'Store']);
    Route::get('/serviceOrders/details/{id}', [ServiceOrderController::class, 'Details']);
    Route::get('/serviceOrders/edit/{id}', [ServiceOrderController::class, 'Edit']);
    Route::post('/serviceOrders/edit/{id}', [ServiceOrderController::class, 'Update']);
    Route::post('/serviceOrders/delete/{id}', [ServiceOrderController::class, 'Delete']);

    /* --------- Admin --------- */
    Route::get('/admin/users', [AdminController::class, 'Users']);
    Route::get('/admin/users/create', [AdminController::class, 'Create']);
    Route::post('/admin/users/create', [AdminController::class, 'Store']);
    Route::get('/admin/users/edit/{id}', [AdminController::class, 'Edit']);
    Route::post('/admin/users/edit/{id}', [AdminController::class, 'Update']);

    Route::post('/admin/users/activate/{id}', [AdminController::class, 'Activate']);
    Route::post('/admin/users/deactivate/{id}', [AdminController::class, 'Deactivate']);
    Route::post('/admin/users/makeAdmin/{id}', [AdminController::class, 'MakeAdmin']);
    Route::post('/admin/users/removeAdmin/{id}', [AdminController::class, 'RemoveAdmin']);

    /* --------- Positions --------- */
    Route::get('/positions', [PositionController::class, 'Index']);
    Route::get('/positions/create', [PositionController::class, 'Create']);
    Route::post('/positions/create', [PositionController::class, 'Store']);
    Route::get('/positions/details/{id}', [PositionController::class, 'Details']);
    Route::get('/positions/edit/{id}', [PositionController::class, 'Edit']);
    Route::post('/positions/edit/{id}', [PositionController::class, 'Update']);
    Route::post('/positions/delete/{id}', [PositionController::class, 'Delete']);
});

/* --------- Authorisation --------- */
//Route::get('/register', [AuthController::class, 'Register']);
//Route::post('/register', [AuthController::class, 'StoreRegister']);
Route::get('/login', [AuthController::class, 'Login'])->name('login');
Route::post('/login', [AuthController::class, 'StoreLogin']);
Route::post('/logout', [AuthController::class, 'Logout']);

Route::get('/forgotPassword', [AuthController::class, 'ForgotPassword']);
Route::post('/forgotPassword/question', [AuthController::class, 'ForgotPasswordQuestion']);

Route::get('/forgotPassword/reset', [AuthController::class, 'ShowResetPassword']);
Route::post('/forgotPassword/reset', [AuthController::class, 'ResetPassword']);

Route::get('/forgotPassword/question', function () {
    return redirect('/forgotPassword');
});



