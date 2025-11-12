<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinesController;

Route::middleware(['auth'])->group(function () {
    Route::get('/fines', [FinesController::class, 'index'])->name('fines.index');
    Route::post('/fines/{fine}/pay', [FinesController::class, 'pay'])->name('client.fines.pay');
});

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
Route::get('/fines', [FinesController::class, 'index'])->name('fines.index');
Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites.index');
Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
Route::post('/fines/{fine}/pay', [FinesController::class, 'pay'])->name('fines.pay');


// Redirect to borrow history route
Route::get('/client/borrowhistory', [BorrowHistoryController::class, 'index'])
    ->name('client.borrowhistory.index');

Route::post('/client/borrowhistory/{borrow}/extend', [BorrowHistoryController::class, 'extend'])
    ->name('client.borrowhistory.extend');

Route::post('/client/borrowhistory/{borrow}/cancel', [BorrowHistoryController::class, 'cancel'])
    ->name('client.borrowhistory.cancel');



Route::get('/client/profile', [ProfileController::class, 'index'])
    ->name('client.profile.index');

Route::get('/client/profile', function () {
    return view('client.profile.index');
})->name('client.profile.index');


use App\Http\Controllers\BorrowController;

Route::prefix('admin')->group(function () {
    Route::get('/borrow-management', [BorrowController::class, 'index'])->name('admin.borrows.index');
    Route::post('/borrow-management/{id}/approve', [BorrowController::class, 'approve'])->name('admin.borrows.approve');
    Route::post('/borrow-management/{id}/reject', [BorrowController::class, 'reject'])->name('admin.borrows.reject');
    Route::post('/borrow-management/{id}/mark-returned', [BorrowController::class, 'markReturned'])->name('admin.borrows.markReturned');
});

use App\Http\Controllers\AdminBookController;

Route::prefix('admin')->group(function () {
    Route::get('/books', [AdminBookController::class, 'index'])->name('admin.books.index');
    Route::get('/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [AdminBookController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{book}/edit', [AdminBookController::class, 'edit'])->name('admin.books.edit');
    Route::put('/books/{book}', [AdminBookController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])->name('admin.books.destroy');

    // BookCopy
    Route::post('/books/{book}/copies', [AdminBookController::class, 'addCopy'])->name('admin.books.copies.add');
    Route::delete('/books/copies/{copy}', [AdminBookController::class, 'deleteCopy'])->name('admin.books.copies.destroy');
    Route::post('/books/copies/{copy}/status/{status}', [AdminBookController::class, 'updateCopyStatus'])->name('admin.books.copies.status');
});

use App\Http\Controllers\AdminUserController;

Route::prefix('admin')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.usermanagement.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.usermanagement.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.usermanagement.update');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.usermanagement.toggle');
});



?>