@extends('layouts.admin')

@section('title', 'Manage Borrowed Books')

@section('content')
<div class="container py-5" style="background-color:#f5f6fa; min-height:90vh;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width:1300px;">

        <!-- Page Header -->
        <div class="card-header bg-white py-4 d-flex flex-wrap justify-content-between align-items-center border-0"
             style="border-bottom:1px solid #e5e5e5;">

            <h2 class="fw-bold m-0" style="color:#2c3e50; font-size:1.7rem;">
                📘 Manage Borrowed Books
            </h2>
        </div>

        <div class="card-body px-4 pb-4">

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-3 mb-3">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session('info'))
                <div class="alert alert-info alert-dismissible fade show rounded-3 mb-3">
                    {{ session('info') }}
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
                            <th>Status</th>
                            <th>Approve</th>
                            <th>Borrowed</th>
                            <th>Due</th>
                            <th>Returned</th>
                            <th style="width:220px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($borrows as $borrow)
                        <tr style="background-color:white;">
                            <td class="fw-semibold">{{ $borrow->id }}</td>
                            <td>{{ $borrow->user->username ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $borrow->book->book_name ?? 'N/A' }}</td>
                            <td>{{ $borrow->copy->barcode ?? 'N/A' }}</td>

                            <!-- Borrow Status Badge -->
                            <td>
                                <span class="badge 
                                    @if($borrow->status == 'active') bg-success
                                    @elseif($borrow->status == 'overdue') bg-warning
                                    @elseif($borrow->status == 'returned') bg-secondary
                                    @elseif($borrow->status == 'lost') bg-danger
                                    @else bg-light text-dark
                                    @endif"
                                >
                                    {{ ucfirst($borrow->status) }}
                                </span>
                            </td>

                            <td>{{ ucfirst($borrow->approve_status) }}</td>
                            <td>{{ $borrow->borrowed_at ?? '-' }}</td>
                            <td>{{ $borrow->due_at ?? '-' }}</td>
                            <td>{{ $borrow->returned_at ?? '-' }}</td>

                            <!-- Actions -->
                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    @if($borrow->status == 'pending')

                                        <form action="{{ route('admin.borrows.approve', $borrow->id) }}"
                                            method="POST" class="m-0">
                                            @csrf
                                            <button class="btn px-3 py-1"
                                                style="background-color:#51CF66; color:white; border-radius:6px;">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.borrows.reject', $borrow->id) }}"
                                            method="POST" class="m-0">
                                            @csrf
                                            <button class="btn px-3 py-1"
                                                style="background-color:#FF6B6B; color:white; border-radius:6px;">
                                                Reject
                                            </button>
                                        </form>

                                    @elseif($borrow->status == 'active' || $borrow->status == 'overdue')

                                        <form action="{{ route('admin.borrows.markReturned', $borrow->id) }}"
                                            method="POST" class="m-0">
                                            @csrf
                                            <button class="btn px-3 py-1"
                                                style="background-color:#228BE6; color:white; border-radius:6px;">
                                                Mark Returned
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-muted">No actions</span>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">No borrow records found.</td>
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

    table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.06);
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1.5px);
        opacity: 0.93;
        transition: 0.2s ease;
    }

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
</style>

@endsection
