<?php

// app/Http/Controllers/FavouriteController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $userId = 1;
        // $userId = auth()->id() ?? 1; // temp for demo
        $books = Book::with([]) // eager load if needed
            ->whereHas('favouritedByUsers', fn ($q) => $q->where('user_id', $userId))
            ->orderBy('book_name')
            ->paginate(20);

        return view('client.favorites.index', compact('books'));
    }

     /** Toggle favorite / unfavorite */
    public function toggle(Book $book)
    {
        $userId = 1;
        // $userId = auth()->id() ?? 1;

        $exists = Favourite::where('user_id', $userId)
            ->where('book_id', $book->id)
            ->exists();

        if ($exists) {
            Favourite::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->delete();
            return back()->with('success', 'Removed from favorites.');
        } else {
            Favourite::create([
                'user_id' => $userId,
                'book_id' => $book->id,
            ]);
            return back()->with('success', 'Added to favorites.');
        }
    }
}

