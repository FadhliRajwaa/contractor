<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;

// Guest Routes (Login)
Route::middleware(['guest', 'debug.auth'])->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Authenticated Routes
Route::middleware(['auth', 'debug.auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
    
    // User Management 
    // SUPERADMIN & ADMINISTRATOR: Full user management
    Route::middleware(['role:superadmin|administrator'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('reset-password');
    });
    
    // ADMIN KONTRAKTOR: Bisa buat customer dan user kontraktor (limited)
    Route::middleware(['role:admin_kontraktor'])->prefix('contractor-users')->name('contractor.users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'contractorIndex'])->name('index');
        Route::post('/', [UserManagementController::class, 'contractorStore'])->name('store'); // customers & user_kontraktor only
    });
    
    // Customer Management (Admin Kontraktor & User Kontraktor)
    Route::middleware(['role:admin_kontraktor|user_kontraktor'])->prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        // admin_kontraktor: full CRUD, user_kontraktor: view only (controlled in controller)
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });
    
    // Project Management (Kontraktor levels)
    Route::middleware(['role:admin_kontraktor|user_kontraktor|customer'])->prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        // Create/Edit/Delete controlled in controller based on permissions
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
    });
});
