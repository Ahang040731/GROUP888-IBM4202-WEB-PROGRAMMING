<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FinesController;
use App\Http\Controllers\BorrowHistoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminBorrowHistoryController;
use App\Http\Controllers\AdminFinesController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Login routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('client.homepage.index');
    }
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Client Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/homepage', [DashboardController::class, 'index'])->name('client.homepage.index');
    
    // Book Routes
    Route::get('/books', [BookController::class, 'index'])->name('client.books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('client.books.show');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart/{book}', [CartController::class, 'store'])->name('client.cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('client.cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('client.cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('client.cart.clear');
    
    // Borrow History
    Route::get('/borrowhistory', [BorrowHistoryController::class, 'index'])
        ->name('client.borrowhistory.index');
    Route::post('/borrowhistory/{borrow}/extend', [BorrowHistoryController::class, 'extend'])
        ->name('client.borrowhistory.extend');
    Route::post('/borrowhistory/{borrow}/cancel', [BorrowHistoryController::class, 'cancel'])
        ->name('client.borrowhistory.cancel');
    
    // Fines
    Route::get('/fines', [FinesController::class, 'index'])->name('fines.index');
    Route::post('/fines/{fine}/pay', [FinesController::class, 'pay'])->name('client.fines.pay');
    Route::post('/fines/{fine}/pay', [FinesController::class, 'pay'])->name('fines.pay');
    
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('client.favorites.index');
    Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
    
    // Profile
    Route::get('/profile', [UserProfileController::class, 'show'])->name('client.profile.index');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('client.profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Admin Homepage
    Route::get('/homepage', function() {
        return view('admin.homepage');
    })->name('admin.homepage');
    
    // Borrow Management
    Route::get('/borrow-management', [BorrowController::class, 'index'])->name('admin.borrows.index');
    Route::post('/borrow-management/{id}/approve', [BorrowController::class, 'approve'])->name('admin.borrows.approve');
    Route::post('/borrow-management/{id}/reject', [BorrowController::class, 'reject'])->name('admin.borrows.reject');
    Route::post('/borrow-management/{id}/mark-returned', [BorrowController::class, 'markReturned'])->name('admin.borrows.markReturned');
    
    // Book Management
    Route::get('/books', [AdminBookController::class, 'index'])->name('admin.books.index');
    Route::get('/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [AdminBookController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{book}/edit', [AdminBookController::class, 'edit'])->name('admin.books.edit');
    Route::put('/books/{book}', [AdminBookController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])->name('admin.books.destroy');
    
    // BookCopy Management
    Route::post('/books/{book}/copies', [AdminBookController::class, 'addCopy'])->name('admin.books.copies.add');
    Route::delete('/books/copies/{copy}', [AdminBookController::class, 'deleteCopy'])->name('admin.books.copies.destroy');
    Route::post('/books/copies/{copy}/status/{status}', [AdminBookController::class, 'updateCopyStatus'])->name('admin.books.copies.status');
    
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.usermanagement.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.usermanagement.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.usermanagement.update');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.usermanagement.toggle');
    
    // Borrow History Management
    Route::get('/borrow-history', [AdminBorrowHistoryController::class, 'index'])
        ->name('admin.borrowhistorymanagement.index');
    Route::post('/borrow-history/{borrow}/mark-returned', [AdminBorrowHistoryController::class, 'markReturned'])
        ->name('admin.borrowhistorymanagement.markReturned');
    
    // Fines Management
    Route::get('/finesmanagement', [AdminFinesController::class, 'index'])->name('admin.fines.index');
    
    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});