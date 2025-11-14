@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-5">
        <h2 class="fw-bold">📊 Admin Dashboard</h2>
        <p class="text-muted">Manage books, users, and borrowing records efficiently.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm card-hover">
                <div class="card-body">
                    <h5 class="text-muted">Total Books</h5>
                    <h3 class="fw-bold text-primary">{{ $totalBooks ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm card-hover">
                <div class="card-body">
                    <h5 class="text-muted">Active Users</h5>
                    <h3 class="fw-bold text-success">{{ $totalUsers ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm card-hover">
                <div class="card-body">
                    <h5 class="text-muted">Books Borrowed</h5>
                    <h3 class="fw-bold text-warning">{{ $borrowedBooks ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Navigation --}}
    <h4 class="fw-bold mb-3">Quick Access</h4>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('admin.books.index') }}" class="text-decoration-none">
                <div class="card text-center border-0 shadow-sm card-hover py-4">
                    <h5>📚 Manage Books</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.usermanagement.index') }}" class="text-decoration-none">
                <div class="card text-center border-0 shadow-sm card-hover py-4">
                    <h5>👥 Manage Users</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.borrowhistorymanagement.index') }}" class="text-decoration-none">
                <div class="card text-center border-0 shadow-sm card-hover py-4">
                    <h5>📖 Borrow History</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.profile.index') }}" class="text-decoration-none">
                <div class="card text-center border-0 shadow-sm card-hover py-4">
                    <h5>👤 Admin Profile</h5>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
