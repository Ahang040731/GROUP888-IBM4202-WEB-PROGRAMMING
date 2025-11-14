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
        $userAccount->user()->updateOrCreate(
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
        $userAccount->user()->updateOrCreate(
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


        // Book 8
        $author = Author::firstOrCreate(
            ['name' => 'R. A. Salvatore']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'The Crystal Shard'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/6621650-L.jpg',
                'author'          => 'R. A. Salvatore',
                'published_year'  => 1988,
                'description'     => "A dark-elf ranger, a dwarf king, a barbarian warrior and a halfling join forces to protect the frozen lands of Icewind Dale against a wizard wielding the evil Crystal Shard, setting in motion a legendary battle of power and identity.",
                'rating'          => 3.8,
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
            $book->addCopies(10 - $book->copies()->count(), 'TCS');
        }


        // Book 9
        $author = Author::firstOrCreate(
            ['name' => 'R. A. Salvatore']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Attack of the Clones'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/10932597-L.jpg',
                'author'          => 'R. A. Salvatore',
                'published_year'  => 2002,
                'description'     => "A galaxy on the brink of war, Jedi-Knight Anakin Skywalker and his master Obi-Wan Kenobi must protect Senator Padmé Amidala while uncovering a sinister separatist plot and an army of clones rising for battle.",
                'rating'          => 4.0,
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
            $book->addCopies(10 - $book->copies()->count(), 'SWEIIOC');
        }


        // Book 10
        $author = Author::firstOrCreate(
            ['name' => 'R. A. Salvatore']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Exile'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/9508006-L.jpg',
                'author'          => 'R. A. Salvatore',
                'published_year'  => 1999,
                'description'     => "A troubled dark-elf ranger in the The Crystal Shard era must abandon his homeland and face exile while forging an unlikely alliance to survive threats in the savage Underdark and beyond.",
                'rating'          => 3.9,
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
            $book->addCopies(10 - $book->copies()->count(), 'E');
        }

        // Book 11
        $author = Author::firstOrCreate(
            ['name' => 'J. K. Rowling']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Harry Potter and the Sorcerer\'s Stone'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/15124822-L.jpg',
                'author'          => 'J. K. Rowling',
                'published_year'  => 2016,
                'description'     => "A young boy discovers he is a wizard, enters the magical world of Hogwarts, and confronts the dark forces behind his past.",
                'rating'          => 4.2,
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
            $book->addCopies(10 - $book->copies()->count(), 'HPSS');
        }


        // Book 12
        $author = Author::firstOrCreate(
            ['name' => 'J. K. Rowling']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Harry Potter and the Chamber of Secrets'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/15095437-L.jpg',
                'author'          => 'J. K. Rowling',
                'published_year'  => 1999,
                'description'     => "Harry returns to Hogwarts for his second year only to find the castle under threat as the Chamber of Secrets has been opened and Muggle-born students are being petrified.",
                'rating'          => 4.2,
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
            $book->addCopies(10 - $book->copies()->count(), 'HPTCOS');
        }


        // Book 13
        $author = Author::firstOrCreate(
            ['name' => 'J. K. Rowling']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Harry Potter and the Prisoner of Azkaban'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/14852024-L.jpg',
                'author'          => 'J. K. Rowling',
                'published_year'  => 2007,
                'description'     => "Harry returns for his third year at Hogwarts, where the escape of the prisoner Sirius Black sets off a chain of chilling revelations and dark secrets.",
                'rating'          => 4.2,
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
            $book->addCopies(10 - $book->copies()->count(), 'HPTPOA');
        }


        // Book 14
        $author = Author::firstOrCreate(
            ['name' => 'J. K. Rowling']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'Harry Potter and The Goblet of Fire 4'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/15096178-L.jpg',
                'author'          => 'J. K. Rowling',
                'published_year'  => 2014,
                'description'     => "",
                'rating'          => 4.3,
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
            $book->addCopies(10 - $book->copies()->count(), 'HPTGF4');
        }


        // Book 15
        $author = Author::firstOrCreate(
            ['name' => 'Amal El-Mohtar']
        );
        $book = Book::updateOrCreate(
            ['book_name' => 'The Long List Anthology : More Stories from the Hugo Awards Nomination List'],
            [
                'photo'           => 'https://covers.openlibrary.org/b/id/10833647-L.jpg',
                'author'          => 'A curated collection of 21 speculative-fiction tales that appeared on the longer nomination list for the Hugo Awards, offering sci-fi, fantasy and horror from global voices.',
                'published_year'  => 2015,
                'description'     => "Amal El-Mohtar",
                'rating'          => 4.0,
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
            $book->addCopies(10 - $book->copies()->count(), 'TLLAMSFTHANQ');
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Borrow histories (Different books & statuses)
        |--------------------------------------------------------------------------
        */

        // Helper to reserve an available copy
        $reserveCopy = function (Book $b) {
            $copy = $b->copies()->where('status', 'available')->firstOrFail();
            $copy->update(['status' => 'not available']);
            return $copy;
        };

        /*
        |--------------------------------------------------------------------------
        | 1) ACTIVE (Currently Borrowing)
        |--------------------------------------------------------------------------
        | Book: WINNIE-THE-POOH
        */
        $bookActive = Book::where('book_name', 'Winnie-the-Pooh')->first();
        $copyActive = $reserveCopy($bookActive);

        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $bookActive->id,
            'copy_id'          => $copyActive->id,
            'borrowed_at'      => now(),
            'due_at'           => now()->addDays(7),
            'returned_at'      => null,
            'status'           => 'active',
            'extension_count'  => 0,
            'approve_status'   => 'approved',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2) OVERDUE (Overdue Borrow) #1
        |--------------------------------------------------------------------------
        | Book: DEMIAN
        */
        $bookOverdue1 = Book::where('book_name', 'Demian')->first();
        $copyOverdue1 = $reserveCopy($bookOverdue1);

        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $bookOverdue1->id,
            'copy_id'          => $copyOverdue1->id,
            'borrowed_at'      => now()->subDays(14),
            'due_at'           => now()->subDays(5),
            'returned_at'      => null,
            'status'           => 'overdue',
            'extension_count'  => 0,
            'approve_status'   => 'approved',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 3) OVERDUE (Overdue Borrow) #2
        |--------------------------------------------------------------------------
        | Book: ROOTS
        */
        $bookOverdue2 = Book::where('book_name', 'Roots')->first();
        $copyOverdue2 = $reserveCopy($bookOverdue2);

        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $bookOverdue2->id,
            'copy_id'          => $copyOverdue2->id,
            'borrowed_at'      => now()->subDays(20),
            'due_at'           => now()->subDays(10),
            'returned_at'      => null,
            'status'           => 'overdue',
            'extension_count'  => 0,
            'approve_status'   => 'approved',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 4) MISSING / LOST BOOK
        |--------------------------------------------------------------------------
        | Book: THE CRYSTAL SHARD
        |--------------------------------------------------------------------------
        | returned_at = null
        | status      = 'lost'
        |--------------------------------------------------------------------------
        */
        $bookLost = Book::where('book_name', 'The Crystal Shard')->first();
        $copyLost = $reserveCopy($bookLost);

        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $bookLost->id,
            'copy_id'          => $copyLost->id,
            'borrowed_at'      => now()->subDays(30),
            'due_at'           => now()->subDays(20),
            'returned_at'      => null,
            'status'           => 'lost',   // ← your new status
            'extension_count'  => 0,
            'approve_status'   => 'approved',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 5) RETURNED
        |--------------------------------------------------------------------------
        | Book: THE CIRCULAR STAIRCASE
        |--------------------------------------------------------------------------
        */
        $bookReturned = Book::where('book_name', 'The Circular Staircase')->first();
        $copyReturned = $reserveCopy($bookReturned);

        BorrowHistory::create([
            'user_id'          => $borrower->id,
            'book_id'          => $bookReturned->id,
            'copy_id'          => $copyReturned->id,
            'borrowed_at'      => now()->subDays(14),
            'due_at'           => now()->subDays(7),
            'returned_at'      => now()->subDays(2),
            'status'           => 'returned',
            'extension_count'  => 0,
            'approve_status'   => 'approved',
        ]);
        $copyReturned->update(['status' => 'available']);


        // Refresh all counters
        Book::all()->each(function($book) {
            $book->update([
                'total_copies'     => $book->copies()->count(),
                'available_copies' => $book->copies()->where('status', 'available')->count(),
            ]);
        });

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
