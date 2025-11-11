<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowHistoryController;

Route::get('/', function () {
    return view('client.homepage.index');
});

//Route::view('/login', 'LOGIN.login')->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/favorites/{book}/toggle', [FavouriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});

Route::get('/login', function () {
    return view('LOGIN.login');
})->name('login');


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

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/client/homepage/index', [DashboardController::class, 'index'])->name('client.homepage.index');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/borrowed', [BookController::class, 'borrowed'])->name('borrowed.index');
Route::get('/returned', [BookController::class, 'returned'])->name('returned.index');
Route::get('/fines', [BookController::class, 'fines'])->name('fines.index');
Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites.index');
Route::get('/profile', [DashboardController::class, 'showProfile'])->name('profile.show');
Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');



// Redirect to borrow history route
Route::get('/client/borrowhistory', [BorrowHistoryController::class, 'index'])
    ->name('client.borrowhistory.index');

Route::post('/client/borrowhistory/{borrow}/extend', [BorrowHistoryController::class, 'extend'])
    ->name('client.borrowhistory.extend');

Route::post('/client/borrowhistory/{borrow}/cancel', [BorrowHistoryController::class, 'cancel'])
    ->name('client.borrowhistory.cancel');

?>