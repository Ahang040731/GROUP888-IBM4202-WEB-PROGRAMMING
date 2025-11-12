<?php
// app/Http/Controllers/BorrowHistoryController.php
namespace App\Http\Controllers;

use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;

class BorrowHistoryController extends Controller
{
    public function index()
    {
        // $userId = auth()->id() ?? 1; // TODO: restore auth()->id()
        $userId = 1; // TODO: restore auth()->id()

        $current = BorrowHistory::with(['book','copy'])
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->orderBy('due_at') // soonest due first
            ->get();

        $previous = BorrowHistory::with(['book','copy'])
            ->where('user_id', $userId)
            ->whereNotNull('returned_at')
            ->orderByDesc('returned_at')
            ->paginate(10);

        return view('client.borrowhistory.index', compact('current','previous'));
    }

    public function extend(BorrowHistory $borrow): RedirectResponse
    {
        // if ($borrow->user_id !== auth()->id()) abort(403);

        if ($borrow->returned_at) {
            return back()->with('error', 'This book is already returned.');
        }

        if ($borrow->extension_count >= 2) {
            return back()->with('error', 'Maximum extensions reached.');
        }

        if ($borrow->approve_status === 'pending') {
            return back()->with('error', 'You already have a pending request.');
        }

        $borrow->update([
            'approve_status'   => 'pending',
            'extension_reason' => 'User requested',
        ]);

        return back()->with('success', 'Extension request sent. Waiting for approval.');
    }

    public function cancel(BorrowHistory $borrow): RedirectResponse
    {
        // if ($borrow->user_id !== auth()->id()) abort(403);

        if ($borrow->approve_status !== 'pending') {
            return back()->with('error', 'This request is not pending.');
        }

        $borrow->update([
            'approve_status'   => 'rejected',
            'extension_reason' => 'User cancelled request',
        ]);

        return back()->with('success', 'Extension request cancelled.');
    }
}
