@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<div class="dashboard-container">
    <!-- Hero Section with Parallax Background -->
    <div class="hero-section" id="hero">
        <div class="hero-background">
            <div class="hero-bg-image" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1920&q=80')"></div>
            <div class="hero-overlay"></div>
            <div class="floating-books">
                <div class="floating-book" style="--delay: 0s">📚</div>
                <div class="floating-book" style="--delay: 1s">📖</div>
                <div class="floating-book" style="--delay: 2s">📕</div>
                <div class="floating-book" style="--delay: 1.5s">📗</div>
                <div class="floating-book" style="--delay: 0.5s">📘</div>
            </div>
        </div>
        
        <div class="hero-content">
            <div class="hero-badge animate-fade-in">
                <span class="badge-icon">✨</span>
                <span>Welcome to Your Digital Library</span>
            </div>
            
            <h1 class="hero-title animate-fade-in-up">
                <span class="title-gradient">Discover Your Next</span><br>
                <span class="title-highlight">Great Adventure</span>
            </h1>
            
            <p class="hero-subtitle animate-fade-in-up-delay">
                Explore thousands of books across all genres. Your next favorite story awaits.
            </p>
            
            <!-- Enhanced Search Panel -->
            <div class="search-panel animate-scale-in">
                <form action="{{ route('client.homepage.index') }}" method="GET" class="search-form">
                    <div class="search-main">
                        <div class="search-input-wrapper">
                            <div class="search-icon-wrapper">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                class="search-input" 
                                placeholder="Search by title, author, ISBN, or category..."
                                value="{{ request('search') }}"
                            >
                            <button type="submit" class="search-btn-inline">
                                <span>Search</span>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="filter-grid">
                        <div class="filter-item">
                            <label class="filter-label">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Category
                            </label>
                            <select name="category" class="filter-select">
                                <option value="">All Categories</option>
                                <option value="Fiction" {{ request('category') == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                <option value="Non-Fiction" {{ request('category') == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                <option value="Science" {{ request('category') == 'Science' ? 'selected' : '' }}>Science</option>
                                <option value="History" {{ request('category') == 'History' ? 'selected' : '' }}>History</option>
                                <option value="Technology" {{ request('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Biography" {{ request('category') == 'Biography' ? 'selected' : '' }}>Biography</option>
                                <option value="Fantasy" {{ request('category') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                <option value="Mystery" {{ request('category') == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                            </select>
                        </div>
                        
                        <div class="filter-item">
                            <label class="filter-label">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                </svg>
                                Sort By
                            </label>
                            <select name="sort" class="filter-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Container -->
    <div class="stats-container">
        <div class="stat-card glass-effect animate-slide-up" style="--delay: 0.1s">
            <div class="stat-icon-wrapper gradient-purple">
                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Books</p>
                <h3 class="stat-number" data-count="{{ $totalBooks ?? 0 }}">0</h3>
                <div class="stat-trend">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>Available</span>
                </div>
            </div>
        </div>

        <div class="stat-card glass-effect animate-slide-up" style="--delay: 0.2s">
            <div class="stat-icon-wrapper gradient-pink">
                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Borrowed</p>
                <h3 class="stat-number" data-count="{{ $borrowedCount ?? 0 }}">0</h3>
                <div class="stat-trend active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Active</span>
                </div>
            </div>
        </div>

        <div class="stat-card glass-effect animate-slide-up" style="--delay: 0.3s">
            <div class="stat-icon-wrapper gradient-orange">
                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Favorites</p>
                <h3 class="stat-number" data-count="{{ $favoritesCount ?? 0 }}">0</h3>
                <div class="stat-trend favorite">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>Saved</span>
                </div>
            </div>
        </div>

        <div class="stat-card glass-effect animate-slide-up" style="--delay: 0.4s">
            <div class="stat-icon-wrapper gradient-green">
                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Your Credit</p>
                <h3 class="stat-number">RM {{ number_format($userCredit, 2) }}</h3>
                <div class="stat-trend credit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Balance</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Section -->
    <div class="books-section">
        <div class="section-header animate-fade-in">
            <div class="section-title-wrapper">
                <h2 class="section-title">Featured Books</h2>
                <div class="section-decorator"></div>
            </div>
            <p class="section-subtitle">
                <span class="result-count">{{ isset($books) ? $books->total() : 0 }}</span> 
                amazing books waiting for you
            </p>
        </div>

        @if(isset($books) && $books->count() > 0)
        <div class="books-grid">
            @foreach($books as $index => $book)
            <div class="book-card glass-effect animate-book-reveal" style="--delay: {{ ($index % 12) * 0.05 }}s">
                <div class="book-image-container">
                    @if($book->photo)
                        <img src="{{ $book->photo }}" alt="{{ $book->book_name }}" class="book-image" loading="lazy">
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
                    <div class="book-status {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                        <span class="status-dot"></span>
                        <span>{{ $book->available_copies > 0 ? 'Available' : 'Out of Stock' }}</span>
                    </div>
                    
                    <!-- Favourite Button -->
                    <form action="{{ route('favourites.toggle', $book->id) }}" method="POST" class="favourite-form">
                        @csrf
                        <button type="submit" class="favourite-btn {{ $book->is_favorited ? 'active' : '' }}" aria-label="Add to favorites">
                            <svg class="heart-icon" fill="{{ $book->is_favorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <div class="heart-particles">
                                <span class="particle"></span>
                                <span class="particle"></span>
                                <span class="particle"></span>
                            </div>
                        </button>
                    </form>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <a href="{{ route('client.books.show', $book->id) }}" class="quick-action-btn" aria-label="Quick view">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="book-details">
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

                    <h3 class="book-title" title="{{ $book->book_name }}">
                        {{ Str::limit($book->book_name, 35) }}
                    </h3>
                    
                    <p class="book-author">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $book->author }}
                    </p>

                    <div class="book-meta">
                        <div class="book-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="star {{ $i <= ($book->rating ?? 0) ? 'filled' : '' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="rating-value">{{ number_format($book->rating ?? 0, 1) }}</span>
                        </div>
                        
                        <div class="book-copies">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>{{ $book->available_copies }}/{{ $book->total_copies }}</span>
                        </div>
                    </div>

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

        <!-- Enhanced Pagination -->
        <div class="pagination-wrapper">
            {{ $books->links() }}
        </div>
        @else
        <div class="empty-state glass-effect">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="empty-title">No books found</h3>
            <p class="empty-subtitle">Try adjusting your search criteria or filters</p>
            <a href="{{ route('client.homepage.index') }}" class="reset-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset Filters
            </a>
        </div>
        @endif
    </div>
</div>

<style>
/* ==================== BASE STYLES ==================== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow-x: hidden;
}

/* ==================== HERO SECTION ==================== */
.hero-section {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
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
    font-size: 3rem;
    opacity: 0.15;
    animation: float 15s ease-in-out infinite;
    animation-delay: var(--delay, 0s);
}

.floating-book:nth-child(1) { top: 10%; left: 10%; }
.floating-book:nth-child(2) { top: 20%; right: 15%; }
.floating-book:nth-child(3) { bottom: 20%; left: 20%; }
.floating-book:nth-child(4) { bottom: 15%; right: 10%; }
.floating-book:nth-child(5) { top: 50%; left: 5%; }

@keyframes float {
    0%, 100% { 
        transform: translateY(0) rotate(0deg);
    }
    25% {
        transform: translateY(-30px) rotate(5deg);
    }
    50% { 
        transform: translateY(-20px) rotate(-5deg);
    }
    75% {
        transform: translateY(-40px) rotate(3deg);
    }
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 1000px;
    width: 100%;
    text-align: center;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.badge-icon {
    font-size: 1.2rem;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.2) rotate(180deg); }
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 900;
    color: white;
    margin-bottom: 24px;
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
    position: relative;
    display: inline-block;
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.title-highlight::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, #FFD700, transparent);
    border-radius: 2px;
    animation: shine 3s ease-in-out infinite;
}

@keyframes shine {
    0%, 100% { opacity: 0.5; transform: scaleX(0.8); }
    50% { opacity: 1; transform: scaleX(1); }
}

.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 48px;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* ==================== SEARCH PANEL ==================== */
.search-panel {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.search-main {
    position: relative;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.search-icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 20px;
}

.search-icon {
    width: 24px;
    height: 24px;
    color: #667eea;
}

.search-input {
    flex: 1;
    padding: 18px 0;
    border: none;
    font-size: 1rem;
    color: #1f2937;
    background: transparent;
}

.search-input:focus {
    outline: none;
}

.search-input::placeholder {
    color: #9ca3af;
}

.search-btn-inline {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.search-btn-inline:hover {
    background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
    transform: translateX(2px);
}

.search-btn-inline svg {
    width: 20px;
    height: 20px;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
}

.filter-label svg {
    width: 16px;
    height: 16px;
}

.filter-select {
    padding: 14px 16px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    font-size: 0.9375rem;
    color: #1f2937;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

/* ==================== STATS CONTAINER ==================== */
.stats-container {
    max-width: 1400px;
    margin: -80px auto 60px;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
    position: relative;
    z-index: 3;
}

.stat-card {
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    padding: 28px;
    display: flex;
    gap: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, var(--card-color, #667eea), transparent);
    transform: scaleX(0);
    transition: transform 0.6s ease;
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.glass-effect {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
}

.stat-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}

.stat-icon-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    background: inherit;
    opacity: 0.1;
    animation: pulse-ring 2s ease-out infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 0; }
    100% { transform: scale(1.4); opacity: 0; }
}

.gradient-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.gradient-pink {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.gradient-orange {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.gradient-green {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
}

.stat-icon {
    width: 32px;
    height: 32px;
    color: white;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.stat-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    color: #1f2937;
    line-height: 1;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    color: #10b981;
    font-weight: 600;
}

.stat-trend svg {
    width: 16px;
    height: 16px;
}

.stat-trend.active {
    color: #f59e0b;
}

.stat-trend.favorite {
    color: #ef4444;
}

.stat-trend.credit {
    color: #8b5cf6;
}

/* ==================== BOOKS SECTION ==================== */
.books-section {
    max-width: 1400px;
    margin: 0 auto 80px;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 48px;
}

.section-title-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 16px;
}

.section-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.section-decorator {
    height: 4px;
    background: linear-gradient(90deg, transparent, #FFD700, transparent);
    margin-top: 12px;
    border-radius: 2px;
    animation: expand 2s ease-in-out infinite;
}

@keyframes expand {
    0%, 100% { transform: scaleX(0.8); opacity: 0.5; }
    50% { transform: scaleX(1); opacity: 1; }
}

.section-subtitle {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.9);
}

.result-count {
    font-weight: 700;
    color: #FFD700;
}

/* ==================== BOOKS GRID ==================== */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 32px;
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
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 50%);
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
    width: 80px;
    height: 80px;
    color: rgba(255, 255, 255, 0.5);
}

.placeholder-content span {
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.book-status {
    position: absolute;
    top: 16px;
    right: 16px;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 2;
}

.status-dot {
    width: 8px;
    height: 8px;
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
    top: 16px;
    left: 16px;
    z-index: 2;
}

.favourite-btn {
    position: relative;
    width: 48px;
    height: 48px;
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
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.heart-icon {
    width: 24px;
    height: 24px;
    color: #ef4444;
    transition: all 0.3s ease;
}

.favourite-btn.active .heart-icon {
    animation: heartbeat 0.6s ease-in-out;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(1); }
    75% { transform: scale(1.2); }
}

.heart-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #ef4444;
    border-radius: 50%;
    opacity: 0;
}

.favourite-btn.active .particle {
    animation: particle-burst 0.8s ease-out;
}

.favourite-btn.active .particle:nth-child(1) {
    animation-delay: 0s;
    top: 0;
    left: 50%;
}

.favourite-btn.active .particle:nth-child(2) {
    animation-delay: 0.1s;
    top: 50%;
    right: 0;
}

.favourite-btn.active .particle:nth-child(3) {
    animation-delay: 0.2s;
    bottom: 0;
    left: 50%;
}

@keyframes particle-burst {
    0% {
        transform: translate(0, 0) scale(0);
        opacity: 1;
    }
    100% {
        transform: translate(var(--x, 0), var(--y, -30px)) scale(1);
        opacity: 0;
    }
}

.quick-actions {
    position: absolute;
    bottom: 80px;
    right: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 2;
}

.book-card:hover .quick-actions {
    opacity: 1;
    transform: translateX(0);
}

.quick-action-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.quick-action-btn:hover {
    transform: scale(1.15);
    background: #667eea;
    color: white;
}

.quick-action-btn svg {
    width: 20px;
    height: 20px;
}

.book-details {
    padding: 24px;
}

.book-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #7c3aed;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 12px;
    border: 1px solid rgba(124, 58, 237, 0.2);
}

.category-icon {
    font-size: 1rem;
}

.book-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    line-height: 1.4;
    min-height: 50px;
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
    margin-bottom: 16px;
}

.book-author svg {
    width: 16px;
    height: 16px;
}

.book-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-top: 1px solid #f3f4f6;
    border-bottom: 1px solid #f3f4f6;
    margin-bottom: 20px;
}

.book-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    width: 16px;
    height: 16px;
    color: #d1d5db;
    transition: all 0.3s ease;
}

.star.filled {
    color: #fbbf24;
    filter: drop-shadow(0 0 2px rgba(251, 191, 36, 0.5));
}

.rating-value {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1f2937;
}

.book-copies {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
}

.book-copies svg {
    width: 16px;
    height: 16px;
}

.view-details-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9375rem;
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
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.arrow-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
}

.view-details-btn:hover .arrow-icon {
    transform: translateX(4px);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 80px 40px;
    border-radius: 20px;
    max-width: 500px;
    margin: 0 auto;
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
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
}

.empty-subtitle {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 32px;
}

.reset-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.reset-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.reset-btn svg {
    width: 20px;
    height: 20px;
}

/* ==================== PAGINATION ==================== */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 48px;
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
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

.animate-fade-in {
    animation: fadeIn 0.8s ease-out;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-fade-in-up-delay {
    animation: fadeInUp 0.8s ease-out 0.2s backwards;
}

.animate-scale-in {
    animation: scaleIn 1s ease-out 0.4s backwards;
}

.animate-slide-up {
    animation: slideUp 0.8s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

.animate-book-reveal {
    animation: bookReveal 0.6s ease-out backwards;
    animation-delay: var(--delay, 0s);
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 1024px) {
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 70vh;
        padding: 40px 16px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
        margin-bottom: 32px;
    }
    
    .search-panel {
        padding: 24px;
    }
    
    .search-input-wrapper {
        flex-direction: column;
    }
    
    .search-btn-inline {
        width: 100%;
        justify-content: center;
        padding: 14px;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-container {
        margin-top: -60px;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .stat-card {
        padding: 20px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    
    .book-details {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .hero-badge {
        font-size: 0.75rem;
        padding: 8px 16px;
    }
    
    .hero-title {
        font-size: 1.75rem;
    }
    
    .search-panel {
        padding: 20px;
    }
    
    .books-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
    }
    
    .stat-icon {
        width: 28px;
        height: 28px;
    }
    
    .stat-number {
        font-size: 1.875rem;
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

.search-input:focus,
.filter-select:focus,
.search-btn-inline:focus,
.view-details-btn:focus,
.favourite-btn:focus,
.quick-action-btn:focus,
.reset-btn:focus {
    outline: 3px solid rgba(102, 126, 234, 0.5);
    outline-offset: 2px;
}

/* ==================== PRINT STYLES ==================== */
@media print {
    .hero-section,
    .search-panel,
    .stats-container,
    .favourite-btn,
    .quick-actions,
    .book-status {
        display: none;
    }
    
    .dashboard-container {
        background: white;
    }
    
    .book-card {
        break-inside: avoid;
        page-break-inside: avoid;
        box-shadow: none;
        border: 1px solid #e5e7eb;
    }
    
    .books-grid {
        gap: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== COUNTER ANIMATION ====================
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000;
        const steps = 60;
        const increment = target / steps;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, duration / steps);
    };
    
    // Intersection Observer for stat counters
    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('.stat-number[data-count]').forEach(stat => {
        statObserver.observe(stat);
    });
    
    // ==================== PARALLAX EFFECT ====================
    let ticking = false;
    
    const handleScroll = () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('.hero-bg-image');
                const heroOverlay = document.querySelector('.hero-overlay');
                
                if (hero) {
                    const rate = scrolled * 0.5;
                    hero.style.transform = `translateY(${rate}px)`;
                }
                
                if (heroOverlay) {
                    const opacity = Math.min(scrolled / 300, 1);
                    heroOverlay.style.background = `linear-gradient(135deg, 
                        rgba(102, 126, 234, ${0.95 + opacity * 0.05}) 0%, 
                        rgba(118, 75, 162, ${0.92 + opacity * 0.08}) 50%,
                        rgba(102, 126, 234, ${0.95 + opacity * 0.05}) 100%)`;
                }
                
                ticking = false;
            });
            
            ticking = true;
        }
    };
    
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // ==================== BOOK CARD ANIMATIONS ====================
    const bookObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0) scale(1)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    document.querySelectorAll('.book-card').forEach(card => {
        bookObserver.observe(card);
    });
    
    // ==================== FAVORITE BUTTON HANDLER ====================
    document.querySelectorAll('.favourite-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('.favourite-btn');
            button.style.pointerEvents = 'none';
            
            // Add loading state
            button.classList.add('loading');
            
            setTimeout(() => {
                button.style.pointerEvents = 'auto';
                button.classList.remove('loading');
            }, 1000);
        });
    });
    
    // ==================== SEARCH INPUT FOCUS ====================
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            const wrapper = this.closest('.search-input-wrapper');
            wrapper.style.transform = 'scale(1.01)';
        });
        
        searchInput.addEventListener('blur', function() {
            const wrapper = this.closest('.search-input-wrapper');
            wrapper.style.transform = 'scale(1)';
        });
    }
    
    // ==================== SMOOTH SCROLL ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ==================== RIPPLE EFFECT ====================
    const createRipple = (event) => {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const diameter = Math.max(rect.width, rect.height);
        const radius = diameter / 2;
        
        ripple.style.width = ripple.style.height = `${diameter}px`;
        ripple.style.left = `${event.clientX - rect.left - radius}px`;
        ripple.style.top = `${event.clientY - rect.top - radius}px`;
        ripple.classList.add('ripple-effect');
        
        const existingRipple = button.querySelector('.ripple-effect');
        if (existingRipple) {
            existingRipple.remove();
        }
        
        button.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    };
    
    document.querySelectorAll('.view-details-btn, .search-btn-inline, .reset-btn').forEach(btn => {
        btn.addEventListener('click', createRipple);
    });
    
    // ==================== LAZY LOADING IMAGES ====================
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.src;
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
    
    // ==================== STAR RATING HOVER ====================
    document.querySelectorAll('.book-rating').forEach(rating => {
        const stars = rating.querySelectorAll('.star');
        
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.style.transform = 'scale(1.2)';
                    }
                });
            });
            
            star.addEventListener('mouseleave', () => {
                stars.forEach(s => {
                    s.style.transform = 'scale(1)';
                });
            });
        });
    });
    
    // ==================== BOOK CARD TILT EFFECT ====================
    document.querySelectorAll('.book-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
    
    // ==================== PERFORMANCE OPTIMIZATION ====================
    // Debounce function for expensive operations
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };
    
    // Throttle function for scroll events
    const throttle = (func, limit) => {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };
});

// ==================== ADDITIONAL RIPPLE STYLES ====================
const style = document.createElement('style');
style.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .favourite-btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid #ef4444;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>

@endsection