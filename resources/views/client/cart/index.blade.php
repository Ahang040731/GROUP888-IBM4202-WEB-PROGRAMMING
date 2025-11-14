@extends('layouts.app')

@section('title', 'My Borrow Cart')

@section('content')

<div class="cart-container">
    <!-- Hero Section -->
    <div class="cart-hero">
        <div class="hero-background">
            <div class="hero-bg-image" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1920&q=80')"></div>
            <div class="hero-overlay"></div>
            <div class="floating-books">
                <div class="floating-book" style="--delay: 0s">📚</div>
                <div class="floating-book" style="--delay: 1s">🛒</div>
                <div class="floating-book" style="--delay: 2s">📖</div>
                <div class="floating-book" style="--delay: 1.5s">✨</div>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="cart-title animate-fade-in-up">
                <span class="title-gradient">My Borrow</span><br>
                <span class="title-highlight">Cart</span>
            </h1>
            <p class="cart-subtitle animate-fade-in-up-delay">
                Review your selected books before submitting a borrow request
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="cart-content">
        <!-- Warning for unavailable items -->
        @if($unavailableItems->count() > 0)
        <div class="warning-banner glass-effect animate-slide-down">
            <div class="warning-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="warning-content">
                <h3 class="warning-title">Some items are no longer available</h3>
                <p class="warning-text">
                    {{ $unavailableItems->count() }} {{ $unavailableItems->count() > 1 ? 'items have' : 'item has' }} insufficient copies. Please remove them or adjust quantities.
                </p>
            </div>
        </div>
        @endif

        @if($cartItems->count() > 0)
        <div class="cart-grid">
            <!-- Cart Items Column -->
            <div class="cart-items-column">
                <div class="items-header glass-effect">
                    <div class="header-content">
                        <h2 class="items-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Cart Items
                            <span class="items-count">{{ $cartItems->count() }}/10</span>
                        </h2>
                        @if($cartItems->count() > 0)
                        <form action="{{ route('client.cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="clear-cart-btn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Clear Cart
                            </button>
                        </form>
                        @endif
                    </div>
                    <a href="{{ route('client.books.index') }}" class="continue-browsing-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Continue Browsing
                    </a>
                </div>

                <div class="cart-items-list">
                    @foreach($cartItems as $index => $item)
                    <div class="cart-item glass-effect {{ !$item->isAvailable() ? 'unavailable' : '' }}" style="--delay: {{ $index * 0.1 }}s">
                        <!-- Book Cover -->
                        <a href="{{ route('client.books.show', $item->book) }}" class="item-cover-link">
                            @if($item->book->photo)
                                <img src="{{ $item->book->photo }}" alt="{{ $item->book->book_name }}" class="item-cover">
                            @else
                                <div class="item-cover-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </a>

                        <!-- Item Details -->
                        <div class="item-details">
                            <a href="{{ route('client.books.show', $item->book) }}" class="item-title-link">
                                <h3 class="item-title">{{ $item->book->book_name }}</h3>
                            </a>
                            <p class="item-author">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $item->book->author }}
                            </p>

                            <div class="item-meta">
                                @if($item->book->category)
                                <span class="item-category">
                                    @switch($item->book->category)
                                        @case('Fiction') 📖 @break
                                        @case('Science') 🔬 @break
                                        @case('History') 📜 @break
                                        @case('Technology') 💻 @break
                                        @case('Fantasy') 🧙 @break
                                        @case('Mystery') 🔍 @break
                                        @default 📚
                                    @endswitch
                                    {{ $item->book->category }}
                                </span>
                                @endif
                                <span class="item-year">{{ $item->book->published_year }}</span>
                            </div>

                            <!-- Availability Status -->
                            @if($item->isAvailable())
                                <div class="availability-badge success">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $item->book->available_copies }} copies available
                                </div>
                            @else
                                <div class="availability-badge danger">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Only {{ $item->book->available_copies }} available (requested {{ $item->quantity }})
                                </div>
                            @endif
                        </div>

                        <!-- Item Actions -->
                        <div class="item-actions">
                            <!-- Quantity Selector -->
                            <form action="{{ route('client.cart.update', $item) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PATCH')
                                <label class="quantity-label">Copies:</label>
                                <select name="quantity" onchange="this.form.submit()" class="quantity-select">
                                    @for($i = 1; $i <= min(3, $item->book->available_copies); $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </form>

                            <!-- Remove Button -->
                            <form action="{{ route('client.cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this book from cart?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="summary-column">
                <div class="summary-card glass-effect sticky-summary">
                    <h2 class="summary-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Borrow Summary
                    </h2>

                    <div class="summary-details">
                        <div class="summary-item">
                            <span class="summary-label">Total Books</span>
                            <span class="summary-value">{{ $cartItems->count() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Copies</span>
                            <span class="summary-value">{{ $cartItems->sum('quantity') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Borrow Period</span>
                            <span class="summary-value">7 days</span>
                        </div>
                    </div>

                    @if($unavailableItems->count() > 0)
                    <div class="summary-warning">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p>Please remove unavailable items before proceeding</p>
                    </div>
                    <button class="submit-btn disabled" disabled>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cannot Submit Request
                    </button>
                    @else
                    <form id="borrowRequestForm" action="{{ route('client.cart.submit') }}" method="POST">
                        @csrf
                        <button type="button" id="submitBorrowBtn" class="submit-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Borrow Request
                        </button>
                    </form>
                    @endif

                    <p class="summary-note">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        You can borrow up to 3 copies per book and have a maximum of 10 items in your cart
                    </p>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart State -->
        <div class="empty-cart glass-effect">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="empty-title">Your cart is empty</h3>
            <p class="empty-subtitle">Start browsing books and add them to your cart to create a borrow request</p>
            <a href="{{ route('client.books.index') }}" class="browse-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Browse Books
            </a>
        </div>
        @endif
    </div>
</div>

<style>
/* ==================== BASE STYLES ==================== */
.cart-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow-x: hidden;
}

/* ==================== HERO SECTION ==================== */
.cart-hero {
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

.floating-books {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.floating-book {
    position: absolute;
    font-size: 2.5rem;
    opacity: 0.12;
    animation: float 15s ease-in-out infinite;
    animation-delay: var(--delay, 0s);
}

.floating-book:nth-child(1) { top: 10%; left: 10%; }
.floating-book:nth-child(2) { top: 20%; right: 15%; }
.floating-book:nth-child(3) { bottom: 20%; left: 20%; }
.floating-book:nth-child(4) { bottom: 15%; right: 10%; }

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

.cart-title {
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

.cart-subtitle {
    font-size: clamp(1rem, 2vw, 1.125rem);
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* ==================== MAIN CONTENT ==================== */
.cart-content {
    max-width: 1400px;
    margin: -30px auto 60px;
    padding: 0 20px;
    position: relative;
    z-index: 3;
}

/* ==================== WARNING BANNER ==================== */
.warning-banner {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    background: rgba(254, 243, 199, 0.98);
    border-left: 4px solid #f59e0b;
    border-radius: 16px;
    margin-bottom: 24px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.warning-icon {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    color: #f59e0b;
}

.warning-icon svg {
    width: 100%;
    height: 100%;
}

.warning-content {
    flex: 1;
}

.warning-title {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 4px;
}

.warning-text {
    font-size: 0.875rem;
    color: #78350f;
}

/* ==================== CART GRID ==================== */
.cart-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 32px;
    align-items: start;
}

/* ==================== ITEMS HEADER ==================== */
.items-header {
    padding: 24px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    margin-bottom: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.items-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #1f2937;
}

.items-title svg {
    width: 28px;
    height: 28px;
    color: #667eea;
}

.items-count {
    font-size: 0.875rem;
    padding: 4px 12px;
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #7c3aed;
    border-radius: 50px;
    font-weight: 700;
}

.clear-cart-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
    border: none;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.clear-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}

.clear-cart-btn svg {
    width: 16px;
    height: 16px;
}

.continue-browsing-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.continue-browsing-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.continue-browsing-btn svg {
    width: 20px;
    height: 20px;
}

/* ==================== CART ITEMS LIST ==================== */
.cart-items-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cart-item {
    display: grid;
    grid-template-columns: 120px 1fr auto;
    gap: 20px;
    padding: 24px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

.cart-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.cart-item.unavailable {
    background: linear-gradient(135deg, rgba(254, 242, 242, 0.98) 0%, rgba(254, 226, 226, 0.98) 100%);
    border: 2px solid #fecaca;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.item-cover-link {
    display: block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.item-cover-link:hover {
    transform: scale(1.05);
}

.item-cover {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    display: block;
}

.item-cover-placeholder {
    width: 100%;
    aspect-ratio: 2/3;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.item-cover-placeholder svg {
    width: 48px;
    height: 48px;
    color: rgba(255, 255, 255, 0.5);
}

.item-details {
    flex: 1;
    min-width: 0;
}

.item-title-link {
    text-decoration: none;
}

.item-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
    line-height: 1.3;
    transition: color 0.2s ease;
}

.item-title-link:hover .item-title {
    color: #667eea;
}

.item-author {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 12px;
}

.item-author svg {
    width: 16px;
    height: 16px;
}

.item-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.item-category {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 12px;
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #7c3aed;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
}

.item-year {
    font-size: 0.75rem;
    color: #9ca3af;
    font-weight: 600;
}

.availability-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.availability-badge svg {
    width: 16px;
    height: 16px;
}

.availability-badge.success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.availability-badge.danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.item-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: flex-end;
}

.quantity-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quantity-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
}

.quantity-select {
    padding: 8px 12px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.remove-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
    border: none;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.remove-btn svg {
    width: 16px;
    height: 16px;
}

/* ==================== SUMMARY SIDEBAR ==================== */
.summary-card {
    padding: 28px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.sticky-summary {
    position: sticky;
    top: 24px;
}

.summary-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.375rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 24px;
}

.summary-title svg {
    width: 26px;
    height: 26px;
    color: #667eea;
}

.summary-details {
    padding: 20px 0;
    border-top: 2px solid #f3f4f6;
    border-bottom: 2px solid #f3f4f6;
    margin-bottom: 20px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
}

.summary-label {
    font-size: 0.9375rem;
    color: #6b7280;
    font-weight: 600;
}

.summary-value {
    font-size: 1.125rem;
    color: #1f2937;
    font-weight: 800;
}

.summary-warning {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-radius: 12px;
    margin-bottom: 16px;
}

.summary-warning svg {
    width: 20px;
    height: 20px;
    color: #dc2626;
    flex-shrink: 0;
    margin-top: 2px;
}

.summary-warning p {
    font-size: 0.875rem;
    color: #991b1b;
    font-weight: 600;
    line-height: 1.5;
}

.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.submit-btn:hover::before {
    width: 300px;
    height: 300px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

.submit-btn svg {
    width: 22px;
    height: 22px;
}

.submit-btn.disabled {
    background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
    cursor: not-allowed;
}

.submit-btn.disabled:hover {
    transform: none;
    box-shadow: none;
}

.summary-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 16px;
    padding: 12px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 10px;
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.5;
}

.summary-note svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    margin-top: 1px;
}

/* ==================== EMPTY CART ==================== */
.empty-cart {
    text-align: center;
    padding: 80px 40px;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 24px;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
}

.empty-icon svg {
    width: 60px;
    height: 60px;
    color: white;
}

.empty-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 12px;
}

.empty-subtitle {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 32px;
    line-height: 1.6;
}

.browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.browse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.browse-btn svg {
    width: 22px;
    height: 22px;
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

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
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

.animate-slide-down {
    animation: slideDown 0.6s ease-out;
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 1024px) {
    .cart-grid {
        grid-template-columns: 1fr;
    }

    .sticky-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-hero {
        min-height: 35vh;
        padding: 60px 16px 40px;
    }

    .cart-title {
        font-size: 2rem;
    }

    .items-header {
        padding: 20px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .continue-browsing-btn {
        width: 100%;
        justify-content: center;
    }

    .cart-item {
        grid-template-columns: 100px 1fr;
        gap: 16px;
    }

    .item-actions {
        grid-column: 1 / -1;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .summary-card {
        padding: 24px;
    }
}

@media (max-width: 480px) {
    .cart-item {
        grid-template-columns: 1fr;
    }

    .item-cover-link {
        max-width: 200px;
        margin: 0 auto;
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

<!-- Flash Messages -->
@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="fixed bottom-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('info') }}
    </div>
@endif

<script>
// Auto-hide flash messages
setTimeout(() => {
    const messages = document.querySelectorAll('.fixed.bottom-4');
    messages.forEach(msg => {
        msg.style.transition = 'opacity 0.5s';
        msg.style.opacity = '0';
        setTimeout(() => msg.remove(), 500);
    });
}, 3000);

// Handle borrow request submission with SweetAlert
document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.getElementById('submitBorrowBtn');
    const form = document.getElementById('borrowRequestForm');

    if (submitBtn && form) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                if (confirm('Submit borrow request? This will send your request to the admin for approval.')) {
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Submit Borrow Request?',
                html: `
                    <p class="text-gray-600 mb-2">Your request will be sent to the admin for approval.</p>
                    <p class="text-sm text-gray-500">Once approved, you can collect the books from the library.</p>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, submit request!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }
});
</script>
@endsection
