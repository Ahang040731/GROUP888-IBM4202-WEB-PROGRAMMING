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

        // Super Admin
        $adminAccount = Account::updateOrCreate(
            ['email' => 'superadmin@library.com'],
            [
                'password' => Hash::make('superadmin123'),
                'role'     => 'admin',
            ]
        );
        $adminAccount->admin()->updateOrCreate(
            ['account_id' => $adminAccount->id],
            [
                'username' => 'System Admin',
                'phone'    => '050-02222000',
                'address'  => 'Somewhere',
                'photo'    => null,
            ]
        );

        // Admin 1
        $adminAccount = Account::updateOrCreate(
            ['email' => 'admin@library.com'],
            [
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );
        $adminAccount->admin()->updateOrCreate(
            ['account_id' => $adminAccount->id],
            [
                'username' => 'System Admin',
                'phone'    => '012-0000000',
                'address'  => 'Somewhere',
                'photo'    => null,
            ]
        );

        
        // User 1
        $userAccount = Account::updateOrCreate(
            ['email' => 'user@library.com'],
            [
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
        $borrower = $userAccount->user()->updateOrCreate(
            ['account_id' => $userAccount->id],
            [
                'username'  => 'Library User',
                'phone'     => '012-3456789',
                'is_active' => true,
                'credit'    => 50.00,
                'photo'     => null,
                'address'   => 'Nilai, MY',
            ]
        );

        // User 2
        $userAccount = Account::updateOrCreate(
            ['email' => 'user1@library.com'],
            [
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
        $borrower = $userAccount->user()->updateOrCreate(
            ['account_id' => $userAccount->id],
            [
                'username'  => 'Library User',
                'phone'     => '012-3456789',
                'is_active' => true,
                'credit'    => 50.00,
                'photo'     => null,
                'address'   => 'Nilai, MY',
            ]
        );

        // User 3
        $userAccount = Account::updateOrCreate(
            ['email' => 'user2@library.com'],
            [
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
        $borrower = $userAccount->user()->updateOrCreate(
            ['account_id' => $userAccount->id],
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

        // Book 1
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
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'BEEDLE');
        }

        
        // Book 2
        $author = Author::firstOrCreate(
            ['name' => ' Amal El-Mohtar']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'This Is How You Lose the Time War'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/9255920-L.jpg',
                'author'          => 'Amal El-Mohtar',
                'published_year'  => 2019,
                'description'     => "A lyrical time-travel novella following two rival agents who begin exchanging secret letters across timelines, slowly forming a forbidden bond. A mix of science fiction and romance written in poetic style.",
                'rating'          => 4.1,
                'category'        => 'Science Fiction',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'THYLTW');
        }

        // Book 3
        $author = Author::firstOrCreate(
            ['name' => 'A. A. Milne']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Winnie-the-Pooh'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/12747975-L.jpg',
                'author'          => 'A. A. Milne',
                'published_year'  => 2022,
                'description'     => "A collection of whimsical stories about Pooh Bear and his friends in the Hundred Acre Wood, full of gentle humour and friendship.",
                'rating'          => 4.2,
                'category'        => 'Children’s Fiction',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'WTP');
        }


        // Book 4
        $author = Author::firstOrCreate(
            ['name' => 'Mary Roberts Rinehart']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'The Circular Staircase'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/14634166-L.jpg',
                'author'          => 'Mary Roberts Rinehart',
                'published_year'  => 2024,
                'description'     => "A wealthy spinster renting a country house becomes entangled in mysterious noises, a ghostly warning and a murder at the titular circular staircase.",
                'rating'          => 4.3,
                'category'        => 'Mystery',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'MRR');
        }


        // Book 5
        $author = Author::firstOrCreate(
            ['name' => 'Oliver Goldsmith']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'She Stoops to Conquer'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/14634296-L.jpg',
                'author'          => 'Oliver Goldsmith',
                'published_year'  => 2022,
                'description'     => "A spirited comedic tale in which mistaken identities and unexpected guest-mistakes lead to marriage misunderstandings and social satire.",
                'rating'          => 5.0,
                'category'        => 'Classic Comedy',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'SSTC');
        }


        // Book 6
        $author = Author::firstOrCreate(
            ['name' => 'Hermann Hesse']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Demian'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/15116234-L.jpg',
                'author'          => 'Hermann Hesse',
                'published_year'  => 2010,
                'description'     => "A novel about personal growth and self-discovery as Emil Sinclair encounters the mysterious Max Demian and is drawn into a deeper truth about good and evil.",
                'rating'          => 4.2,
                'category'        => 'Bildungsroman',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'D');
        }


        // Book 7
        $author = Author::firstOrCreate(
            ['name' => 'Alex Haley']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Roots'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/12632735-L.jpg',
                'author'          => 'Alex Haley',
                'published_year'  => 2007,
                'description'     => "A gripping epic tracing the journey of Kunta Kinte from eighteenth-century Africa into slavery in America and the subsequent generations of his family.",
                'rating'          => 4.6,
                'category'        => 'Historical Fiction',
                'total_copies'    => 0,
                'available_copies'=> 0,
            ]
        );
        // Link the author to the book (pivot)
        BookAuthor::updateOrCreate(
            [
                'book_id'   => $book->id,
                'author_id' => $author->id,
            ],
            [
                'role' => 'author',
            ]
        );
        // Ensure at least 10 copies exist
        if ($book->copies()->count() < 70) {
            $book->addCopies(10 - $book->copies()->count(), 'R');
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
