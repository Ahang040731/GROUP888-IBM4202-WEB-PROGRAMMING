@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container py-5" style="background-color:#f5f6fa; min-height:90vh;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width:1200px;">

        <!-- Header -->
        <div class="card-header bg-white py-4 d-flex flex-wrap justify-content-between align-items-center border-0"
             style="border-bottom:1px solid #e5e5e5;">
            <h2 class="fw-bold m-0" style="color:#2c3e50; font-size:1.7rem;">
                👥 User Management
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
                            <th style="width:60px;">#</th>
                            <th class="text-start px-4">Username</th>
                            <th>Phone</th>
                            <th>Credit</th>
                            <th>Status</th>
                            <th style="width:220px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr style="background-color:white;">

                            <td class="fw-semibold">{{ $user->id }}</td>

                            <td class="text-start px-4 fw-semibold">
                                {{ $user->username }}
                            </td>

                            <td>{{ $user->phone ?? '—' }}</td>

                            <td class="fw-semibold">
                                {{ $user->credit }}
                            </td>

                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Inactive</span>
                                @endif
                            </td>

                            <td>
                               <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    <a href="{{ route('admin.usermanagement.edit', $user->id) }}"
                                       class="btn px-3 py-1"
                                       style="background-color:#FFA94D; color:white; border-radius:6px; font-weight:500;">
                                        View / Edit
                                    </a>

                                    <form action="{{ route('admin.usermanagement.toggle', $user->id) }}"
                                          method="POST" class="m-0">
                                        @csrf
                                        <button class="btn px-3 py-1 {{ $user->is_active ? '' : '' }}"
                                                style="background-color:{{ $user->is_active ? '#FF6B6B' : '#51CF66' }}; color:white; border-radius:6px; font-weight:500;"
                                                onclick="return confirm('Confirm to {{ $user->is_active ? 'deactivate' : 'activate' }} this user?')">
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                               </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No users found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
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
        .table th, .table td {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
