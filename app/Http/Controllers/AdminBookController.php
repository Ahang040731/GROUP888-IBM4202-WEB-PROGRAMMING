<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCopy;

class AdminBookController extends Controller
{
    // book list
    public function index()
    {
        $books = Book::paginate(25);
        return view('admin.bookmanagement.index', compact('books'));
    }

    // new book list
    public function create()
    {
        return view('admin.bookmanagement.create');
    }

    // store book
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return redirect()->route('admin.books.index')->with('success', 'Book created.');
    }

    // edit book
    public function edit(Book $book)
    {
        $book->load('copies'); 
        return view('admin.bookmanagement.edit', compact('book'));
    }

    // update book
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        return redirect()->route('admin.books.index')->with('success', 'Book updated.');
    }

    // delete book
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted.');
    }

    /* =========================
       BookCopy Management
    ========================== */

    // addcopy
    public function addCopy(Request $request, Book $book)
    {
        $count = $request->input('count', 1);
        for ($i = 0; $i < $count; $i++) {
            $book->copies()->create(['status' => 'available']);
        }

        $book->available_copies = $book->copies()->where('status', 'available')->count();
        $book->save();

        return back()->with('success', 'Copies added.');
    }

    // delete copy
    public function deleteCopy(BookCopy $copy)
    {
        $book = $copy->book;
        $copy->delete();
        $book->available_copies = $book->copies()->where('status', 'available')->count();
        $book->save();

        return back()->with('success', 'Copy deleted.');
    }

    // update copy status
    public function updateCopyStatus(BookCopy $copy, $status)
    {
        $copy->status = $status;
        $copy->save();

        $book = $copy->book;
        $book->available_copies = $book->copies()->where('status', 'available')->count();
        $book->save();

        return back()->with('success', 'Copy status updated.');
    }
}
