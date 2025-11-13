@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">🧾 User Details</h2>

    <form action="{{ route('admin.usermanagement.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ $user->address }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Credit</label>
            <input type="number" class="form-control" value="{{ $user->credit }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label><br>
            @if($user->is_active)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.usermanagement.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
