<?php

use Domain\Auth\Http\Controllers\LoginController;
use Domain\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('login', [LoginController::class, 'index'])->name('abdadmin.login');
Route::post('login', [LoginController::class, 'store'])->name('abdadmin.login:post');

Route::get('dashboard', [DashboardController::class, 'index'])->name('abdadmin.dashboard');
