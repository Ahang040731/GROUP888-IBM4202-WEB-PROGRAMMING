<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowHistory;
use App\Models\Favourite;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Get authenticated account
        $account = auth()->user();
        
        if (!$account) {
            abort(403, 'Please log in first.');
        }

        // Get user profile
        $user = $account->user ?? $account->ensureUserProfile();
        
        if (!$user) {
            abort(403, 'No user profile linked to this account.');
        }

        $userId = $user->id;

        // Build query for books
        $query = Book::query();

        // Search by name, author, or description
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

        // Sort options
        $sortBy = $request->get('sort', 'newest');
        
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'title':
                $query->orderBy('book_name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get paginated results
        $books = $query->paginate(12)->withQueryString();
        
        // Get favorited book IDs for current user
        $favoritedBookIds = Favourite::where('user_id', $userId)
            ->pluck('book_id')
            ->toArray();
        
        // Mark which books are favorited by this user
        foreach ($books as $book) {
            $book->is_favorited = in_array($book->id, $favoritedBookIds);
        }

        // Get statistics
        $totalBooks = Book::count();
        
        // Currently borrowed books (active or overdue, not returned)
        $borrowedCount = BorrowHistory::where('user_id', $userId)
            ->whereNull('returned_at')
            ->whereIn('status', ['active', 'overdue'])
            ->where('approve_status', 'approved')
            ->count();
        
        // Favorites count
        $favoritesCount = Favourite::where('user_id', $userId)->count();
        
        // User credit - THIS WAS MISSING!
        $userCredit = $user->credit ?? 0;

        return view('client.homepage.index', compact(
            'books',
            'totalBooks',
            'borrowedCount',
            'favoritesCount',
            'userCredit'
        ));
    }
}