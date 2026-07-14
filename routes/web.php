<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminValentineController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('admin.index');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminValentineController::class, 'index'])->name('index');
    Route::get('/create', [AdminValentineController::class, 'create'])->name('create');
    Route::post('/', [AdminValentineController::class, 'store'])->name('store');
    Route::get('/{valentine}/edit', [AdminValentineController::class, 'edit'])->name('edit');
    Route::put('/{valentine}', [AdminValentineController::class, 'update'])->name('update');
    Route::delete('/{valentine}', [AdminValentineController::class, 'destroy'])->name('destroy');
});

// Public page - must be last
Route::get('/{slug}', [AdminValentineController::class, 'showPublic'])->name('valentine.show');
