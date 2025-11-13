<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_name',
        'photo',
        'author',
        'published_year',
        'description',
        'rating',
        'category',
        'total_copies',
        'available_copies',
    ];

    /* ========================
       Relationships
    ======================== */

    // One book can have many copies
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

        public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors')
                    ->using(BookAuthor::class)  // tell Laravel to use your custom pivot model
                    ->withPivot(['author_order', 'role'])
                    ->withTimestamps()
                    ->orderBy('book_authors.author_order');
    }


    /* ========================
       Accessors / Helpers
    ======================== */

    public function addCopies(int $count, string $barcodePrefix = null, int $start = 1, string $status = 'available', string $condition = 'good'): void
    {
        $barcodePrefix = $barcodePrefix ?? strtoupper(preg_replace('/[^A-Z0-9]+/i', '-', $this->book_name));

        for ($i = 0; $i < $count; $i++) {
            \App\Models\BookCopy::create([
                'book_id'   => $this->id,
                'status'    => $status,
                'condition' => $condition,
                'barcode'   => $barcodePrefix . '-' . str_pad($start + $i, 3, '0', STR_PAD_LEFT),
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }

        // refresh counters
        $this->update([
            'total_copies'      => $this->copies()->count(),
            'available_copies'  => $this->copies()->where('status','available')->count(),
        ]);
    }


    // Returns true if the book still has copies to borrow
    public function isAvailable()
    {
        return $this->available_copies > 0;
    }

    // Compute rating display (rounded)
    public function getRatingAttribute($value)
    {
        return round($value, 1);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function favouritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourites', 'book_id', 'user_id');
    }

    public function getIsFavoritedAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        // Get the logged-in user's profile (from Users table)
        $userProfile = auth()->user()->user; // Account -> user() relationship

        if (!$userProfile) {
            return false;
        }

        return $this->favourites()
            ->where('user_id', $userProfile->id)   // 👈 use profile id
            ->exists();
    }
}