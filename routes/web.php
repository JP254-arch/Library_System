<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Book Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

/*
|--------------------------------------------------------------------------
| Librarian / Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:librarian|admin'])->group(function () {
    Route::resource('books', BookController::class)->except(['show']);
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manage Users
    Route::get('/admin/users', [UserController::class, 'manage'])->name('users.manage');
    Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Loan Management
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::patch('/loans/{loan}/return', [LoanController::class, 'markReturned'])->name('loans.return');
});

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/books/{book}/borrow', [LoanController::class, 'borrow'])->name('loans.borrow');
    Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('loans.my');
});
