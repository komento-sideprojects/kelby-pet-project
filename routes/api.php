<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Routes
    Route::get('/dashboard', [UserController::class, 'index']);
    Route::get('/books/browse', [UserController::class, 'browse']);
    Route::post('/books/borrow', [UserController::class, 'borrow']);
    Route::get('/books/borrowed', [UserController::class, 'borrowed']);

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index']);
        Route::get('/books', [AdminController::class, 'manageBooks']);
        Route::post('/books', [AdminController::class, 'store']);
        Route::get('/students', [AdminController::class, 'getStudents']);
        Route::get('/issued-books', [AdminController::class, 'getIssuedBooks']);
    });
});
