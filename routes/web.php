<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\Admin\AbsenceController as AdminAbsenceController;
use App\Http\Controllers\Admin\AbsenceSettingController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:employee')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [AbsenceController::class, 'index'])->name('index');
Route::post('/absence', [AbsenceController::class, 'create'])->name('absence.create');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/test', [TestController::class, 'index']);

Route::name('absence.')->prefix('absence')->group(function () {
    Route::post('/create', [AbsenceController::class, 'create'])->name('create');
});

Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
    Route::post('/authenticate', [AdminAuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(
    function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::name('user.')->prefix('user')->group(
            function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/datatables', [UserController::class, 'datatables'])->name('datatables');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
            }
        );

        Route::name('division.')->prefix('division')->group(
            function () {
                Route::get('/', [DivisionController::class, 'index'])->name('index');
                Route::get('/datatables', [DivisionController::class, 'datatables'])->name('datatables');
                Route::get('/create', [DivisionController::class, 'create'])->name('create');
                Route::post('/store', [DivisionController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [DivisionController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [DivisionController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [DivisionController::class, 'delete'])->name('delete');
            }
        );

        Route::name('employee.')->prefix('employee')->group(
            function () {
                Route::get('/', [EmployeeController::class, 'index'])->name('index');
                Route::get('/datatables', [EmployeeController::class, 'datatables'])->name('datatables');
                Route::get('/create', [EmployeeController::class, 'create'])->name('create');
                Route::post('/store', [EmployeeController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [EmployeeController::class, 'delete'])->name('delete');
            }
        );

        Route::name('absence.')->prefix('absence')->group(
            function () {
                Route::get('/', [AdminAbsenceController::class, 'index'])->name('index');
                Route::get('/datatables', [AdminAbsenceController::class, 'datatables'])->name('datatables');
                Route::get('/datatables/today', [AdminAbsenceController::class, 'datatablesToday'])->name('datatables.today');
            }
        );

        Route::name('absence-settings.')->prefix('absence-settings')->group(
            function () {
                Route::get('/', [AbsenceSettingController::class, 'index'])->name('index');
                Route::post('/update', [AbsenceSettingController::class, 'update'])->name('update');
            }
        );

    }
);