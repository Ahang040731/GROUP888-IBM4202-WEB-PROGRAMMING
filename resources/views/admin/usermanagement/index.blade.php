@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">👥 User Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Credit</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td>{{ $user->credit }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.usermanagement.edit', $user->id) }}" class="btn btn-sm btn-warning">View / Edit</a>

                        <form action="{{ route('admin.usermanagement.toggle', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}"
                                    onclick="return confirm('Confirm to {{ $user->is_active ? 'deactivate' : 'activate' }} this user?')">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
