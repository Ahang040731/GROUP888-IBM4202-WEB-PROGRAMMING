@extends('layouts.admin')

@section('title', 'Edit Book')

@section('content')
<div class="container py-5" style="background-color:#ffffff; min-height:90vh;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg rounded-lg mb-4">
                <div class="card-header bg-warning text-black text-center">
                    <h3 class="mb-0">✏️ Edit Book</h3>
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

                    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Book Name</label>
                            <input type="text" name="book_name" class="form-control border shadow-sm" value="{{ $book->book_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control border shadow-sm" value="{{ $book->author }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Published Year</label>
                            <input type="number" name="published_year" class="form-control border shadow-sm" value="{{ $book->published_year }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control border shadow-sm" value="{{ $book->category }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Copies</label>
                            <input type="number" name="total_copies" class="form-control border shadow-sm" value="{{ $book->total_copies }}" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cover Image URL</label>
                            <input type="url" name="photo" class="form-control border shadow-sm" value="{{ $book->photo }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control border shadow-sm" rows="3">{{ $book->description }}</textarea>
                        </div>

                        <button type="submit" class="btn shadow text-white w-100 btn-lg" style="background-color:#51CF66;">Update Book</button>
                        <a href="{{ route('admin.books.index') }}" class="btn shadow text-white w-100 mt-2" style="background-color:#6c757d;">Cancel</a>
                    </form>
                </div>
            </div>

            {{-- Book Copies --}}
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-info text-white text-center">
                    <h4 class="mb-0">Book Copies</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>Copy Barcode</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($book->copies as $copy)
                                <tr>
                                    <td>{{ $copy->barcode }}</td>
                                    <td>{{ ucfirst($copy->status) }}</td>
                                    <td class="d-flex justify-content-center gap-2 flex-wrap">
                                        @if($copy->status != 'available')
                                            <form method="POST" action="{{ route('admin.books.copies.status', [$copy->id, 'available']) }}">
                                                @csrf
                                                <button class="btn shadow text-white px-3" style="background-color:#51CF66;">Mark Available</button>
                                            </form>
                                        @endif
                                        @if($copy->status != 'lost')
                                            <form method="POST" action="{{ route('admin.books.copies.status', [$copy->id, 'lost']) }}">
                                                @csrf
                                                <button class="btn shadow text-white px-3" style="background-color:#FFA94D;">Mark Lost</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.books.copies.destroy', $copy->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn shadow text-white px-3" style="background-color:#FF6B6B;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form method="POST" action="{{ route('admin.books.copies.add', $book->id) }}" class="d-flex gap-2 align-items-center justify-content-center mt-3">
                        @csrf
                        <label class="mb-0">Add Copies:</label>
                        <input type="number" name="count" value="1" min="1" class="form-control w-auto border shadow-sm">
                        <button class="btn shadow text-white px-4" style="background-color:#51CF66;">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
