@extends('layouts.app')

@section('title', 'Favourites')

@section('content')

<div class="favourites-container">
    <!-- Hero Section -->
    <div class="favourites-hero">
        <div class="hero-background">
            <div class="hero-bg-image" style="background-image: url('https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=1920&q=80')"></div>
            <div class="hero-overlay"></div>
            <div class="floating-icons">
                <div class="floating-icon" style="--delay: 0s">❤️</div>
                <div class="floating-icon" style="--delay: 1s">📚</div>
                <div class="floating-icon" style="--delay: 2s">⭐</div>
                <div class="floating-icon" style="--delay: 1.5s">💖</div>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="favourites-title animate-fade-in-up">
                <span class="title-gradient">Your Favourite</span><br>
                <span class="title-highlight">Books</span>
            </h1>
            <p class="favourites-subtitle animate-fade-in-up-delay">
                {{ method_exists($books, 'total') ? $books->total() : $books->count() }} books saved to your collection
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="favourites-content">
        @if(($books ?? collect())->isEmpty())
            <div class="empty-state glass-effect">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No favourites yet</h3>
                <p class="empty-subtitle">Start adding books to your favourites to build your collection</p>
                <a href="{{ route('client.books.index') }}" class="browse-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Browse Books
                </a>
            </div>
        @else
            <div class="books-grid">
                @foreach($books as $index => $book)
                <div class="book-card glass-effect animate-book-reveal" style="--delay: {{ ($index % 12) * 0.05 }}s">
                    <div class="book-image-container">
                        @php
                            $src = null;
                            if (!empty($book->photo)) {
                                $src = Str::startsWith($book->photo, ['http://','https://'])
                                        ? $book->photo
                                        : asset('storage/'.$book->photo);
                            }
                        @endphp

                        @if($src)
                            <img src="{{ $src }}" alt="{{ $book->book_name }}" class="book-image" loading="lazy">
                        @else
                            <div class="book-placeholder">
                                <div class="placeholder-content">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>{{ Str::limit($book->book_name, 20) }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="book-overlay"></div>

                        <!-- Status Badge -->
                        @if(isset($book->available_copies, $book->total_copies))
                            <div class="book-status {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                                <span class="status-dot"></span>
                                <span>{{ $book->available_copies > 0 ? 'Available' : 'Out of Stock' }}</span>
                            </div>
                        @endif

                        <!-- Favourite Button -->
                        <form method="POST" action="{{ route('favourites.toggle', $book->id) }}" class="favourite-form">
                            @csrf
                            <button type="submit" class="favourite-btn active">
                                <svg fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="book-details">
                        @if(!empty($book->category))
                        <div class="book-category-badge">
                            <span class="category-icon">
                                @switch($book->category)
                                    @case('Fiction') 📖 @break
                                    @case('Science') 🔬 @break
                                    @case('History') 📜 @break
                                    @case('Technology') 💻 @break
                                    @case('Fantasy') 🧙 @break
                                    @case('Mystery') 🔍 @break
                                    @default 📚
                                @endswitch
                            </span>
                            <span>{{ $book->category }}</span>
                        </div>
                        @endif

                        <h3 class="book-title" title="{{ $book->book_name }}">
                            {{ Str::limit($book->book_name, 40) }}
                        </h3>

                        @if(!empty($book->author))
                        <p class="book-author">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $book->author }}
                        </p>
                        @endif

                        <a href="{{ route('client.books.show', $book->id) }}" class="view-details-btn">
                            <span>View Details</span>
                            <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($books, 'links'))
            <div class="pagination-wrapper">
                {{ $books->links() }}
            </div>
            @endif
        @endif
    </div>
</div>

<style>
/* ==================== BASE STYLES ==================== */
.favourites-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow-x: hidden;
}

/* ==================== HERO SECTION ==================== */
.favourites-hero {
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

.favourites-title {
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

.favourites-subtitle {
    font-size: clamp(1rem, 2vw, 1.125rem);
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* ==================== MAIN CONTENT ==================== */
.favourites-content {
    max-width: 1400px;
    margin: -30px auto 60px;
    padding: 0 20px;
    position: relative;
    z-index: 3;
}

/* ==================== BOOKS GRID ==================== */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
    margin-bottom: 48px;
}

.book-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.book-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
}

.book-image-container {
    position: relative;
    padding-top: 140%;
    overflow: hidden;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
}

.book-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.book-card:hover .book-image {
    transform: scale(1.1);
}

.book-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.book-card:hover .book-overlay {
    opacity: 1;
}

.book-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.placeholder-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 20px;
    text-align: center;
}

.placeholder-content svg {
    width: 70px;
    height: 70px;
    color: rgba(255, 255, 255, 0.5);
}

.placeholder-content span {
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.book-status {
    position: absolute;
    top: 14px;
    left: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 2;
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

.book-status.available {
    background: rgba(16, 185, 129, 0.95);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.book-status.available .status-dot {
    background: #ffffff;
}

.book-status.unavailable {
    background: rgba(239, 68, 68, 0.95);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.book-status.unavailable .status-dot {
    background: #ffffff;
}

.favourite-form {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 2;
}

.favourite-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.favourite-btn:hover {
    transform: scale(1.15);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
}

.favourite-btn svg {
    width: 20px;
    height: 20px;
    color: #d1d5db;
}

.favourite-btn.active svg {
    color: #ef4444;
}

.book-details {
    padding: 22px;
}

.book-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #7c3aed;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    margin-bottom: 12px;
    border: 1px solid rgba(124, 58, 237, 0.2);
}

.category-icon {
    font-size: 0.9rem;
}

.book-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    line-height: 1.4;
    min-height: 48px;
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
    margin-bottom: 18px;
}

.book-author svg {
    width: 15px;
    height: 15px;
}

.view-details-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.875rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.view-details-btn::before {
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

.view-details-btn:hover::before {
    width: 300px;
    height: 300px;
}

.view-details-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
}

.arrow-icon {
    width: 18px;
    height: 18px;
    transition: transform 0.3s ease;
}

.view-details-btn:hover .arrow-icon {
    transform: translateX(3px);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
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
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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

/* ==================== PAGINATION ==================== */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
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

@keyframes bookReveal {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-fade-in-up-delay {
    animation: fadeInUp 0.8s ease-out 0.2s backwards;
}

.animate-book-reveal {
    animation: bookReveal 0.6s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 1024px) {
    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
}

@media (max-width: 768px) {
    .favourites-hero {
        min-height: 40vh;
        padding: 60px 16px 40px;
    }

    .favourites-title {
        font-size: 2rem;
    }

    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .books-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .favourites-title {
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
