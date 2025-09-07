<?php

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\DepartmentsController;
use App\Http\Controllers\AdminControllers\PermissionsController;
use App\Http\Controllers\AdminControllers\RequestsController;
use App\Http\Controllers\AdminControllers\RolesController;
use App\Http\Controllers\AdminControllers\ServicesController;
use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\CitizenControllers\CitizenController;
use App\Http\Controllers\CitizenControllers\ComplaintsController;
use App\Http\Controllers\CitizenControllers\TradeController;
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
    Route::resource('services', ServicesController::class);
    Route::resource('/requests', RequestsController::class);
    Route::get('/requests/{id}/employees', [RequestsController::class, 'getEmployees'])->name('requests.employees');
    Route::post('/requests/{id}/assign', [RequestsController::class, 'assign'])->name('requests.assign');

    Route::get('/roles', [RolesController::class, 'getRoles'])->name('roles');
    Route::get('/departments', [DepartmentsController::class, 'getDepartments'])->name('departments');

});

// Employee Dashboard
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
    Route::get('/requests', [\App\Http\Controllers\EmployeeControllers\RequestsController::class, 'index'])->name('requests.index');
    Route::get('/complaints', [\App\Http\Controllers\EmployeeControllers\ComplaintsController::class, 'index'])->name('complaints.index');
    Route::put('/complaints/{complaint}', [\App\Http\Controllers\EmployeeControllers\ComplaintsController::class, 'update'])->name('complaints.update');
    Route::get('/trades', [\App\Http\Controllers\EmployeeControllers\TradeController::class, 'index'])->name('trades.index');
    Route::get('/trades/{id}', [\App\Http\Controllers\EmployeeControllers\TradeController::class, 'show'])->name('trades.show');

    Route::put('/requests/{id}/status', [\App\Http\Controllers\EmployeeControllers\RequestsController::class, 'updateStatus'])->name('requests.updateStatus');


});

// Citizen Dashboard
Route::prefix('citizen')->name('citizen.')->middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/dashboard', [CitizenController::class, 'index'])->name('dashboard');
    Route::get('/getDepartmentsList', [CitizenController::class, 'getDepartmentsList'])->name('getDepartmentsList');
    Route::get('/getDepartmentServices/{id}', [CitizenController::class, 'getDepartmentServices'])->name('getDepartmentServices');
    Route::resource('requests', \App\Http\Controllers\CitizenControllers\RequestsController::class);
    Route::resource('complaints', ComplaintsController::class);
    Route::get('trades/{id}', [TradeController::class, 'show'])->name('trades.show');

});

require __DIR__ . '/auth.php';
