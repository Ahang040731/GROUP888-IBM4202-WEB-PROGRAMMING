@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="container py-5" style="background-color:#ffffff; min-height:90vh;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-success text-black text-center">
                    <h3 class="mb-0">➕ Add New Book</h3>
                </div>
                <div class="card-body p-4">
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
                            <label class="form-label">Book Name</label>
                            <input type="text" name="book_name" class="form-control border shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control border shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Published Year</label>
                            <input type="number" name="published_year" class="form-control border shadow-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control border shadow-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Copies</label>
                            <input type="number" name="total_copies" class="form-control border shadow-sm" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cover Image URL</label>
                            <input type="url" name="photo" class="form-control border shadow-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control border shadow-sm" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn shadow text-white w-100 btn-lg" style="background-color:#51CF66;">Add Book</button>
                        <a href="{{ route('admin.books.index') }}" class="btn shadow text-white w-100 mt-2" style="background-color:#6c757d;">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
