<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

// Include auth routes (Breeze) if present so login/register work
require __DIR__.'/auth.php';

// Landing page -> dashboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes for EMS
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::post('/departments/{department}/employees', [DepartmentController::class, 'addEmployee'])->name('departments.addEmployee');
    Route::delete('/departments/{department}/employees/{employee}', [DepartmentController::class, 'removeEmployee'])->name('departments.removeEmployee');
});

// Breeze / profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// auth routes removed (Breeze scaffold removed)
