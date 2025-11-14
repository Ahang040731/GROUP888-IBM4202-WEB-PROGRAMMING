<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use App\Models\BorrowHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index(): View
    {
        $user = auth()->user()->user;
        
        $cartItems = $user->carts()
            ->with('book.copies')
            ->get();

        // Check if any items are no longer available
        $unavailableItems = $cartItems->filter(function($item) {
            return !$item->isAvailable();
        });

        return view('client.cart.index', compact('cartItems', 'unavailableItems'));
    }

    /**
     * Add a book to cart.
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        $user = auth()->user()->user;

        // Check if book has available copies
        if ($book->available_copies < 1) {
            return back()->with('error', 'This book is currently not available.');
        }

        // Check cart limit (10 items max)
        $currentCartCount = $user->carts()->count();
        if ($currentCartCount >= 10) {
            return back()->with('error', 'Cart limit reached. You can only have 10 items in your cart.');
        }

        // Check if already in cart
        $existingCart = $user->carts()->where('book_id', $book->id)->first();
        if ($existingCart) {
            return back()->with('info', 'This book is already in your cart.');
        }

        // Add to cart
        $user->carts()->create([
            'book_id' => $book->id,
            'quantity' => 1, // Default to 1 copy
        ]);

        return back()->with('success', 'Book added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:3', // Max 3 copies per book
        ]);

        // Check if user owns this cart item
        if ($cart->user_id !== auth()->user()->user->id) {
            abort(403);
        }

        // Check if requested quantity is available
        if ($cart->book->available_copies < $request->quantity) {
            return back()->with('error', 'Only ' . $cart->book->available_copies . ' copies available.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart): RedirectResponse
    {
        // Check if user owns this cart item
        if ($cart->user_id !== auth()->user()->user->id) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart.
     */
    public function clear(): RedirectResponse
    {
        $user = auth()->user()->user;
        $user->carts()->delete();

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Submit borrow request from cart items.
     */
    public function submitBorrowRequest(): RedirectResponse
    {
        $user = auth()->user()->user;
        
        // Get all cart items
        $cartItems = $user->carts()->with('book.copies')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Check if all items are still available
        $unavailableItems = $cartItems->filter(function($item) {
            return !$item->isAvailable();
        });

        if ($unavailableItems->count() > 0) {
            return back()->with('error', 'Some items in your cart are no longer available. Please remove them first.');
        }

        // Check if user has any pending borrow requests
        $hasPendingRequests = BorrowHistory::where('user_id', $user->id)
            ->where('approve_status', 'pending')
            ->exists();

        if ($hasPendingRequests) {
            return back()->with('error', 'You already have pending borrow requests. Please wait for approval before submitting new requests.');
        }

        DB::beginTransaction();
        
        try {
            $borrowedBooks = [];
            
            foreach ($cartItems as $cartItem) {
                $book = $cartItem->book;
                $quantity = $cartItem->quantity;

                // Get available copies
                $availableCopies = $book->copies()
                    ->where('status', 'available')
                    ->limit($quantity)
                    ->get();

                if ($availableCopies->count() < $quantity) {
                    DB::rollBack();
                    return back()->with('error', "Insufficient copies available for '{$book->book_name}'.");
                }

                // Create borrow history for each copy
                foreach ($availableCopies as $copy) {
                    BorrowHistory::create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'copy_id' => $copy->id,
                        'borrowed_at' => now(),
                        'due_at' => now()->addDays(7), // 7 days borrow period
                        'returned_at' => null,
                        'status' => 'active',
                        'extension_count' => 0,
                        'extension_reason' => null,
                        'approve_status' => 'pending', // Pending approval
                    ]);

                    // Mark copy as not available
                    $copy->update(['status' => 'not available']);
                    
                    $borrowedBooks[] = $book->book_name;
                }

                // Update book's available copies count
                $book->update([
                    'available_copies' => $book->copies()->where('status', 'available')->count()
                ]);
            }

            // Clear the cart after successful submission
            $user->carts()->delete();

            DB::commit();

            // Return with success message and list of books
            $booksList = implode(', ', array_unique($borrowedBooks));
            return redirect()->route('client.borrowhistory.index')
                ->with('success', "Borrow request submitted successfully for: {$booksList}. Waiting for admin approval.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Borrow request failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit borrow request. Please try again.');
        }
    }
}