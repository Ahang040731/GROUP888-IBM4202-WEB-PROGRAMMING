@extends('layouts.admin')

@section('title', 'Book Management')

@section('content')
<div class="container py-5" style="background-color:#f5f6fa; min-height:90vh;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width:1200px;">

        <!-- Header -->
        <div class="card-header bg-white py-4 d-flex flex-wrap justify-content-between align-items-center border-0"
             style="border-bottom:1px solid #e5e5e5;">
            <h2 class="fw-bold m-0" style="color:#2c3e50; font-size:1.7rem;">
                📚 Manage Books
            </h2>

            <a href="{{ route('admin.books.create') }}"
               class="btn px-4 py-2"
               style="background-color:#51CF66; color:#fff; border-radius:8px; font-weight:600;">
                + Add New Book
            </a>
        </div>

        <div class="card-body px-4 pb-4">

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0 shadow-sm" style="border-radius:10px; overflow:hidden;">
                    <thead style="background-color:#2c3e50; color:white;">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th class="text-start px-4">Name</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th style="width:90px;">Total</th>
                            <th style="width:110px;">Available</th>
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($books as $book)
                        <tr style="background-color:white;">
                            <td class="fw-semibold">{{ $book->id }}</td>

                            <td class="text-start px-4">{{ $book->book_name }}</td>

                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category }}</td>

                            <td class="fw-semibold">{{ $book->total_copies }}</td>
                            <td class="fw-semibold text-success">{{ $book->available_copies }}</td>

                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                       class="btn px-3 py-1"
                                       style="background-color:#FFA94D; color:white; border-radius:6px; font-weight:500;">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.books.destroy', $book->id) }}"
                                          method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn px-3 py-1"
                                                style="background-color:#FF6B6B; color:white; border-radius:6px; font-weight:500;"
                                                onclick="return confirm('Delete this book?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-muted py-4">No books found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* Table Hover */
    table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.06);
        transition: 0.2s;
    }

    /* Buttons Hover */
    .btn:hover {
        transform: translateY(-1.5px);
        opacity: 0.93;
        transition: 0.2s ease;
    }

    /* Pagination */
    .pagination .page-link {
        color: #0d6efd;
        border-radius: 6px;
        padding: 6px 12px;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .pagination .page-link:hover {
        background-color: #0d6efd;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header h2 {
            font-size: 1.5rem;
        }
        .card-header a {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
        .table th, .table td {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
