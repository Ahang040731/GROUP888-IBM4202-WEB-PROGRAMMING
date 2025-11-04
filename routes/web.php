<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BorrowHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Public routes (accessible without authentication)use App\Http\Controllers\BorrowHistoryController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
// These are typically provided by Laravel Breeze, Jetstream, or manual implementation
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (require authentication)
// All these routes are only accessible when the user is logged in
// The 'auth' middleware checks if the user is authenticated
Route::middleware(['auth'])->group(function () {
    
    // Dashboard - Main discover page
    // This is the landing page after login, showing recommendations and categories
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book Routes
    // These handle all book-related functionality
    Route::prefix('books')->name('books.')->group(function () {
        
        // Explore page - Browse all books with advanced filtering
        Route::get('/explore', [BookController::class, 'explore'])->name('explore');
        
        // View a specific book's details
        // The {book} parameter is automatically resolved to a Book model instance
        Route::get('/{book}', [BookController::class, 'show'])->name('show');
        
        // Category page - Show all books in a specific category
        Route::get('/category/{slug}', [DashboardController::class, 'showCategory'])->name('category');
        
        // Recommendations page - Extended list of recommended books
        Route::get('/recommended', [BookController::class, 'recommendations'])->name('recommendations');
        
        // Recent books page - Extended list of recently added books
        Route::get('/recent', [BookController::class, 'recent'])->name('recent');
        
        // Search functionality - AJAX endpoint for live search
        Route::get('/search', [BookController::class, 'search'])->name('search');
        
        // Borrow a book - Create a borrow request
        Route::post('/{book}/borrow', [BookController::class, 'borrow'])->name('borrow');
        
        // Rate a book - Submit a rating after reading
        Route::post('/{book}/rate', [BookController::class, 'rate'])->name('rate');
    });
    
    // Library Routes
    // These handle the user's personal library and borrowing history
    Route::prefix('library')->name('library.')->group(function () {
        
        // My library overview - Currently borrowed books
        Route::get('/', [LibraryController::class, 'index'])->name('index');
        
        // Borrow history - All past and current borrows
        Route::get('/history', [LibraryController::class, 'history'])->name('history');
        
        // Return a borrowed book
        Route::post('/return/{borrowHistory}', [LibraryController::class, 'return'])->name('return');
        
        // Request extension for a borrowed book
        Route::post('/extend/{borrowHistory}', [LibraryController::class, 'extend'])->name('extend');
        
        // View and pay fines
        Route::get('/fines', [LibraryController::class, 'fines'])->name('fines');
        Route::post('/fines/{fine}/pay', [LibraryController::class, 'payFine'])->name('fines.pay');
    });
    
    // Favourites Routes
    // These handle the user's favorite/bookmarked books
    Route::prefix('favorites')->name('favorites.')->group(function () {
        
        // View all favorite books
        Route::get('/', [FavouriteController::class, 'index'])->name('index');
        
        // Add a book to favorites
        Route::post('/{book}', [FavouriteController::class, 'store'])->name('store');
        
        // Remove a book from favorites
        Route::delete('/{book}', [FavouriteController::class, 'destroy'])->name('destroy');
        
        // Check if a book is favorited (AJAX endpoint)
        Route::get('/{book}/status', [FavouriteController::class, 'status'])->name('status');
    });
    
    // Settings Routes
    // These handle user account settings and preferences
    Route::prefix('settings')->name('settings.')->group(function () {
        
        // Settings overview page
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        
        // Update profile information
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        
        // Update password
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        
        // Update notification preferences
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        
        // Credit management
        Route::get('/credit', [SettingsController::class, 'credit'])->name('credit');
        Route::post('/credit/topup', [SettingsController::class, 'topupCredit'])->name('credit.topup');
    });
    
    // Help & Support Routes
    Route::get('/help', function () {
        return view('help.index');
    })->name('help');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes (require admin role)
// These routes are only accessible to users with admin privileges
// The 'admin' middleware checks if the authenticated user is an admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Book Management
    Route::resource('books', Admin\BookController::class);
    Route::post('books/{book}/copies', [Admin\BookController::class, 'addCopies'])->name('books.copies.add');
    
    // User Management
    Route::resource('users', Admin\UserController::class);
    Route::post('users/{user}/activate', [Admin\UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{user}/deactivate', [Admin\UserController::class, 'deactivate'])->name('users.deactivate');
    
    // Borrow Management
    Route::get('borrows', [Admin\BorrowController::class, 'index'])->name('borrows.index');
    Route::post('borrows/{borrowHistory}/approve', [Admin\BorrowController::class, 'approve'])->name('borrows.approve');
    Route::post('borrows/{borrowHistory}/reject', [Admin\BorrowController::class, 'reject'])->name('borrows.reject');
    
    // Fine Management
    Route::get('fines', [Admin\FineController::class, 'index'])->name('fines.index');
    Route::post('fines/{fine}/waive', [Admin\FineController::class, 'waive'])->name('fines.waive');
    
    // Reports
    Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');
});


// Redirect to borrow history route
Route::get('/client/borrow-history', [BorrowHistoryController::class, 'index'])
    ->name('client.borrowhistory.index');