<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    protected $fillable = [
        'name',
    ];

    /* ========================
       Relationships
    ======================== */

    // Many-to-many with books through book_authors pivot
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_authors')
                    ->withPivot(['author_order', 'role'])
                    ->withTimestamps()
                    ->orderBy('books_authors.author_order');
    }

    /* ========================
       Helpers
    ======================== */

    // Format author name (for display)
    public function getDisplayNameAttribute()
    {
        return ucwords($this->name);
    }
}