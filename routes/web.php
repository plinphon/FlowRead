<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);
});

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('/update-username', [UserController::class, 'update_username'])
    ->middleware('auth')
    ->name('update.username');


Route::middleware('auth')->group(function () {

    Route::get('/', [BookController::class, 'indexUI'])->name('books.list');
    Route::get('/user', [BookController::class, 'userUI'])->name('books.userList');
    Route::get('/reservations', [BookController::class, 'userReservationUI'])->name('books.userReservations');

    Route::get('/books/create', [BookController::class, 'createUI'])->name('books.createUI'); 
    Route::get('/books/{id}/edit', [BookController::class, 'editUI'])->name('books.editUI');

    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books', [BookController::class, 'create'])->name('books.create');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.delete');

    //reservation
    Route::get('/books/{book_id}/reservations', [ReservationController::class, 'list'])
        ->name('reservations.listUI');

    Route::get('/books/{book_id}/reservations/create', [ReservationController::class, 'createUI'])
        ->name('reservations.createUI');

    Route::post('/books/{book_id}/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    Route::put('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])
        ->name('reservations.updateStatus');

    //review
    Route::get('/books/{book_id}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::post('/reservations/{reservation}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reservations/{reservation}/review/create', [ReviewController::class, 'create'])->name('reviews.create');
});
