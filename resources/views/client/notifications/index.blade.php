@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="notifications-container">
    <!-- Header -->
    <div class="notifications-header">
        <h1 class="notifications-title">📬 Notifications</h1>
        <p class="notifications-subtitle">Stay updated with your library activities</p>
        @if($notificationCount > 0)
            <div class="notification-badge-large">{{ $notificationCount }} notification{{ $notificationCount > 1 ? 's' : '' }}</div>
        @else
            <div class="all-clear-badge">✓ All clear!</div>
        @endif
    </div>

    <!-- Overdue Books Alert -->
    @if($overdueBooks->count() > 0)
    <div class="notification-section urgent">
        <div class="section-header">
            <div class="section-icon urgent">🚨</div>
            <h2 class="section-title">Overdue Books ({{ $overdueBooks->count() }})</h2>
        </div>
        <div class="notification-list">
            @foreach($overdueBooks as $borrow)
                <div class="notification-card urgent">
                    <div class="notification-content">
                        <div class="notification-icon-wrapper urgent">
                            @if($borrow->book->photo)
                                <img src="{{ $borrow->book->photo }}" alt="{{ $borrow->book->book_name }}" class="notification-book-img">
                            @else
                                <div class="notification-icon">📕</div>
                            @endif
                        </div>
                        <div class="notification-details">
                            <h3 class="notification-book-title">{{ $borrow->book->book_name }}</h3>
                            <p class="notification-text">Due: {{ \Carbon\Carbon::parse($borrow->due_at)->format('M d, Y') }}</p>
                            <p class="notification-subtext urgent">⚠️ {{ $borrow->late_days }} day(s) overdue</p>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('client.borrowhistory.index') }}" class="btn-notification urgent">Return Now</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Unpaid Fines -->
    @if($unpaidFines->count() > 0)
    <div class="notification-section warning">
        <div class="section-header">
            <div class="section-icon warning">💰</div>
            <h2 class="section-title">Unpaid Fines ({{ $unpaidFines->count() }})</h2>
        </div>
        <div class="notification-list">
            @foreach($unpaidFines as $fine)
                <div class="notification-card warning">
                    <div class="notification-content">
                        <div class="notification-icon-wrapper warning">
                            <div class="notification-icon">💳</div>
                        </div>
                        <div class="notification-details">
                            <h3 class="notification-book-title">{{ $fine->borrowHistory->book->book_name ?? 'Fine Payment' }}</h3>
                            <p class="notification-text">Amount: RM {{ number_format($fine->amount, 2) }}</p>
                            <p class="notification-subtext">
                                Status: 
                                @if($fine->status === 'unpaid')
                                    <span class="status-badge unpaid">Unpaid</span>
                                @else
                                    <span class="status-badge pending">Pending Approval</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="notification-actions">
                        @if($fine->status === 'unpaid')
                            <a href="{{ route('fines.index') }}" class="btn-notification warning">Pay Now</a>
                        @else
                            <span class="btn-notification disabled">Awaiting Approval</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Active Books (Due Soon) -->
    @if($activeBooks->count() > 0)
    <div class="notification-section info">
        <div class="section-header">
            <div class="section-icon info">📚</div>
            <h2 class="section-title">Books to Return ({{ $activeBooks->count() }})</h2>
        </div>
        <div class="notification-list">
            @foreach($activeBooks as $borrow)
                @php
                    $dueDate = \Carbon\Carbon::parse($borrow->due_at);
                    $daysUntilDue = now()->diffInDays($dueDate, false);
                    $isDueSoon = $daysUntilDue <= 3 && $daysUntilDue >= 0;
                @endphp
                <div class="notification-card {{ $isDueSoon ? 'warning' : 'info' }}">
                    <div class="notification-content">
                        <div class="notification-icon-wrapper {{ $isDueSoon ? 'warning' : 'info' }}">
                            @if($borrow->book->photo)
                                <img src="{{ $borrow->book->photo }}" alt="{{ $borrow->book->book_name }}" class="notification-book-img">
                            @else
                                <div class="notification-icon">📖</div>
                            @endif
                        </div>
                        <div class="notification-details">
                            <h3 class="notification-book-title">{{ $borrow->book->book_name }}</h3>
                            <p class="notification-text">Borrowed: {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('M d, Y') }}</p>
                            <p class="notification-subtext {{ $isDueSoon ? 'warning' : '' }}">
                                @if($borrow->status === 'overdue')
                                    ⚠️ Overdue by {{ abs($daysUntilDue) }} day(s)
                                @elseif($isDueSoon)
                                    ⏰ Due in {{ $daysUntilDue }} day(s)
                                @else
                                    📅 Due: {{ $dueDate->format('M d, Y') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('client.borrowhistory.index') }}" class="btn-notification {{ $isDueSoon ? 'warning' : 'info' }}">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Pending Borrow Requests -->
    @if($pendingRequests->count() > 0)
    <div class="notification-section info">
        <div class="section-header">
            <div class="section-icon info">⏳</div>
            <h2 class="section-title">Pending Requests ({{ $pendingRequests->count() }})</h2>
        </div>
        <div class="notification-list">
            @foreach($pendingRequests as $borrow)
                <div class="notification-card info">
                    <div class="notification-content">
                        <div class="notification-icon-wrapper info">
                            @if($borrow->book->photo)
                                <img src="{{ $borrow->book->photo }}" alt="{{ $borrow->book->book_name }}" class="notification-book-img">
                            @else
                                <div class="notification-icon">📗</div>
                            @endif
                        </div>
                        <div class="notification-details">
                            <h3 class="notification-book-title">{{ $borrow->book->book_name }}</h3>
                            <p class="notification-text">Requested: {{ \Carbon\Carbon::parse($borrow->created_at)->format('M d, Y') }}</p>
                            <p class="notification-subtext"><span class="status-badge pending">Awaiting Approval</span></p>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('client.borrowhistory.index') }}" class="btn-notification info">View Status</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Empty State -->
    @if($notificationCount === 0)
    <div class="empty-notifications">
        <div class="empty-icon">🎉</div>
        <h2 class="empty-title">You're All Caught Up!</h2>
        <p class="empty-text">No notifications at the moment. Keep exploring our library!</p>
        <a href="{{ route('client.books.index') }}" class="btn-browse">Browse Books</a>
    </div>
    @endif
