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

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // php artisan db:seed
    public function run(): void
    {
        // Default admin account
        Account::create([
            'email' => 'admin@library.com',
            'password' => Hash::make('admin'), // hashed
            'role' => 'admin',
        ]);

        $user = Account::create([
            'email' => 'user@library.com',
            'password' => Hash::make('user'), // hashed
            'role' => 'user',
        ]);

        $borrower = $user->user()->create([
            'username'  => 'Library User',
            'phone'     => '012-3456789',
            'is_active' => true,
            'credit'    => 50.00,
            'photo'     => null,
            'address'   => 'Nilai, MY',
        ]);

        // Optional: create author if not exists
        $author = Author::firstOrCreate(
            ['name' => 'J.K. Rowling']
        );

        // Create the book
        $book = Book::create([
            'book_name' => 'The Tales of Beedle the Bard',
            'photo' => 'https://covers.openlibrary.org/b/id/0011416336-L.jpg',
            'author' => 'J.K. Rowling', // keep for display, even if you also use authors table
            'published_year' => 2008,
            'description' => "A collection of wizarding fairy tales by J.K. Rowling. It was first mentioned in Harry Potter and the Deathly Hallows and later published as a standalone book.",
            'rating' => 4.8,
            'category' => 'Fantasy',
            'total_copies' => 5,
            'available_copies' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Link the author to the book (pivot)
        BookAuthor::create([
            'book_id' => $book->id,
            'author_id' => $author->id,
            'author_order' => 1,
            'role' => 'author',
        ]);

        $book->addCopies(10, 'BEEDLE'); 

        // helper: reserve an available copy (mark not available)
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

        // 2) OVERDUE (borrowed 10 days ago, due 3 days ago)
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

        // 3) RETURNED (borrowed 14 days ago, due 7 days ago, returned 3 days ago)
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
        // returned copy goes back to available
        $copyReturned->update(['status' => 'available']);

        // refresh book copy counters
        $book->update([
            'total_copies'     => $book->copies()->count(),
            'available_copies' => $book->copies()->where('status', 'available')->count(),
        ]);

        dump([
            'users'    => \App\Models\User::count(),
            'books'    => \App\Models\Book::count(),
            'copies'   => \App\Models\BookCopy::count(),
            'borrows'  => \App\Models\BorrowHistory::count(),
            'sample'   => \App\Models\BorrowHistory::with(['user','book','copy'])->first(),
            'connection'=> config('database.default'),
            'sqlite_path'=> config('database.connections.sqlite.database'),
        ]);

        Favourite::create([
            'user_id' => $borrower->id,
            'book_id' => $book->id,
        ]);
    }
}
