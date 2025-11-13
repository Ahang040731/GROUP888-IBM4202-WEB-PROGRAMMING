@extends('layouts.admin')

@section('title', 'Borrow History')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📚 Borrow History</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Book</th>
                <th>Copy</th>
                <th>Borrowed At</th>
                <th>Due At</th>
                <th>Returned At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrows as $borrow)
                <tr>
                    <td>{{ $borrow->id }}</td>
                    <td>{{ $borrow->user->username }}</td>
                    <td>{{ $borrow->book->book_name }}</td>
                    <td>{{ $borrow->copy->barcode }}</td>
                    <td>{{ $borrow->borrowed_at->format('Y-m-d') }}</td>
                    <td>{{ $borrow->due_at->format('Y-m-d') }}</td>
                    <td>{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : '-' }}</td>
                    <td>{{ ucfirst($borrow->status) }}</td>
                    <td>
                        @if($borrow->status != 'returned')
                            <form action="{{ route('admin.borrowhistorymanagement.markReturned', $borrow->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success">Mark Returned</button>
                            </form>
                        @else
                            -
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
