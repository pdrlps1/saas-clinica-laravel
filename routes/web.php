<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

//Rotas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

//Rotas autenticadas
Route::middleware('auth')->group(function() {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('organizations', OrganizationController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('appointments', AppointmentController::class);

    Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});
