<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BorrowHistory;
use Illuminate\Http\Request;
use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        DB::beginTransaction();
        
        try {
            $amount = $fine->amount;

            // ✅ Check payment method and deduct credit if needed
            if ($fine->method === 'credit') {
                // Check if user has sufficient credit
                if ($user->credit < $amount) {
                    return back()->with('error', 
                        'User has insufficient credit balance. Available: RM ' . 
                        number_format($user->credit, 2) . 
                        ', Required: RM ' . number_format($amount, 2)
                    );
                }

                // Deduct credit using the CreditController method
                $success = CreditController::deductForFine($user->id, $amount, $fine->id);
                
                if (!$success) {
                    DB::rollBack();
                    return back()->with('error', 'Failed to deduct credit from user account.');
                }
            }
            // For other payment methods (cash, card, online_banking, tng), 
            // assume payment was received offline - no credit deduction needed

            // Update fine status
            $fine->update([
                'status'          => 'paid',
                'paid_at'         => now(),
                'transaction_ref' => 'FINE-' . $fine->id . '-' . time(),
                'handled_by'      => $admin->id,
            ]);

            DB::commit();

            return back()->with('success', 
                $fine->method === 'credit' 
                    ? 'Fine approved and RM ' . number_format($amount, 2) . ' deducted from user credit.'
                    : 'Fine approved and marked as paid.'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fine approval failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve fine. Please try again.');
        }
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