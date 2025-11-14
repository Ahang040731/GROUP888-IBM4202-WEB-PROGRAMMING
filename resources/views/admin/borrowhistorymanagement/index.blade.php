@extends('layouts.admin')

@section('title', 'Borrow History')

@section('content')
<div class="container py-5" style="background-color:#f5f6fa; min-height:90vh;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width:1300px;">

        <!-- Header -->
        <div class="card-header bg-white py-4 d-flex flex-wrap justify-content-between align-items-center border-0"
             style="border-bottom:1px solid #e5e5e5;">
            <h2 class="fw-bold m-0" style="color:#2c3e50; font-size:1.7rem;">
                📚 Borrow History
            </h2>
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
                <table class="table table-hover align-middle text-center mb-0 shadow-sm"
                       style="border-radius:10px; overflow:hidden;">

                    <thead style="background-color:#2c3e50; color:white;">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Copy</th>
                            <th>Borrowed At</th>
                            <th>Due At</th>
                            <th>Returned At</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($borrows as $borrow)
                        <tr style="background-color:white;">
                            <td class="fw-semibold">{{ $borrow->id }}</td>

                            <td>{{ $borrow->user->username ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $borrow->book->book_name ?? 'N/A' }}</td>
                            <td>{{ $borrow->copy->barcode ?? 'N/A' }}</td>

                            <td>{{ $borrow->borrowed_at ? $borrow->borrowed_at : '-' }}</td>
                            <td>{{ $borrow->due_at ? $borrow->due_at : '-' }}</td>
                            <td>{{ $borrow->returned_at ? $borrow->returned_at : '-' }}</td>

                            <td>
                                <span class="badge
                                    @if($borrow->status == 'active') bg-success
                                    @elseif($borrow->status == 'overdue') bg-warning
                                    @elseif($borrow->status == 'returned') bg-secondary
                                    @elseif($borrow->status == 'lost') bg-danger
                                    @else bg-light text-dark
                                    @endif">
                                    {{ ucfirst($borrow->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No borrow records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $borrows->links() }}
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
        .table th, .table td {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
