@extends('layouts.app')

@section('title', 'Fines')

@section('content')

<div class="fines-container">
    <!-- Hero Section -->
    <div class="fines-hero">
        <div class="hero-background">
            <div class="hero-bg-image" style="background-image: url('https://images.unsplash.com/photo-1554224311-beee460c201f?w=1920&q=80')"></div>
            <div class="hero-overlay"></div>
            <div class="floating-icons">
                <div class="floating-icon" style="--delay: 0s">💰</div>
                <div class="floating-icon" style="--delay: 1s">📋</div>
                <div class="floating-icon" style="--delay: 2s">⚠️</div>
                <div class="floating-icon" style="--delay: 1.5s">💳</div>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="fines-title animate-fade-in-up">
                <span class="title-gradient">Manage Your</span><br>
                <span class="title-highlight">Fines</span>
            </h1>
            <p class="fines-subtitle animate-fade-in-up-delay">
                View and pay your library fines
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="fines-content">
        <!-- Current Unpaid Fines Section -->
        <section class="fines-section">
            <div class="section-header glass-effect">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Unpaid Fines
                    @if(!$current->isEmpty())
                        <span class="count-badge danger">{{ $current->count() }}</span>
                    @endif
                </h2>
            </div>

            @if($current->isEmpty())
                <div class="empty-state glass-effect">
                    <div class="empty-icon success">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">No unpaid fines</h3>
                    <p class="empty-subtitle">You're all clear! Keep up the good work returning books on time</p>
                </div>
            @else
                <div class="fines-grid">
                    @foreach($current as $index => $fine)
                        @php
                            $borrowing = $fine->borrowHistory;
                            $book      = $borrowing?->book;
                            $status    = $fine->status;
                            $reason    = $fine->reason;

                            [$statusLabel, $badgeClass] = match (true) {
                                $reason === 'lost' && $status === 'unpaid'  => ['Lost (Unpaid)',  'status-badge lost'],
                                $reason === 'lost' && $status === 'pending' => ['Lost (Pending)', 'status-badge pending'],
                                $reason === 'lost' && $status === 'paid'    => ['Lost (Paid)',    'status-badge paid'],
                                $status === 'unpaid'  => ['Unpaid',  'status-badge unpaid'],
                                $status === 'pending' => ['Pending', 'status-badge pending'],
                                default               => [ucfirst($status), 'status-badge'],
                            };
                        @endphp

                        <div class="fine-card glass-effect animate-slide-in" style="--delay: {{ $index * 0.1 }}s">
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

                                <!-- Amount Badge -->
                                <div class="amount-badge">
                                    RM {{ number_format($fine->amount, 2) }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="title-section">
                                        <h3 class="book-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                                    </div>
                                    <div class="{{ $badgeClass }}">
                                        <span class="status-dot"></span>
                                        {{ $statusLabel }}
                                    </div>
                                </div>

                                <div class="fine-details">
                                    <div class="detail-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="detail-label">Reason:</span>
                                        <span class="detail-value">{{ ucfirst($fine->reason) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="detail-label">Created:</span>
                                        <span class="detail-value">{{ $fine->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Actions -->
                            <div class="card-actions">
                                @php
                                    $borrowing   = $fine->borrowHistory;
                                    $isLost      = $borrowing && $borrowing->status === 'lost';
                                    $mustReturn  = $borrowing
                                                  && $borrowing->returned_at === null
                                                  && !$isLost;
                                @endphp

                                @if($mustReturn)
                                    <button class="action-btn disabled" disabled>
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        Return Book First
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('fines.pay', $fine->id) }}" class="pay-form w-full">
                                        @csrf
                                        <input type="hidden" name="method" value="cash">
                                        <button type="button" class="action-btn pay pay-btn" data-amount="{{ number_format($fine->amount, 2) }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Pay Fine
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Previous Fines Section -->
        <section class="fines-section">
            <div class="section-header glass-effect">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Previous Fines
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
                    <h3 class="empty-title">No previous fines</h3>
                    <p class="empty-subtitle">Your fine history will appear here</p>
                </div>
            @else
                <div class="fines-grid">
                    @foreach($previous as $index => $fine)
                        @php
                            $borrowing = $fine->borrowHistory;
                            $book      = $borrowing?->book;
                            $status    = $fine->status;
                            $reason    = $fine->reason;

                            $badgeClass = match($status) {
                                'paid'     => 'status-badge paid',
                                'waived'   => 'status-badge waived',
                                'reversed' => 'status-badge reversed',
                                default    => 'status-badge',
                            };

                            $label = $reason === 'lost'
                                ? 'Lost (' . ucfirst($status) . ')'
                                : ucfirst($status);
                        @endphp

                        <div class="fine-card glass-effect animate-slide-in" style="--delay: {{ $index * 0.1 }}s">
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

                                <!-- Amount Badge -->
                                <div class="amount-badge success">
                                    RM {{ number_format($fine->amount, 2) }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="title-section">
                                        <h3 class="book-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                                    </div>
                                    <div class="{{ $badgeClass }}">
                                        <span class="status-dot"></span>
                                        {{ $label }}
                                    </div>
                                </div>

                                <div class="fine-details">
                                    <div class="detail-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="detail-label">Reason:</span>
                                        <span class="detail-value">{{ ucfirst($fine->reason) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="detail-label">Paid:</span>
                                        <span class="detail-value">{{ $fine->paid_at?->format('d M Y') ?? '—' }}</span>
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
.fines-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow-x: hidden;
}

/* ==================== HERO SECTION ==================== */
.fines-hero {
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

.fines-title {
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

.fines-subtitle {
    font-size: clamp(1rem, 2vw, 1.125rem);
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* ==================== MAIN CONTENT ==================== */
.fines-content {
    max-width: 1400px;
    margin: -30px auto 60px;
    padding: 0 20px;
    position: relative;
    z-index: 3;
}

/* ==================== SECTION ==================== */
.fines-section {
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

.count-badge.danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* ==================== FINES GRID ==================== */
.fines-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 24px;
}

.fine-card {
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

.fine-card:hover {
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
    height: 200px;
    overflow: hidden;
    position: relative;
}

.cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.fine-card:hover .cover-image {
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

.amount-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 800;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    backdrop-filter: blur(10px);
}

.amount-badge.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
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
    margin-bottom: 20px;
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

.status-badge.unpaid {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.status-badge.unpaid .status-dot {
    background: #ef4444;
}

.status-badge.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-badge.pending .status-dot {
    background: #f59e0b;
}

.status-badge.paid {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-badge.paid .status-dot {
    background: #10b981;
}

.status-badge.waived {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.status-badge.waived .status-dot {
    background: #3b82f6;
}

.status-badge.reversed {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #3730a3;
}

.status-badge.reversed .status-dot {
    background: #6366f1;
}

.status-badge.lost {
    background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
    color: #831843;
}

.status-badge.lost .status-dot {
    background: #ec4899;
}

.fine-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 12px;
}

.detail-item svg {
    width: 18px;
    height: 18px;
    color: #667eea;
    flex-shrink: 0;
}

.detail-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
}

.detail-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 700;
    margin-left: auto;
}

.card-actions {
    padding: 20px 24px;
    border-top: 1px solid #f3f4f6;
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
}

.w-full {
    width: 100%;
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 20px;
    border: none;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn svg {
    width: 20px;
    height: 20px;
}

.action-btn.pay {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.action-btn.pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
}

.action-btn.disabled {
    background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
    color: white;
    cursor: not-allowed;
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

.empty-icon.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
    .fines-grid {
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    }
}

@media (max-width: 768px) {
    .fines-hero {
        min-height: 35vh;
        padding: 60px 16px 40px;
    }

    .fines-title {
        font-size: 2rem;
    }

    .section-header {
        padding: 20px;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .fines-grid {
        grid-template-columns: 1fr;
    }

    .card-content {
        padding: 20px;
    }

    .card-actions {
        padding: 16px 20px;
    }
}

@media (max-width: 480px) {
    .fines-title {
        font-size: 1.75rem;
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
    document.querySelectorAll('.pay-btn').forEach(button => {
        button.addEventListener('click', e => {
            const form   = e.target.closest('.pay-form');
            const amount = e.target.dataset.amount || '0.00';

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                if (confirm(`Pay RM ${amount}? Please select a payment method.`)) {
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Confirm Fine Payment',
                html: `
                    <div style="font-size:0.95rem; color:#4b5563;">
                        <div style="margin-bottom:6px;">You are about to pay:</div>
                        <div style="
                            display:inline-block;
                            padding:6px 14px;
                            border-radius:999px;
                            background:linear-gradient(90deg,#10b981,#059669);
                            color:#fff;
                            font-size:1.4rem;
                            font-weight:700;
                            letter-spacing:0.02em;
                            margin-bottom:8px;
                        ">
                            RM ${amount}
                        </div>
                    </div>
                `,
                icon: 'info',
                input: 'select',
                inputOptions: {
                    credit:          'Credit Balance',
                    tng:             "Touch 'n Go",
                    card:            'Debit / Credit Card',
                    online_banking:  'Online Banking',
                    cash:            'Cash at Counter'
                },
                inputValue: 'credit',
                inputLabel: 'Payment Method',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Confirm Payment',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please select a payment method.';
                    }
                }
            }).then(result => {
                if (result.isConfirmed) {
                    let methodInput = form.querySelector('input[name="method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = 'method';
                        form.appendChild(methodInput);
                    }
                    methodInput.value = result.value;
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
