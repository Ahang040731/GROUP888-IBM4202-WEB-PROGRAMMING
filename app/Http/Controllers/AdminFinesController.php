<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\BorrowHistory;
use App\Models\Fine;

class AdminFinesController extends Controller
{
    public function index()
    {
        $users = User::count();
        $books = Book::count();
        $borrowings = BorrowHistory::count();
        $fines = Fine::count();

        return view('admin.fines.index', compact('users', 'books', 'borrowings', 'fines'));
    }
}
?>