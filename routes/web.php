<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('books')->controller(BookController::class)->group(function(){

    Route::get('/','index')->name('books.index');
    Route::get('/details','index')->name('books.show');

});
