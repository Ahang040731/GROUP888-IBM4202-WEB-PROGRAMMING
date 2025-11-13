<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
}