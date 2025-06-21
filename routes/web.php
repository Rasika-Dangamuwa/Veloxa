<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropagandistController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\HODController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Routes
Route::middleware(['auth'])->group(function () {
    
    // Default dashboard redirect
    Route::get('/dashboard', function () {
        return redirect(auth()->user()->getDashboardRoute());
    })->name('dashboard');

    // Propagandist Routes
    Route::prefix('propagandist')->middleware('role:propagandist')->group(function () {
        Route::get('/dashboard', [PropagandistController::class, 'dashboard'])->name('propagandist.dashboard');
        // Add more propagandist routes here
    });

    // Manager Routes
    Route::prefix('manager')->middleware('role:manager')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
        // Add more manager routes here
    });

    // HOD Routes
    Route::prefix('hod')->middleware('role:hod')->group(function () {
        Route::get('/dashboard', [HODController::class, 'dashboard'])->name('hod.dashboard');
        // Add more HOD routes here
    });

    // Warehouse Routes
    Route::prefix('warehouse')->middleware('role:warehouse')->group(function () {
        Route::get('/dashboard', [WarehouseController::class, 'dashboard'])->name('warehouse.dashboard');
        // Add more warehouse routes here
    });

    // Admin Routes
    Route::prefix('admin')->middleware('role:master_admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Add more admin routes here
    });

});