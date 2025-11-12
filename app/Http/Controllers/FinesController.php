<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\User;
use App\Models\CreditTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FinesController extends Controller
{
    // Display fines for the current user
    public function index()
    {
        $userId = auth()->id() ?? 1; // TODO: restore real auth()->id()

        // Fetch unpaid fines
        $current = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->orderBy('created_at')
            ->get();

        // Fetch previous fines (paid/waived/reversed)
        $previous = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->where('status', '!=', 'unpaid')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('client.fines.index', compact('current','previous'));
    }

    // Pay a fine
    public function pay(Fine $fine, Request $request): RedirectResponse
    {
        $user = auth()->user() ?? User::find(1); // TODO: restore real auth

        // Check if the fine belongs to the user
        if ($fine->user_id !== $user->id) {
            abort(403);
        }

        // Only unpaid fines can be paid
        if ($fine->status !== 'unpaid') {
            return back()->with('error', 'This fine has already been processed.');
        }

        // Get payment method from request (default 'credit')
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
                'user_id' => $user->id,
                'delta' => -$fine->amount,
                'reason' => 'fine',
                'method' => 'system',
                'reference' => 'FINE#'.$fine->id,
            ]);
        }

        // Update fine record
        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
            'method' => $method,
            'transaction_ref' => 'TXN'.time(),
        ]);

        return back()->with('success', 'Fine has been paid successfully.');
    }
}
?>