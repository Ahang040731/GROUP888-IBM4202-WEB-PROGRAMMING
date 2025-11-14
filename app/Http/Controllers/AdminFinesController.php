<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BorrowHistory;
use Illuminate\Http\Request;
use App\Models\Fine;
use Illuminate\Http\RedirectResponse;

class AdminFinesController extends Controller
{
    public function index()
    {
        $fines = Fine::with(['user', 'borrowHistory.book', 'handler'])
            ->orderByDesc('created_at')
            ->paginate(10);

        // For SweetAlert dropdowns
        $users = User::orderBy('username')->get();

        $borrows = BorrowHistory::with(['book', 'user'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('admin.fines.index', compact('fines', 'users', 'borrows'));
    }


    public function approve(Fine $fine): RedirectResponse
    {
        // Only pending fines can be approved
        if ($fine->status !== 'pending') {
            return back()->with('error', 'Only pending fines can be approved.');
        }

        // Get logged-in account and its admin profile
        $account = auth()->user();          // accounts table
        $admin   = $account->admin ?? null; // admins table (account_id FK)

        if (!$admin) {
            return back()->with('error', 'No admin profile linked to this account.');
        }

        $user = $fine->user;

        if (!$user) {
            return back()->with('error', 'User profile not found for this fine.');
        }

        // ✅ Do NOT check or deduct credit anymore
        // Approval just marks the fine as paid/settled

        $fine->update([
            'status'          => 'paid',
            'paid_at'         => now(),
            'transaction_ref' => 'FINE-' . $fine->id . '-' . time(),
            'handled_by'      => $admin->id,
        ]);

        return back()->with('success', 'Fine has been approved and marked as paid.');
    }

    public function reject(Fine $fine): RedirectResponse
    {
        // Only pending fines can be rejected
        if ($fine->status !== 'pending') {
            return back()->with('error', 'Only pending fines can be rejected.');
        }

        $account = auth()->user();
        $admin   = $account->admin ?? null;

        if (!$admin) {
            return back()->with('error', 'No admin profile linked to this account.');
        }

        // Back to unpaid so it appears again for the user
        $fine->update([
            'status'          => 'unpaid',
            'transaction_ref' => 'REJ-' . $fine->id . '-' . time(),
            'handled_by'      => $admin->id,
            'paid_at'         => null,
        ]);

        return back()->with('success', 'Fine payment request has been rejected.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'borrowing_id' => 'nullable|exists:borrow_history,id',
            'reason'       => 'required|in:late,lost,damage,manual,activate',
            'amount'       => 'required|numeric|min:0.01',
        ]);

        // Optional safety: ensure borrow belongs to user (if chosen)
        if (!empty($validated['borrowing_id'])) {
            $borrow = BorrowHistory::find($validated['borrowing_id']);
            if ($borrow && $borrow->user_id !== (int)$validated['user_id']) {
                return back()
                    ->withErrors(['borrowing_id' => 'Selected borrow record does not belong to this user.'])
                    ->withInput();
            }
        }

        Fine::create([
            'user_id'      => $validated['user_id'],
            'borrowing_id' => $validated['borrowing_id'] ?? null,
            'reason'       => $validated['reason'],
            'amount'       => round($validated['amount'], 2),
            'status'       => 'unpaid',
        ]);

        return redirect()
            ->route('admin.fines.index')
            ->with('success', 'Fine created successfully.');
    }
}
