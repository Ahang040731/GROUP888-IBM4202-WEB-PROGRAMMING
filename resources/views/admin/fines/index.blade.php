@extends('layouts.admin')

@section('title', 'Admin Fines')

@section('content')
<div class="container py-5" style="background-color:#f5f6fa; min-height:90vh;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width:1300px;">

        <!-- Header -->
        <div class="card-header bg-white py-4 d-flex flex-wrap justify-content-between align-items-center border-0"
             style="border-bottom:1px solid #e5e5e5;">
            <h2 class="fw-bold m-0" style="color:#2c3e50; font-size:1.7rem;">
                💰 Admin Fines Management
            </h2>

            <button type="button"
                    id="btn-create-fine"
                    class="btn btn-primary rounded-pill px-3"
                    style="font-weight:500;">
                + Create Fine
            </button>
        </div>

        <form id="create-fine-form"
            action="{{ route('admin.fines.store') }}"
            method="POST"
            style="display:none;">
            @csrf
            <input type="hidden" name="user_id">
            <input type="hidden" name="borrowing_id">
            <input type="hidden" name="reason">
            <input type="hidden" name="amount">
        </form>

        <!-- Body -->
        <div class="card-body px-4 pb-4">

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
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0 shadow-sm"
                       style="border-radius:10px; overflow:hidden;">

                    <thead style="background-color:#2c3e50; color:white;">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th class="text-start px-4">User</th>
                            <th class="text-start px-4">Book</th>
                            <th>Reason</th>
                            <th>Amount (RM)</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Paid At</th>
                            <th>Updated At</th>
                            <th>Handled By (Admin ID)</th>
                            <th style="width:260px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($fines as $fine)
                            @php
                                $user = $fine->user;
                                $borrowing = $fine->borrowHistory;
                                $book = $borrowing?->book;
                                $status = $fine->status;

                                $badgeClass = match($status) {
                                    'pending' => 'badge bg-warning text-dark',
                                    'unpaid'  => 'badge bg-danger',
                                    'paid'    => 'badge bg-success',
                                    'waived'  => 'badge bg-secondary',
                                    'reversed'=> 'badge bg-dark',
                                    default   => 'badge bg-light text-dark',
                                };
                            @endphp

                            <tr style="background-color:white;">
                                <td class="fw-semibold">{{ $fine->id }}</td>

                                <td class="text-start px-4">
                                    {{ $user->username ?? 'Unknown User' }}<br>
                                    @if(!empty($user?->phone))
                                        <small class="text-muted">{{ $user->phone }}</small>
                                    @endif
                                </td>

                                <td class="text-start px-4">
                                    {{ $book->book_name ?? 'Unknown Book' }}
                                </td>

                                <td>{{ ucfirst($fine->reason) }}</td>

                                <td class="fw-semibold">
                                    {{ number_format($fine->amount, 2) }}
                                </td>

                                <td>
                                    <span class="{{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                {{-- Created At --}}
                                <td>{{ $fine->created_at?->format('Y-m-d H:i:s') ?? '—' }}</td>

                                {{-- Paid At (to seconds) --}}
                                <td>
                                    @if($fine->paid_at)
                                        {{ $fine->paid_at->format('Y-m-d H:i:s') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                {{-- Updated At (to seconds) --}}
                                <td>
                                    @if($fine->updated_at)
                                        {{ $fine->updated_at->format('Y-m-d H:i:s') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                {{-- Handled By (admin id) --}}
                                <td>
                                    {{ $fine->handler?->username ?? '—' }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        @if($status === 'pending')
                                            {{-- Approve --}}
                                            <form action="{{ route('admin.fines.approve', $fine->id) }}"
                                                method="POST" class="m-0">
                                                @csrf
                                                <button type="button"
                                                        class="btn px-3 py-1 btn-approve-fine"
                                                        data-username="{{ $user->username ?? 'Unknown User' }}"
                                                        data-amount="{{ number_format($fine->amount, 2) }}"
                                                        style="background-color:#51CF66; color:white; border-radius:6px; font-weight:500;">
                                                    Approve Payment
                                                </button>
                                            </form>

                                            {{-- Reject --}}
                                            <form action="{{ route('admin.fines.reject', $fine->id) }}"
                                                method="POST" class="m-0">
                                                @csrf
                                                <button type="button"
                                                        class="btn px-3 py-1 btn-reject-fine"
                                                        data-username="{{ $user->username ?? 'Unknown User' }}"
                                                        data-amount="{{ number_format($fine->amount, 2) }}"
                                                        style="background-color:#FF6B6B; color:white; border-radius:6px; font-weight:500;">
                                                    Reject Request
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
                                <td colspan="11" class="text-center text-muted py-4">
                                    No fines found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $fines->links() }}
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

@php
    $fineUsers = $users->map(function ($u) {
        return [
            'id'       => $u->id,
            'username' => $u->username,
            'phone'    => $u->phone,
        ];
    });

    $fineBorrows = $borrows->map(function ($b) {
        return [
            'id'   => $b->id,
            'book' => $b->book->book_name ?? 'Unknown Book',
            'user' => $b->user->username ?? 'User',
        ];
    });
@endphp

@push('scripts')
    <script>
    const fineUsers   = @json($fineUsers);
    const fineBorrows = @json($fineBorrows);
    document.addEventListener('DOMContentLoaded', () => {
        // Approve button
        document.querySelectorAll('.btn-approve-fine').forEach(button => {
            button.addEventListener('click', e => {
                const form     = e.target.closest('form');
                const username = e.target.dataset.username || 'this user';
                const amount   = e.target.dataset.amount  || '0.00';

                Swal.fire({
                    title: 'Approve Fine Payment?',
                    html: `
                        <div style="margin-bottom: 10px; font-size:0.95rem; color:#4b5563;">
                            You are about to <strong>approve</strong> this fine for
                            <strong>${username}</strong>.
                        </div>
                        <div style="
                            display:inline-block;
                            padding:6px 14px;
                            border-radius:999px;
                            background:linear-gradient(90deg,#22c55e,#16a34a);
                            color:#fff;
                            font-size:1.2rem;
                            font-weight:700;
                            letter-spacing:0.02em;
                            margin-bottom:4px;
                        ">
                            RM ${amount}
                        </div>
                        <div style="margin-top:6px; font-size:0.9rem; color:#6b7280;">
                            This will mark the fine as <strong>Paid</strong>.
                        </div>
                    `,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, approve it',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Reject button
        document.querySelectorAll('.btn-reject-fine').forEach(button => {
            button.addEventListener('click', e => {
                const form     = e.target.closest('form');
                const username = e.target.dataset.username || 'this user';
                const amount   = e.target.dataset.amount  || '0.00';

                Swal.fire({
                    title: 'Reject Payment?',
                    html: `
                        <div style="margin-bottom: 10px; font-size:0.95rem; color:#4b5563;">
                            You are about to <strong>reject</strong> this fine payment for
                            <strong>${username}</strong>.
                        </div>
                        <div style="
                            display:inline-block;
                            padding:6px 14px;
                            border-radius:999px;
                            background:linear-gradient(90deg,#fb7185,#ef4444);
                            color:#fff;
                            font-size:1.2rem;
                            font-weight:700;
                            letter-spacing:0.02em;
                            margin-bottom:4px;
                        ">
                            RM ${amount}
                        </div>
                        <div style="margin-top:6px; font-size:0.9rem; color:#6b7280;">
                            The fine will return to <strong>Unpaid</strong> and the user can request payment again.
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, reject it',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        const createFineBtn = document.getElementById('btn-create-fine');

        if (createFineBtn) {
            createFineBtn.addEventListener('click', () => {
                Swal.fire({
                    width: 650,
                    title: `
                        <div style="font-size:1.8rem;font-weight:700;color:#2d3748;">
                            Create Manual Fine
                        </div>
                    `,
                    html: `
                        <style>
                            .fine-form-group{
                                text-align:left;
                                margin-bottom:16px;
                            }
                            .fine-label{
                                font-size:0.95rem;
                                font-weight:600;
                                margin-bottom:6px;
                                display:block;
                                color:#4a5568;
                            }
                            .fine-input,
                            .fine-select{
                                width:100%;
                                padding:11px 14px;
                                border-radius:12px;
                                border:1px solid #cbd5e0;
                                background:#f7fafc;
                                font-size:0.95rem;
                                transition:0.2s;
                            }
                            .fine-input:focus,
                            .fine-select:focus{
                                border-color:#6366f1;
                                background:#fff;
                                outline:none;
                                box-shadow:0 0 0 3px rgba(99,102,241,0.25);
                            }
                        </style>

                        <div class="fine-form-group">
                            <label class="fine-label">User</label>
                            <select id="swal-fine-user" class="fine-select">
                                <option value="">-- Select User --</option>
                            </select>
                        </div>

                        <div class="fine-form-group">
                            <label class="fine-label">Related Borrow (optional)</label>
                            <select id="swal-fine-borrow" class="fine-select">
                                <option value="">-- None --</option>
                            </select>
                        </div>

                        <div class="fine-form-group">
                            <label class="fine-label">Reason</label>
                            <select id="swal-fine-reason" class="fine-select">
                                <option value="lost">Lost Book</option>
                                <option value="damage">Damaged Book</option>
                                <option value="late">Late Return (Manual)</option>
                                <option value="manual">Other / Manual</option>
                                <option value="activate">Account Activation / Other</option>
                            </select>
                        </div>

                        <div class="fine-form-group">
                            <label class="fine-label">Amount (RM)</label>
                            <input id="swal-fine-amount"
                                type="number"
                                min="0.01"
                                step="0.01"
                                class="fine-input"
                                placeholder="e.g. 30.00">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Create Fine',
                    confirmButtonColor: '#4F46E5',
                    cancelButtonColor: '#6B7280',

                    didOpen: () => {
                        const userSelect   = document.getElementById('swal-fine-user');
                        const borrowSelect = document.getElementById('swal-fine-borrow');

                        // Fill users
                        userSelect.innerHTML = '<option value="">-- Select User --</option>';
                        fineUsers.forEach(u => {
                            const opt = document.createElement('option');
                            opt.value = u.id;
                            opt.textContent = `${u.username} (ID: ${u.id})`;
                            userSelect.appendChild(opt);
                        });

                        // When user changes → filter borrows
                        userSelect.addEventListener('change', () => {
                            const selectedUser = userSelect.value;

                            borrowSelect.innerHTML = '<option value="">-- None --</option>';

                            if (!selectedUser) return;

                            const userBorrows = fineBorrows.filter(b => b.user_id == selectedUser);

                            userBorrows.forEach(b => {
                                const opt = document.createElement('option');
                                opt.value = b.id;
                                opt.textContent = `#${b.id} — ${b.book || 'Unknown Book'}`;
                                borrowSelect.appendChild(opt);
                            });
                        });
                    },

                    preConfirm: () => {
                        const userId      = document.getElementById('swal-fine-user').value;
                        const borrowId    = document.getElementById('swal-fine-borrow').value;
                        const reason      = document.getElementById('swal-fine-reason').value;
                        const amountValue = document.getElementById('swal-fine-amount').value;

                        if (!userId) {
                            Swal.showValidationMessage('Please select a user.');
                            return false;
                        }
                        if (!amountValue || parseFloat(amountValue) <= 0) {
                            Swal.showValidationMessage('Please enter a valid amount (RM).');
                            return false;
                        }

                        return {
                            user_id:      userId,
                            borrowing_id: borrowId,
                            reason:       reason,
                            amount:       amountValue
                        };
                    }
                }).then(result => {
                    if (result.isConfirmed && result.value) {
                        const form = document.getElementById('create-fine-form');
                        form.querySelector('input[name="user_id"]').value      = result.value.user_id;
                        form.querySelector('input[name="borrowing_id"]').value = result.value.borrowing_id || '';
                        form.querySelector('input[name="reason"]').value       = result.value.reason;
                        form.querySelector('input[name="amount"]').value       = result.value.amount;
                        form.submit();
                    }
                });
            });
        }

    });
</script>
@endpush