</div>

<style>
    .notifications-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 32px 20px;
    }

    .notifications-header {
        text-align: center;
        margin-bottom: 48px;
        background: white;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .notifications-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .notifications-subtitle {
        font-size: 1.125rem;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .notification-badge-large {
        display: inline-block;
        padding: 8px 20px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 24px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .all-clear-badge {
        display: inline-block;
        padding: 8px 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 24px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .notification-section {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .notification-section.urgent {
        border-left: 4px solid #ef4444;
    }

    .notification-section.warning {
        border-left: 4px solid #f59e0b;
    }

    .notification-section.info {
        border-left: 4px solid #3b82f6;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f3f4f6;
    }

    .section-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .section-icon.urgent {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }

    .section-icon.warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }

    .section-icon.info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .notification-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .notification-card.urgent {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    }

    .notification-card.urgent:hover {
        border-color: #ef4444;
        transform: translateX(4px);
    }

    .notification-card.warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }

    .notification-card.warning:hover {
        border-color: #f59e0b;
        transform: translateX(4px);
    }

    .notification-card.info {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }

    .notification-card.info:hover {
        border-color: #3b82f6;
        transform: translateX(4px);
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }

    .notification-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .notification-icon-wrapper.urgent {
        background: white;
        border: 2px solid #ef4444;
    }

    .notification-icon-wrapper.warning {
        background: white;
        border: 2px solid #f59e0b;
    }

    .notification-icon-wrapper.info {
        background: white;
        border: 2px solid #3b82f6;
    }

    .notification-book-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .notification-details {
        flex: 1;
    }

    .notification-book-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .notification-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .notification-subtext {
        font-size: 0.875rem;
        color: #9ca3af;
        font-weight: 600;
    }

    .notification-subtext.urgent {
        color: #dc2626;
    }

    .notification-subtext.warning {
        color: #d97706;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.unpaid {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .notification-actions {
        flex-shrink: 0;
    }

    .btn-notification {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        font-size: 0.875rem;
    }

    .btn-notification.urgent {
        background: #ef4444;
        color: white;
    }

    .btn-notification.urgent:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-notification.warning {
        background: #f59e0b;
        color: white;
    }

    .btn-notification.warning:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-notification.info {
        background: #3b82f6;
        color: white;
    }

    .btn-notification.info:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-notification.disabled {
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-notifications {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 24px;
    }

    .empty-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 1.125rem;
        color: #6b7280;
        margin-bottom: 32px;
    }

    .btn-browse {
        display: inline-block;
        padding: 12px 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .notification-actions {
            width: 100%;
        }

        .btn-notification {
            width: 100%;
            text-align: center;
        }

        .notifications-title {
            font-size: 2rem;
        }
    }
</style>
@endsection