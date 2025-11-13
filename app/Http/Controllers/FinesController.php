<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\CreditTransaction;
use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        |------------------------------------------------------------------
        */

        $overdueBorrows = BorrowHistory::where('user_id', $userId)
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->whereDoesntHave('fine')      // uses BorrowHistory::fine()
            ->get();

        foreach ($overdueBorrows as $borrow) {
            // use accessor from BorrowHistory (we’ll fix it below)
            $lateDays = $borrow->late_days;
            $ratePerDay = config('library.fine_per_day', 1.00);
            $amount = max(0, $lateDays * $ratePerDay);

            // if somehow not late or 0 amount, skip
            if ($amount <= 0) {
                continue;
            }

            Fine::create([
                'user_id'      => $userId,
                'borrowing_id' => $borrow->id, // ✅ matches migration + model
                'reason'       => 'late',      // ✅ valid enum: late | lost | damage | activate | manual
                'amount'       => $amount,
                'status'       => 'unpaid',
            ]);
        }

        /*
        |------------------------------------------------------------------
        | 2) Load unpaid fines (current)
        |------------------------------------------------------------------
        */

        $current = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
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

        $user = $account->user;  // User profile (has credit column)

        // Ensure the fine belongs to this user
        if ($fine->user_id !== $user->id) {
            abort(403);
        }

        // Only unpaid fines can be paid
        if ($fine->status !== 'unpaid') {
            return back()->with('error', 'This fine has already been processed.');
        }

        // Get payment method (default credit)
        $method = $request->input('method', 'credit');

        // Handle credit payment
        if ($method === 'credit') {
            if ($user->credit < $fine->amount) {
                return back()->with('error', 'Insufficient credit to pay this fine.');
            }

            // Deduct user credit
            $user->decrement('credit', $fine->amount);

            // Record credit transaction
            CreditTransaction::create([
                'user_id'   => $user->id,
                'delta'     => -$fine->amount,
                'reason'    => 'fine',
                'method'    => 'system',
                'reference' => 'FINE#'.$fine->id,
            ]);
        }

        // Update fine record
        $fine->update([
            'status'          => 'paid',
            'paid_at'         => now(),
            'method'          => $method,
            'transaction_ref' => 'TXN'.time(),
        ]);

        return back()->with('success', 'Fine has been paid successfully.');
    }
}
