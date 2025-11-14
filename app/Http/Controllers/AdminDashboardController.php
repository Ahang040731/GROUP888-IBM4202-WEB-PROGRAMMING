<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\BorrowHistory;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalBooks = Book::count();
        $totalUsers = User::where('is_active', 1)->count();
        $borrowedBooks = BorrowHistory::whereNull('returned_at')->count(); // adjust to your column

        // Books list for the grid
        $books = Book::paginate(12);

        return view('admin.homepage', compact(
            'totalBooks',
            'totalUsers',
            'borrowedBooks'
        ));
    }
}

