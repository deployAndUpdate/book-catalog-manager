<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

Route::resource('books', BookController::class);
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

