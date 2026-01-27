<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Your first Laravel route!
Route::get('/books', function () {
    return view('books.index');
});
