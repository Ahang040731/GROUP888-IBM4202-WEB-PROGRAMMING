@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">➕ Add New Book</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="book_name" class="form-label">Book Name</label>
            <input type="text" name="book_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="published_year" class="form-label">Published Year</label>
            <input type="number" name="published_year" class="form-control">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control">
        </div>

        <div class="mb-3">
            <label for="total_copies" class="form-label">Total Copies</label>
            <input type="number" name="total_copies" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Cover Image URL</label>
            <input type="url" name="photo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Book</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
