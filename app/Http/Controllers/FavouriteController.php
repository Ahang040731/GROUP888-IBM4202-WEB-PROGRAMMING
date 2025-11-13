<?php

// app/Http/Controllers/FavouriteController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $account = auth()->user();             // Account model
        $user = $account->user;         // related User profile

        if (!$user) {
            // optional: handle case where account has no user profile
            abort(403, 'No user profile linked to this account.');
        }

        $userId = $user->id;            // this matches borrow_histories.user_id
        $books = Book::with([]) // eager load if needed
            ->whereHas('favouritedByUsers', fn ($q) => $q->where('user_id', $userId))
            ->orderBy('book_name')
            ->paginate(20);

        return view('client.favourites.index', compact('books'));
    }

     /** Toggle favorite / unfavorite */
    public function toggle(Book $book)
    {
        $account = auth()->user();             // Account model
        $user = $account->user;         // related User profile

        if (!$user) {
            // optional: handle case where account has no user profile
            abort(403, 'No user profile linked to this account.');
        }

        $userId = $user->id;            // this matches borrow_histories.user_id

        $exists = Favourite::where('user_id', $userId)
            ->where('book_id', $book->id)
            ->exists();

        if ($exists) {
            Favourite::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->delete();
            return back()->with('success', 'Removed from favourites.');
        } else {
            Favourite::create([
                'user_id' => $userId,
                'book_id' => $book->id,
            ]);
            return back()->with('success', 'Added to favourites.');
        }
    }
}

