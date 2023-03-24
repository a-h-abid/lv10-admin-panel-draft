<?php

use Domain\Auth\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('login', [LoginController::class, 'index'])->name('abdadmin.login');
Route::post('login', [LoginController::class, 'store'])->name('abdadmin.login:post');

Route::get('dashboard', function () {
    return 'dash';
});
