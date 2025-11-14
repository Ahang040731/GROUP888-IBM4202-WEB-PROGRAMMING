<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\BorrowHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class NotificationController extends Controller
{
    // Remove constructor - we'll rely on route middleware instead
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display all notifications for the user
     */
    public function index(): View
    {
        $account = auth()->user();
        
        // Simple check - just verify user profile exists
        if (!$account || !$account->user) {
            return redirect()->route('login')
                ->with('error', 'Please log in with a valid user account.');
        }

        $user = $account->user;
        $userId = $user->id;

        // Get unpaid fines
        $unpaidFines = Fine::with(['borrowHistory.book'])
            ->where('user_id', $userId)
            ->whereIn('status', ['unpaid', 'pending'])
            ->orderByDesc('created_at')
            ->get();

        // Get books that need to be returned (active borrows)
        $activeBooks = BorrowHistory::with(['book'])
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->where('approve_status', 'approved')
            ->whereIn('status', ['active', 'overdue'])
            ->orderBy('due_at', 'asc')
            ->get();

        // Get overdue books (subset of active books)
        $overdueBooks = BorrowHistory::with(['book'])
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->where('approve_status', 'approved')
            ->where('status', 'overdue')
            ->orderBy('due_at', 'asc')
            ->get();

        // Get pending borrow requests
        $pendingRequests = BorrowHistory::with(['book'])
            ->where('user_id', $userId)
            ->where('approve_status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        // Calculate notification counts
        $notificationCount = $unpaidFines->count() + 
                            $overdueBooks->count() + 
                            $pendingRequests->count();

        return view('client.notifications.index', compact(
            'unpaidFines',
            'activeBooks',
            'overdueBooks',
            'pendingRequests',
            'notificationCount'
        ));
    }

    /**
     * Get notification count (for AJAX requests)
     */
    public function count()
    {
        $account = auth()->user();
        
        if (!$account || !$account->user) {
            return response()->json(['count' => 0]);
        }

        $user = $account->user;
        $userId = $user->id;

        // Count unpaid fines
        $unpaidFines = Fine::where('user_id', $userId)
            ->whereIn('status', ['unpaid', 'pending'])
            ->count();

        // Count overdue books
        $overdueBooks = BorrowHistory::where('user_id', $userId)
            ->whereNull('returned_at')
            ->where('approve_status', 'approved')
            ->where('status', 'overdue')
            ->count();

        // Count pending requests
        $pendingRequests = BorrowHistory::where('user_id', $userId)
            ->where('approve_status', 'pending')
            ->count();

        $total = $unpaidFines + $overdueBooks + $pendingRequests;

        return response()->json([
            'count' => $total,
            'unpaidFines' => $unpaidFines,
            'overdueBooks' => $overdueBooks,
            'pendingRequests' => $pendingRequests
        ]);
    }
}