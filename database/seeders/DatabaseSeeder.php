<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookCopy;
use App\Models\BorrowHistory;
use App\Models\CreditTransaction;
use App\Models\Favourite;
use App\Models\Fine;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Accounts (admin & user)
        |--------------------------------------------------------------------------
        */

        // Admin account
        $adminAccount = Account::updateOrCreate(
            ['email' => 'admin@library.com'],
            [
                'password' => Hash::make('admin123'), // 🔐 CLEAR, DOCUMENTED PASSWORD
                'role'     => 'admin',
            ]
        );

        // Ensure admin profile exists/updated
        $adminAccount->admin()->updateOrCreate(
            [], // only one admin profile per account
            [
                'username' => 'System Admin',
                'phone'    => '012-0000000',
                'address'  => 'Somewhere',
                'photo'    => null,
            ]
        );

        // Normal user account
        $userAccount = Account::updateOrCreate(
            ['email' => 'user@library.com'],
            [
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );

        // Ensure user profile exists/updated
        $borrower = $userAccount->user()->updateOrCreate(
            [], // one user profile per account
            [
                'username'  => 'Library User',
                'phone'     => '012-3456789',
                'is_active' => true,
                'credit'    => 50.00,
                'photo'     => null,
                'address'   => 'Nilai, MY',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Sample author + book + copies
        |--------------------------------------------------------------------------
        */

        $author = Author::firstOrCreate(
            ['name' => 'J.K. Rowling']
        );

        $book = Book::updateOrCreate(
            ['book_name' => 'The Tales of Beedle the Bard'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/0011416336-L.jpg',
                'author'          => 'J.K. Rowling',
                'published_year'  => 2008,
                'description'     => "A collection of wizarding fairy tales by J.K. Rowling. It was first mentioned in Harry Potter and the Deathly Hallows and later published as a standalone book.",
                'rating'          => 4.8,
                'category'        => 'Fantasy',
                'total_copies'    => 5,
                'available_copies'=> 5,
            ]
        );

        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'author_order' => 1,
                'role'         => 'author',
            ]
        );

        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'BEEDLE');
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Borrow histories
        |--------------------------------------------------------------------------
        */

        // helper to reserve an available copy
        $reserveCopy = function (Book $b) {
            $copy = $b->copies()->where('status', 'available')->firstOrFail();
            $copy->update(['status' => 'not available']);
            return $copy;
        };

        // 1) ACTIVE
        $copyActive = $reserveCopy($book);
        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $book->id,
            'copy_id'          => $copyActive->id,
            'borrowed_at'      => now(),
            'due_at'           => now()->addDays(7),
            'returned_at'      => null,
            'status'           => 'active',
            'extension_count'  => 0,
            'extension_reason' => null,
            'approve_status'   => 'approved',
        ]);

        // 2) OVERDUE
        $copyOverdue = $reserveCopy($book);
        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $book->id,
            'copy_id'          => $copyOverdue->id,
            'borrowed_at'      => now()->subDays(10),
            'due_at'           => now()->subDays(3),
            'returned_at'      => null,
            'status'           => 'overdue',
            'extension_count'  => 0,
            'extension_reason' => null,
            'approve_status'   => 'approved',
        ]);

        // 3) RETURNED
        $copyReturned = $reserveCopy($book);
        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $book->id,
            'copy_id'          => $copyReturned->id,
            'borrowed_at'      => now()->subDays(14),
            'due_at'           => now()->subDays(7),
            'returned_at'      => now()->subDays(3),
            'status'           => 'returned',
            'extension_count'  => 0,
            'extension_reason' => null,
            'approve_status'   => 'approved',
        ]);
        $copyReturned->update(['status' => 'available']);

        // Refresh counters
        $book->update([
            'total_copies'     => $book->copies()->count(),
            'available_copies' => $book->copies()->where('status', 'available')->count(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Sample favourite
        |--------------------------------------------------------------------------
        */

        Favourite::updateOrCreate(
            [
                'user_id' => $borrower->id,
                'book_id' => $book->id,
            ],
            [] // no extra attributes
        );
    }
}
