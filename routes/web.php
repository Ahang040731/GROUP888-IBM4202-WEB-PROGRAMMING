<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::post('/logout', function () {
    // Just redirect for now
    return redirect('/');
})->name('logout');

Route::post('/dashboard', function () {
    // Just redirect for now
    return redirect('/');
})->name('dashboard');

Route::post('/books.index', function () {
    // Just redirect for now
    return redirect('/');
})->name('books.index');

Route::post('/', function () {
    // Just redirect for now
    return redirect('/');
})->name('');
