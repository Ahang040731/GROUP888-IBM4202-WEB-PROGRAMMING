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
        if ($request->filled('available')) {
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
        
        // Get cart book IDs for authenticated users
        $cartBookIds = [];
        if (auth()->check() && auth()->user()->user) {
            $cartBookIds = auth()->user()->user->carts()->pluck('book_id')->toArray();
        }
        
        return view('client.book.index', compact('books', 'categories', 'cartBookIds'));
    }
    
    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load(['authors', 'copies']);
        
        // Get available copies
        $availableCopies = $book->copies()
            ->where('status', 'available')
            ->get();
        
        // Check if user has this in cart (if authenticated)
        $inCart = false;
        if (auth()->check() && auth()->user()->user) {
            $inCart = auth()->user()->user->carts()
                ->where('book_id', $book->id)
                ->exists();
        }
        
        // Check if user has favorited (if authenticated)
        $isFavorite = false;
        if (auth()->check() && auth()->user()->user) {
            $isFavorite = auth()->user()->user->favourites()
                ->where('book_id', $book->id)
                ->exists();
        }
        
        return view('client.book.show', compact(
            'book',
            'availableCopies',
            'inCart',
            'isFavorite'
        ));
    }
}