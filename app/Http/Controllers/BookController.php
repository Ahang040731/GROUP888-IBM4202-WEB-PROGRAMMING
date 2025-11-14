<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request): View
    {
        $query = Book::with(['authors', 'copies']);

        // Search by name or author
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('book_name', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by availability
        if ($request->filled('available') && $request->available == '1') {
            $query->where('available_copies', '>', 0);
        }

        // Sort options
        $sortBy = $request->get('sort', 'book_name');
        $sortOrder = $request->get('order', 'asc');
        
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'year':
                $query->orderBy('published_year', $sortOrder);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('book_name', $sortOrder);
        }

        $books = $query->paginate(12)->withQueryString();
        
        // Get all categories for filter
        $categories = Book::distinct('category')
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Get user's cart book IDs
        $cartBookIds = auth()->user()->user->carts()->pluck('book_id')->toArray();

        return view('client.book.index', compact('books', 'categories', 'cartBookIds'));
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load(['authors', 'copies']);
        
        // Get available copies (limited to 10 for display)
        $availableCopies = $book->copies()
            ->where('status', 'available')
            ->limit(10)
            ->get();

        // Get total count of available copies
        $totalAvailableCopies = $book->copies()
            ->where('status', 'available')
            ->count();

        // Check if user has this in cart
        $cartItem = auth()->user()->user->carts()
            ->where('book_id', $book->id)
            ->first();

        // Check if user has favorited
        $isFavorite = auth()->user()->user->favourites()
            ->where('book_id', $book->id)
            ->exists();

        return view('client.book.show', compact(
            'book',
            'availableCopies',
            'totalAvailableCopies',
            'cartItem',
            'isFavorite'
        ));
    }
}