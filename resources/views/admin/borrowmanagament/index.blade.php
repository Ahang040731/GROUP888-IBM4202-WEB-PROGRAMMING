@extends('layouts.admin')

@section('title', 'Manage Borrowed Books')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📚 Manage Borrowed Books</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Book</th>
                <th>Status</th>
                <th>Approve Status</th>
                <th>Borrowed At</th>
                <th>Due At</th>
                <th>Returned At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($borrows as $borrow)
                <tr>
                    <td>{{ $borrow->id }}</td>
                    <td>{{ $borrow->user->username ?? 'N/A' }}</td>
                    <td>{{ $borrow->book->book_name ?? 'N/A' }}</td>
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
                    <td>{{ ucfirst($borrow->approve_status) }}</td>
                    <td>{{ $borrow->borrowed_at ?? '-' }}</td>
                    <td>{{ $borrow->due_at ?? '-' }}</td>
                    <td>{{ $borrow->returned_at ?? '-' }}</td>
                    <td>
                        @if($borrow->approve_status == 'pending')
                            <form action="{{ route('admin.borrows.approve', $borrow->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm" type="submit">Approve</button>
                            </form>
                            <form action="{{ route('admin.borrows.reject', $borrow->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                            </form>
                        @elseif($borrow->status == 'active')
                            <form action="{{ route('admin.borrows.markReturned', $borrow->id) }}" method="POST" class="d-inline">

                                @csrf
                                <button class="btn btn-primary btn-sm" type="submit">Mark Returned</button>
                            </form>
                        @else
                            <span class="text-muted">No actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No borrow records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $borrows->links() }}
    </div>
</div>
@endsection
