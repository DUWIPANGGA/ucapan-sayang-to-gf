<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValentineController;

Route::get('/', [ValentineController::class, 'index'])->name('valentine.index');
