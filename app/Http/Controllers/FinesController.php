<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinesController extends Controller
{
    public function index()
    {
        $account = auth()->user();  // Account model (accounts table)

        if (!$account || !$account->user) {
            abort(403, 'No user profile linked to this account.');
        }

        $user   = $account->user;     // user profile (users table)
        $userId = $user->id;          // matches fines.user_id & borrow_history.user_id

        /*
        |------------------------------------------------------------------
        | 1) Auto-generate fines for overdue borrows with no fine yet
        |    (book NOT returned yet → use today vs due_at)
        |------------------------------------------------------------------
        */

        $overdueBorrows = BorrowHistory::where('user_id', $userId)
            ->whereNull('returned_at')
            ->whereNotNull('due_at')
            ->where('due_at', '<', Carbon::now())    // ✅ use Carbon, not Symfony now()
            ->whereDoesntHave('fine')               // assumes BorrowHistory::fine() relation
            ->get();

        foreach ($overdueBorrows as $borrow) {

            $dueDate = Carbon::parse($borrow->due_at);
            $today   = Carbon::now();

            // days from due date until today (absolute)
            $daysLate = $borrow->late_days;  // <- use accessor

            if ($daysLate <= 0) {
                continue;
            }

            // fine rule: base RM5 + RM2 per late day
            $baseFine      = 5.00;
            $latePerDay    = 2.00;
            $fineAmount    = $baseFine + ($daysLate * $latePerDay);
            $fineAmount    = round($fineAmount, 2);   // ensure 2 decimals

            $fine = Fine::where('borrowing_id', $borrow->id)->first();

            if ($fine && $fine->status !== 'unpaid') {
                continue;
            }
            
            Fine::updateOrCreate(
            [
                'borrowing_id' => $borrow->id,   // UNIQUE per borrow
                'user_id'      => $userId,
            ],
            [
                'reason' => 'late',
                'amount' => $fineAmount,         // <-- update amount daily
                'status' => 'unpaid',            // <-- still unpaid
            ]);
        }

        /*
        |------------------------------------------------------------------
        | 2) Load unpaid + pending (current)
        |------------------------------------------------------------------
        */

        $current = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->whereIn('status', ['unpaid', 'pending'])
            ->orderBy('created_at')
            ->get();

        /*
        |------------------------------------------------------------------
        | 3) Load paid/waived/reversed (previous)
        |------------------------------------------------------------------
        */

        $previous = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->whereIn('status', ['paid', 'waived', 'reversed'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('client.fines.index', compact('current', 'previous'));
    }

    public function pay(Fine $fine, Request $request): RedirectResponse
    {
        $account = auth()->user();

        if (!$account || !$account->user) {
            abort(403, 'No user profile linked to this account.');
        }

        $user = $account->user;

        // Make sure the fine belongs to this user
        if ($fine->user_id !== $user->id) {
            abort(403);
        }

        // ❗ block payment if book not returned
        if ($fine->borrowHistory && $fine->borrowHistory->returned_at === null) {
            return back()->with('error', 'You must return the book before paying the fine.');
        }

        if ($fine->status !== 'unpaid') {
            return back()->with('error', 'This fine is already being processed or completed.');
        }

        $method = $request->input('method', 'cash');

        $fine->update([
            'status'          => 'pending',
            'method'          => $method,
            'transaction_ref' => 'REQ-' . $fine->id . '-' . time(),
        ]);

        return back()->with('success', 'Your payment request has been sent to admin for approval.');
    }
}
