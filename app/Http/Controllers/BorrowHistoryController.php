<?php
// app/Http/Controllers/BorrowHistoryController.php
namespace App\Http\Controllers;

use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class BorrowHistoryController extends Controller
{
    public function index()
    {
        // $userId = auth()->id();
        $userId = 1;

        $current = BorrowHistory::with(['book','copy'])
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->orderBy('due_at')
            ->get();

        $previous = BorrowHistory::with(['book','copy'])
            ->where('user_id', $userId)
            ->whereNotNull('returned_at')
            ->orderByDesc('returned_at')
            ->paginate(10);

        return view('client.borrowhistory.index', compact('current','previous'));
    }

    // app/Http/Controllers/BorrowHistoryController.php
    public function extend(BorrowHistory $borrow): RedirectResponse
    {
        // if ($borrow->user_id !== auth()->id()) abort(403);

        if ($borrow->returned_at) {
            return back()->with('error', 'This book is already returned.');
        }

        if ($borrow->extension_count >= 2) {
            return back()->with('error', 'Maximum extensions reached.');
        }

        // Do NOT change due_at here; admin will approve later.
        $borrow->update([
            'approve_status'   => 'pending',               // <-- force pending
            'extension_reason' => 'User requested',        // optional
            // keep status as-is (active/overdue). Admin will approve/reject later.
        ]);

        return back()->with('success', 'Extension request sent. Waiting for approval.');
    }

    public function cancel(BorrowHistory $borrow): RedirectResponse
    {
        // Optional check
        // if ($borrow->user_id !== auth()->id()) abort(403);

        if ($borrow->approve_status !== 'pending') {
            return back()->with('error', 'This request is not pending.');
        }

        $borrow->update([
            'approve_status' => 'rejected',
            'extension_reason' => 'User cancelled request',
        ]);

        return back()->with('success', 'Extension request cancelled.');
    }

}