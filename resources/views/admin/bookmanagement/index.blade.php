@extends('layouts.app')

@section('title', 'Book Management')

@section('content')
<div class="container py-5" style="background-color: #ffffff; min-height: 90vh;">
    <div class="card shadow-lg rounded-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="text-center flex-grow-1 mb-3 mb-md-0">📚 Manage Books</h2>
            <a href="{{ route('admin.books.create') }}" class="btn shadow text-white px-4" style="background-color:#51CF66;">+ Add New Book</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px; padding: 12px;">#</th>
                        <th style="min-width: 220px; padding: 12px;">Name</th>
                        <th style="padding: 12px;">Author</th>
                        <th style="padding: 12px;">Category</th>
                        <th style="width: 100px; padding: 12px;">Total</th>
                        <th style="width: 120px; padding: 12px;">Available</th>
                        <th style="width: 220px; padding: 12px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr style="line-height: 1.8;">
                            <td>{{ $book->id }}</td>
                            <td class="text-start" style="word-wrap: break-word;">{{ $book->book_name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category }}</td>
                            <td>{{ $book->total_copies }}</td>
                            <td>{{ $book->available_copies }}</td>
                            <td class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn shadow text-white px-3" style="background-color:#FFA94D;">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn shadow text-white px-3" style="background-color:#FF6B6B;" onclick="return confirm('Delete this book?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
