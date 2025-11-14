<?php
// app/Http/Controllers/BorrowHistoryController.php
namespace App\Http\Controllers;

use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;

class BorrowHistoryController extends Controller
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

        $current = \App\Models\BorrowHistory::with(['book', 'copy'])
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->whereNotIn('status', ['lost'])
            ->orderByDesc('borrowed_at')
            ->get();

        $previous = \App\Models\BorrowHistory::with(['book', 'copy'])
            ->where('user_id', $userId)
            ->where(function ($q) {
                $q->whereNotNull('returned_at')
                ->orWhere('status', 'lost');
            })
            ->orderByDesc('borrowed_at')
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
