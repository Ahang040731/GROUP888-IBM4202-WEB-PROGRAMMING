@extends('layouts.app')

@section('title', 'Borrow History')

@section('content')

<div class="history-container">
    <!-- Hero Section -->
    <div class="history-hero">
        <div class="hero-background">
            <div class="hero-bg-image" style="background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&q=80')"></div>
            <div class="hero-overlay"></div>
            <div class="floating-icons">
                <div class="floating-icon" style="--delay: 0s">📚</div>
                <div class="floating-icon" style="--delay: 1s">📖</div>
                <div class="floating-icon" style="--delay: 2s">⏱️</div>
                <div class="floating-icon" style="--delay: 1.5s">✅</div>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="history-title animate-fade-in-up">
                <span class="title-gradient">Borrow &</span><br>
                <span class="title-highlight">Return History</span>
            </h1>
            <p class="history-subtitle animate-fade-in-up-delay">
                Track your borrowed books and manage your returns
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="history-content">
        <!-- Current Borrow Section -->
        <section class="borrow-section">
            <div class="section-header glass-effect">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Current Borrows
                    @if(!$current->isEmpty())
                        <span class="count-badge">{{ $current->count() }}</span>
                    @endif
                </h2>
            </div>

            @if($current->isEmpty())
                <div class="empty-state glass-effect">
                    <div class="empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">No current borrows</h3>
                    <p class="empty-subtitle">You don't have any active borrowing records</p>
                    <a href="{{ route('client.books.index') }}" class="browse-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Browse Books
                    </a>
                </div>
            @else
                <div class="borrow-list">
                    @foreach($current as $index => $row)
                        @php
                            $book = $row->book ?? null;
                            $copy = $row->copy ?? null;
                            $isPending = $row->approve_status === 'pending';

                            if ($isPending) {
                                $badgeClass = 'status-badge pending';
                                $badgeText  = 'Pending Approval';
                            } elseif ($row->status === 'overdue' || $row->is_overdue) {
                                $badgeClass = 'status-badge overdue';
                                $badgeText  = 'Overdue';
                            } else {
                                $badgeClass = 'status-badge active';
                                $badgeText  = 'Active';
                            }
                        @endphp

                        <div class="borrow-card glass-effect animate-slide-in" style="--delay: {{ $index * 0.1 }}s">
                            <!-- Book Cover -->
                            <div class="card-cover">
                                @if($book?->photo)
                                    <img src="{{ $book->photo }}" alt="{{ $book->book_name }}" class="cover-image">
                                @else
                                    <div class="cover-placeholder">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Content -->
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="title-section">
                                        <h3 class="book-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                                        <p class="book-author">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $book->author ?? 'Unknown Author' }}
                                        </p>
                                    </div>
                                    <div class="{{ $badgeClass }}">
                                        <span class="status-dot"></span>
                                        {{ $badgeText }}
                                    </div>
                                </div>

                                <div class="copy-barcode">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    Copy: {{ $copy->barcode ?? $row->copy_id }}
                                </div>

                                <div class="card-meta">
                                    <div class="meta-item">
                                        <span class="meta-label">Borrowed</span>
                                        <span class="meta-value">{{ $row->borrow_date }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Due Date</span>
                                        <span class="meta-value due-date">{{ $row->due_date }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Extensions</span>
                                        <span class="meta-value">{{ $row->extension_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Actions -->
                            @if(is_null($row->returned_at))
                            <div class="card-actions">
                                @if($isPending)
                                    <form method="POST" action="{{ route('client.borrowhistory.cancel', $row->id) }}" class="cancel-form">
                                        @csrf
                                        <button type="button" class="action-btn cancel-btn cancel-request-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Cancel Request
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('client.borrowhistory.extend', $row->id) }}" class="extend-form">
                                        @csrf
                                        <button type="button" class="action-btn extend-btn extend-request-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Request Extension
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Previous Borrow Section -->
        <section class="borrow-section">
            <div class="section-header glass-effect">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Previous Borrows
                    @if(!$previous->isEmpty())
                        <span class="count-badge">{{ $previous->total() }}</span>
                    @endif
                </h2>
            </div>

            @if($previous->isEmpty())
                <div class="empty-state glass-effect">
                    <div class="empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">No previous borrows</h3>
                    <p class="empty-subtitle">Your borrowing history will appear here</p>
                </div>
            @else
                <div class="borrow-list">
                    @foreach($previous as $index => $row)
                        @php
                            $book = $row->book ?? null;
                            $copy = $row->copy ?? null;
                            $status = $row->status;
                            $isPending = $row->approve_status === 'pending';

                            if ($isPending) {
                                $badgeClass = 'status-badge pending';
                                $badgeText  = 'Pending';
                            } elseif ($status === 'lost') {
                                $badgeClass = 'status-badge lost';
                                $badgeText  = 'Lost / Missing';
                            } elseif ($status === 'returned') {
                                $badgeClass = 'status-badge returned';
                                $badgeText  = 'Returned';
                            } elseif ($row->is_overdue) {
                                $badgeClass = 'status-badge overdue';
                                $badgeText  = 'Late Return';
                            } else {
                                $badgeClass = 'status-badge active';
                                $badgeText  = ucfirst($status);
                            }
                        @endphp

                        <div class="borrow-card glass-effect animate-slide-in" style="--delay: {{ $index * 0.1 }}s">
                            <!-- Book Cover -->
                            <div class="card-cover">
                                @if($book?->photo)
                                    <img src="{{ $book->photo }}" alt="{{ $book->book_name }}" class="cover-image">
                                @else
                                    <div class="cover-placeholder">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Content -->
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="title-section">
                                        <h3 class="book-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                                        <p class="book-author">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $book->author ?? 'Unknown Author' }}
                                        </p>
                                    </div>
                                    <div class="{{ $badgeClass }}">
                                        <span class="status-dot"></span>
                                        {{ $badgeText }}
                                    </div>
                                </div>

                                <div class="copy-barcode">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    Copy: {{ $copy->barcode ?? $row->copy_id }}
                                </div>

                                <div class="card-meta">
                                    <div class="meta-item">
                                        <span class="meta-label">Borrowed</span>
                                        <span class="meta-value">{{ $row->borrow_date }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Due Date</span>
                                        <span class="meta-value">{{ $row->due_date }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Returned</span>
                                        <span class="meta-value">{{ $row->returned_date ?? '—' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Late Days</span>
                                        <span class="meta-value {{ $row->late_days > 0 ? 'late' : '' }}">{{ $row->late_days }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $previous->links() }}
                </div>
            @endif
        </section>
    </div>
</div>

<style>
/* ==================== BASE STYLES ==================== */
.history-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow-x: hidden;
}

/* ==================== HERO SECTION ==================== */
.history-hero {
    position: relative;
    min-height: 45vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 20px 60px;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    inset: 0;
    z-index: 0;
}

.hero-bg-image {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    animation: kenburns 20s ease-in-out infinite alternate;
}

@keyframes kenburns {
    0% { transform: scale(1) translateY(0); }
    100% { transform: scale(1.1) translateY(-10px); }
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,
        rgba(102, 126, 234, 0.95) 0%,
        rgba(118, 75, 162, 0.92) 50%,
        rgba(102, 126, 234, 0.95) 100%);
    backdrop-filter: blur(2px);
}

.floating-icons {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.floating-icon {
    position: absolute;
    font-size: 2.5rem;
    opacity: 0.12;
    animation: float 15s ease-in-out infinite;
    animation-delay: var(--delay, 0s);
}

.floating-icon:nth-child(1) { top: 10%; left: 10%; }
.floating-icon:nth-child(2) { top: 20%; right: 15%; }
.floating-icon:nth-child(3) { bottom: 20%; left: 20%; }
.floating-icon:nth-child(4) { bottom: 15%; right: 10%; }

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-30px) rotate(5deg); }
    50% { transform: translateY(-20px) rotate(-5deg); }
    75% { transform: translateY(-40px) rotate(3deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.history-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 900;
    color: white;
    margin-bottom: 16px;
    line-height: 1.2;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.title-gradient {
    background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.title-highlight {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.history-subtitle {
    font-size: clamp(1rem, 2vw, 1.125rem);
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* ==================== MAIN CONTENT ==================== */
.history-content {
    max-width: 1400px;
    margin: -30px auto 60px;
    padding: 0 20px;
    position: relative;
    z-index: 3;
}

/* ==================== SECTION ==================== */
.borrow-section {
    margin-bottom: 48px;
}

.section-header {
    padding: 24px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    margin-bottom: 24px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.75rem;
    font-weight: 800;
    color: #1f2937;
}

.section-title svg {
    width: 32px;
    height: 32px;
    color: #667eea;
}

.count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 700;
    margin-left: auto;
}

/* ==================== BORROW LIST ==================== */
.borrow-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 24px;
}

.borrow-card {
    display: flex;
    flex-direction: column;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    animation: slideIn 0.6s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

.borrow-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-cover {
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
}

.cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.borrow-card:hover .cover-image {
    transform: scale(1.1);
}

.cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.cover-placeholder svg {
    width: 60px;
    height: 60px;
    color: rgba(255, 255, 255, 0.5);
}

.card-content {
    flex: 1;
    padding: 24px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 16px;
}

.title-section {
    flex: 1;
    min-width: 0;
}

.book-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.book-author {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #6b7280;
}

.book-author svg {
    width: 16px;
    height: 16px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    animation: pulse-dot 2s ease-in-out infinite;
}

@keyframes pulse-dot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.8; }
}

.status-badge.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-badge.pending .status-dot {
    background: #f59e0b;
}

.status-badge.active {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.status-badge.active .status-dot {
    background: #3b82f6;
}

.status-badge.overdue {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.status-badge.overdue .status-dot {
    background: #ef4444;
}

.status-badge.returned {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-badge.returned .status-dot {
    background: #10b981;
}

.status-badge.lost {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #3730a3;
}

.status-badge.lost .status-dot {
    background: #6366f1;
}

.copy-barcode {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 12px;
    font-size: 0.8125rem;
    color: #4b5563;
    font-weight: 600;
    font-family: 'Courier New', monospace;
    margin-bottom: 16px;
}

.copy-barcode svg {
    width: 18px;
    height: 18px;
    color: #667eea;
}

.card-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px;
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.meta-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-value {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #1f2937;
}

.meta-value.due-date {
    color: #667eea;
}

.meta-value.late {
    color: #ef4444;
}

.card-actions {
    padding: 16px 24px;
    border-top: 1px solid #f3f4f6;
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn svg {
    width: 18px;
    height: 18px;
}

.extend-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.extend-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
}

.cancel-btn {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
}

.cancel-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(220, 38, 38, 0.3);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 60px 40px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
}

.empty-icon svg {
    width: 50px;
    height: 50px;
    color: white;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 8px;
}

.empty-subtitle {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 24px;
}

.browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.browse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
}

.browse-btn svg {
    width: 20px;
    height: 20px;
}

/* ==================== PAGINATION ==================== */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 32px;
}

/* ==================== UTILITY CLASSES ==================== */
.glass-effect {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-fade-in-up-delay {
    animation: fadeInUp 0.8s ease-out 0.2s backwards;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 1024px) {
    .borrow-list {
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    }
}

@media (max-width: 768px) {
    .history-hero {
        min-height: 35vh;
        padding: 60px 16px 40px;
    }

    .history-title {
        font-size: 2rem;
    }

    .section-header {
        padding: 20px;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .borrow-list {
        grid-template-columns: 1fr;
    }

    .card-meta {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 480px) {
    .history-title {
        font-size: 1.75rem;
    }

    .card-content {
        padding: 20px;
    }

    .card-actions {
        padding: 12px 20px;
    }
}

/* ==================== ACCESSIBILITY ==================== */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Handle "Extend" button popup
    document.querySelectorAll('.extend-request-btn').forEach(button => {
        button.addEventListener('click', e => {
            const form = e.target.closest('.extend-form');

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                if (confirm('Send extension request? This will request additional time from the admin.')) {
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Extend Borrow Duration?',
                text: 'This will send an extension request for approval.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, send request!',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // Handle "Cancel Request" button popup
    document.querySelectorAll('.cancel-request-btn').forEach(button => {
        button.addEventListener('click', e => {
            const form = e.target.closest('.cancel-form');

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                if (confirm('Cancel this borrow request? This action cannot be undone.')) {
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Cancel Borrow Request?',
                text: 'Your pending request will be cancelled.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'Keep it'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endpush
