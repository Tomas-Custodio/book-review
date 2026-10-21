<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('books')->controller(BookController::class)->group(function(){

    Route::get('/','index')->name('books.index');
    Route::get('/{book}/details','details')->name('books.details')->middleware('throttle:users');

});

Route::prefix('books')->controller(BookController::class)->group(function(){

    Route::get('/books/{book}/reviews/create', [ReviewController::class, 'create'])
    ->name('books.reviews.create');

    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])
        ->name('books.reviews.store');
        
    })->middleware('throttle:users');
