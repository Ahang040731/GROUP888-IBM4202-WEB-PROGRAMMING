@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">✏️ Edit Book</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="book_name" class="form-label">Book Name</label>
            <input type="text" name="book_name" class="form-control" value="{{ $book->book_name }}" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
        </div>

        <div class="mb-3">
            <label for="published_year" class="form-label">Published Year</label>
            <input type="number" name="published_year" class="form-control" value="{{ $book->published_year }}">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ $book->category }}">
        </div>

        <div class="mb-3">
            <label for="total_copies" class="form-label">Total Copies</label>
            <input type="number" name="total_copies" class="form-control" value="{{ $book->total_copies }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Cover Image URL</label>
            <input type="url" name="photo" class="form-control" value="{{ $book->photo }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $book->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Book</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<h4>Book Copies</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Copy ID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($book->copies as $copy)
            <tr>
                <td>{{ $copy->id }}</td>
                <td>{{ ucfirst($copy->status) }}</td>
                <td>
                    @if($copy->status != 'available')
                        <form method="POST" action="{{ route('admin.books.copies.status', [$copy->id, 'available']) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Mark Available</button>
                        </form>
                    @endif
                    @if($copy->status != 'lost')
                        <form method="POST" action="{{ route('admin.books.copies.status', [$copy->id, 'lost']) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-warning">Mark Lost</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.books.copies.destroy', $copy->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<form method="POST" action="{{ route('admin.books.copies.add', $book->id) }}">
    @csrf
    <label>Add Copies:</label>
    <input type="number" name="count" value="1" min="1" class="form-control d-inline-block w-auto">
    <button class="btn btn-primary">Add</button>
</form>

@endsection
