<?php

use Domain\Auth\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('login', [LoginController::class, 'index'])->name('admin.login');
Route::post('login', [LoginController::class, 'store'])->name('admin.login:post');

Route::get('dashboard', function () {
    return 'dash';
});
