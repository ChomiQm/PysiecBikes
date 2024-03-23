<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bike\BikeController;
use App\Http\Controllers\UserData\UserDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Główna strona
Route::get('/', function () {
    return view('welcome');
});

// Strona sklepu
Route::get('/shop', [BikeController::class, 'index'])->name('shop');

// Formularz (jakiegoś rodzaju, np. kontaktowy)
Route::get('/form', function () {
    return view('form');
})->name('form');

// Rejestracja - trasy obsługiwane przez RegisterController
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
// Zarządzanie danymi użytkownika
Route::resource('user_data', UserDataController::class);

// Trasy dla uwierzytelniania generowane przez Laravel (login, logout, itp.)
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

