<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BorrowHistory;
use App\Models\BookCopy;
use App\Models\Book;
use App\Models\Fine;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = BorrowHistory::with(['user', 'book', 'copy'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);

        return view('admin.borrowmanagament.index', compact('borrows'));

    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $borrow = BorrowHistory::lockForUpdate()->findOrFail($id);

            if ($borrow->approve_status !== 'pending') {
                DB::rollBack();
                return redirect()->back()->with('warning', 'Request already processed.');
            }

            $copy = BookCopy::where('book_id', $borrow->book_id)
                        ->where('status', 'available')
                        ->first();

            if (!$copy) {
                $borrow->approve_status = 'rejected';
                $borrow->save();
                DB::commit();
                return redirect()->back()->with('error', 'No available copy. Request rejected.');
            }

            $copy->status = 'not available';
            $copy->save();

            $borrow->copy_id = $copy->id;
            $borrow->approve_status = 'approved';
            $borrow->borrowed_at = Carbon::now();
            $borrow->due_at = Carbon::now()->addDays(14);
            $borrow->status = 'active';
            $borrow->save();

            $book = Book::find($borrow->book_id);
            if ($book && $book->available_copies > 0) {
                $book->available_copies = max(0, $book->available_copies - 1);
                $book->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Borrow approved.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error approving borrow: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $borrow = BorrowHistory::findOrFail($id);
        if ($borrow->approve_status !== 'pending') {
            return redirect()->back()->with('warning', 'Request already processed.');
        }

        $borrow->approve_status = 'rejected';
        $borrow->status = 'rejected';
        $borrow->save();

        return redirect()->back()->with('info', 'Borrow request rejected.');
    }

    public function markReturned($id)
    {
        DB::beginTransaction();
        try {
            $borrow = BorrowHistory::lockForUpdate()->findOrFail($id);

            if ($borrow->status === 'returned') {
                DB::rollBack();
                return redirect()->back()->with('warning', 'Already returned.');
            }

            // 1) Mark as returned
            $borrow->returned_at = Carbon::now();
            $borrow->status      = 'returned';
            $borrow->save();

            // 2) Free the copy
            if ($borrow->copy_id) {
                $copy = BookCopy::find($borrow->copy_id);
                if ($copy) {
                    $copy->status = 'available';
                    $copy->save();
                }
            }

            // 3) Increase available copies on the book
            $book = Book::find($borrow->book_id);
            if ($book) {
                $book->available_copies = ($book->available_copies ?? 0) + 1;
                $book->save();
            }

            // 4) Late fine logic (use accessor late_days)
            $borrow->refresh();                  // ensure latest dates
            $daysLate = $borrow->late_days;      // from your BorrowHistory model

            if ($daysLate > 0) {
                $baseFine   = 5.00;              // base RM5
                $latePerDay = 2.00;              // +RM2 per late day
                $fineAmount = round($baseFine + ($daysLate * $latePerDay), 2);

                // If a fine already exists for this borrow, update it
                // If not, create it
                $fine = Fine::where('borrowing_id', $borrow->id)->first();

                // If the fine already exists but is not unpaid (paid/waived/etc), don't modify it
                if ($fine && $fine->status !== 'unpaid') {
                    // do nothing
                } else {
                    Fine::updateOrCreate(
                        [
                            'borrowing_id' => $borrow->id,
                            'user_id'      => $borrow->user_id,
                        ],
                        [
                            'reason' => 'late',
                            'amount' => $fineAmount,
                            'status' => 'unpaid',
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Marked as returned.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error marking returned: ' . $e->getMessage());
        }
    }

}
