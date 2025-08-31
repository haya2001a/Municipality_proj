<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\DepartmentsController;
use App\Http\Controllers\AdminControllers\PermissionsController;
use App\Http\Controllers\AdminControllers\RequestsController;
use App\Http\Controllers\AdminControllers\RolesController;
use App\Http\Controllers\AdminControllers\ServicesController;
use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\CitizenControllers\CitizenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeControllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Dashboard
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    // Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::resource('services', ServicesController::class);
    Route::get('/requests', [AdminController::class, 'index'])->name('requests');
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::resource('/requests', RequestsController::class);
    Route::get('/requests/{id}/employees', [RequestsController::class, 'getEmployees'])->name('requests.employees');
    Route::post('/requests/{id}/assign', [RequestsController::class, 'assign'])->name('requests.assign');

    Route::get('/roles', [RolesController::class, 'getRoles'])->name('roles');
    Route::get('/departments', [DepartmentsController::class, 'getDepartments'])->name('departments');

});

// Employee Dashboard
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
});

// Citizen Dashboard
Route::middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'index'])->name('citizen.dashboard');
});

require __DIR__ . '/auth.php';
