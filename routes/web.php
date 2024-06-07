<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bike\BikeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserData\UserDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Główna strona
Route::get('/', function () {
    return view('welcome');
});

// Strona sklepu
Route::get('/shop', [BikeController::class, 'index'])->name('shop');

// Formularz kontaktowy
Route::get('/form', function () {
    return view('form');
})->name('form');

// Rejestracja - trasy obsługiwane przez RegisterController
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Trasy dla uwierzytelniania generowane przez Laravel (login, logout, itp.)
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Zarządzanie danymi użytkownika z zabezpieczeniem przez middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::get('user_data', [UserDataController::class, 'index'])->name('user_data.index');
    Route::post('user_data', [UserDataController::class, 'store'])->name('user_data.store');
    Route::get('user_data/{user_data}', [UserDataController::class, 'show'])->name('user_data.show');
    Route::get('user_data/{user_data}/edit', [UserDataController::class, 'edit'])->name('user_data.edit');
    Route::put('user_data/{user_data}', [UserDataController::class, 'update'])->name('user_data.update');
});

Route::get('/orders', [App\Http\Controllers\Order\OrderController::class, 'index'])
    ->middleware('auth')
    ->name('orders.index');

Route::post('/place-order', [App\Http\Controllers\Order\OrderController::class, 'store'])
    ->middleware('auth')
    ->name('place-order');

// Grupa tras dla panelu admina z zastosowaniem middleware
Route::middleware(['auth', 'admin.access'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('users.assign-role');
    Route::post('users/{user}/remove-role', [AdminController::class, 'removeRole'])->name('users.remove-role');
    Route::post('users/{user}/assign-permission', [AdminController::class, 'assignPermission'])->name('users.assign-permission');
    Route::post('users/{user}/remove-permission', [AdminController::class, 'removePermission'])->name('users.remove-permission');
});

// Endpointy dla dokumentów
Route::middleware('auth')->group(function () {
    Route::get('/documents/{documentId}/show', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{documentId?}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('/documents/store/{documentId?}', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{documentId}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::get('/documents/{documentId}/show-pdf', [DocumentController::class, 'showPdf'])->name('documents.showPdf');
});
