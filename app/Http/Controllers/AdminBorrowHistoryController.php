<?php

namespace App\Http\Controllers;

use App\Models\BorrowHistory;
use Illuminate\Http\Request;

class AdminBorrowHistoryController extends Controller
{
    // show all book history
    public function index()
    {
        // eager load user book and copy
        $borrows = BorrowHistory::with(['user', 'book', 'copy'])
                    ->orderBy('borrowed_at', 'desc')
                    ->paginate(25);

        return view('admin.borrowhistorymanagement.index', compact('borrows'));
    }
}
