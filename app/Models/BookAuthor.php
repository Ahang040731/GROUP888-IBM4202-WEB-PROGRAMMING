<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class BookAuthor extends Pivot
{
    protected $table = 'book_authors';

    protected $fillable = [
        'book_id',
        'author_id',
        'author_order',
        'role',
    ];

    /* ========================
       Auto set author_order
    ======================== */
    protected static function booted()
    {
        static::creating(function (BookAuthor $bookAuthor) {
            // If author_order is already set, don't touch it
            if (!empty($bookAuthor->author_order)) {
                return;
            }

            // Find current max(author_order) for this book
            $maxOrder = static::where('book_id', $bookAuthor->book_id)
                ->max('author_order');

            // If null, start at 1
            $bookAuthor->author_order = ($maxOrder ?? 0) + 1;
        });
    }

    /* ========================
       Relationships
    ======================== */

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
