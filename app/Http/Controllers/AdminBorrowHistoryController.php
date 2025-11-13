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
                    ->paginate(10);

        return view('admin.borrowhistorymanagement.index', compact('borrows'));
    }

    // mark book as returned
    public function markReturned($id)
    {
        $borrow = BorrowHistory::findOrFail($id);
        $borrow->status = 'returned';
        $borrow->returned_at = now();
        $borrow->save();

        // Update book copy status
        $borrow->copy->update(['status' => 'available']);

        return redirect()->route('admin.borrowhistorymanagement.index')
                         ->with('success', 'Borrow record updated as returned.');
    }
}
