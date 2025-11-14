<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreditTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CreditController extends Controller
{
    /**
     * Display credit balance and transaction history
     */
    public function index(): View
    {
        $user = auth()->user()->user;
        
        $transactions = $user->creditTransactions()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('client.credit.index', compact('user', 'transactions'));
    }

    /**
     * Show top-up form
     */
    public function topup(): View
    {
        $user = auth()->user()->user;
        return view('client.credit.topup', compact('user'));
    }

    /**
     * Process top-up
     */
    public function processTopup(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:1000',
            'method' => 'required|in:credit,card,online_banking,tng,cash',
        ]);

        $user = auth()->user()->user;
        $amount = $request->amount;
        $method = $request->method;

        DB::beginTransaction();
        
        try {
            // Create transaction record
            $transaction = CreditTransaction::create([
                'user_id' => $user->id,
                'delta' => $amount, // Positive for top-up
                'reason' => 'topup',
                'method' => $method,
                'reference' => 'TOPUP-' . strtoupper(uniqid()),
            ]);

            // Update user credit balance
            $user->increment('credit', $amount);

            DB::commit();

            return redirect()->route('client.credit.index')
                ->with('success', "Successfully topped up RM " . number_format($amount, 2) . " to your account!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Credit top-up failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to process top-up. Please try again.');
        }
    }

    /**
     * Pay fine using credit
     * This will be called from fine payment process
     */
    public static function deductForFine($userId, $amount, $fineId): bool
    {
        DB::beginTransaction();
        
        try {
            $user = \App\Models\User::findOrFail($userId);

            // Check if user has sufficient credit
            if ($user->credit < $amount) {
                return false;
            }

            // Create deduction transaction
            CreditTransaction::create([
                'user_id' => $userId,
                'delta' => -$amount, // Negative for deduction
                'reason' => 'fine',
                'method' => 'credit',
                'reference' => 'FINE-' . $fineId,
            ]);

            // Deduct from user balance
            $user->decrement('credit', $amount);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fine payment failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deduct credit for lost book
     */
    public static function deductForLostBook($userId, $amount, $borrowHistoryId): bool
    {
        DB::beginTransaction();
        
        try {
            $user = \App\Models\User::findOrFail($userId);

            // Check if user has sufficient credit
            if ($user->credit < $amount) {
                return false;
            }

            // Create deduction transaction
            CreditTransaction::create([
                'user_id' => $userId,
                'delta' => -$amount,
                'reason' => 'lost',
                'method' => 'credit',
                'reference' => 'LOST-' . $borrowHistoryId,
            ]);

            // Deduct from user balance
            $user->decrement('credit', $amount);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lost book payment failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deduct credit for damaged book
     */
    public static function deductForDamage($userId, $amount, $borrowHistoryId): bool
    {
        DB::beginTransaction();
        
        try {
            $user = \App\Models\User::findOrFail($userId);

            // Check if user has sufficient credit
            if ($user->credit < $amount) {
                return false;
            }

            // Create deduction transaction
            CreditTransaction::create([
                'user_id' => $userId,
                'delta' => -$amount,
                'reason' => 'damage',
                'method' => 'credit',
                'reference' => 'DAMAGE-' . $borrowHistoryId,
            ]);

            // Deduct from user balance
            $user->decrement('credit', $amount);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Damage payment failed: ' . $e->getMessage());
            return false;
        }
    }
}