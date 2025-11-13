@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

  <!-- I DONT KNOW WHY THIS SHIT CALL DASHBOARD YOUR TASK SHOULD BE USER SIDE HOMEPAGE by heng-->
  <!-- DASHBOARD should be done by yongjie Admin side -->

<div class="dashboard-container">
    <!-- Hero Section with Search -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title animate-fade-in">Discover Your Next Great Read</h1>
            <p class="hero-subtitle animate-fade-in-delay">Explore our collection of amazing books</p>
            
            <!-- Search Panel -->
            <div class="search-panel animate-slide-up">
                <form action="{{ route('client.homepage.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input" 
                            placeholder="Search by title, author, or category..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    
                    <div class="filter-group">
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
                        
                        <select name="sort" class="filter-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                        </select>
                        
                        <button type="submit" class="search-btn">
                            <span>Search</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-container">
        <div class="stat-card animate-scale-in" style="animation-delay: 0.1s">
            <div class="stat-icon books">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalBooks ?? 0 }}</h3>
                <p class="stat-label">Total Books</p>
            </div>
        </div>

        <div class="stat-card animate-scale-in" style="animation-delay: 0.2s">
            <div class="stat-icon borrowed">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $borrowedCount ?? 0 }}</h3>
                <p class="stat-label">Currently Borrowed</p>
            </div>
        </div>

        <div class="stat-card animate-scale-in" style="animation-delay: 0.3s">
            <div class="stat-icon favorites">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $favoritesCount ?? 0 }}</h3>
                <p class="stat-label">Favorites</p>
            </div>
        </div>

        <div class="stat-card animate-scale-in" style="animation-delay: 0.4s">
            <div class="stat-icon credit">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">RM {{ number_format(auth()->user()->credit ?? 0, 2) }}</h3>
                <p class="stat-label">Your Credit</p>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="books-section">
        <div class="section-header">
            <h2 class="section-title">Available Books</h2>
            <p class="section-subtitle">{{ isset($books) ? $books->total() : 0 }} books found</p>
        </div>

        @if(isset($books) && $books->count() > 0)
        <div class="books-grid">
            @foreach($books as $index => $book)
            <div class="book-card animate-fade-in-up" style="animation-delay: {{ ($index % 12) * 0.05 }}s">
                <div class="book-image-wrapper">
                    @if($book->photo)
                        <img src="{{ $book->photo }}" alt="{{ $book->book_name }}" class="book-image">
                    @else
                        <div class="book-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Book Status Badge -->
                    <div class="book-badge {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                        {{ $book->available_copies > 0 ? 'Available' : 'Unavailable' }}
                    </div>
                    
                    <!-- Favorite Button -->
                    <form action="{{ route('favorites.toggle', $book->id) }}" method="POST" class="favorite-form">
                        @csrf
                        <button type="submit" class="favorite-btn {{ $book->is_favorited ? 'active' : '' }}">
                            <svg fill="{{ $book->is_favorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="book-content">
                    <div class="book-category">{{ $book->category }}</div>
                    <h3 class="book-title">{{ Str::limit($book->book_name, 40) }}</h3>
                    <p class="book-author">by {{ $book->author }}</p>
                    
                    <div class="book-meta">
                        <div class="book-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= ($book->rating ?? 0) ? 'filled' : '' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                            <span class="rating-text">{{ number_format($book->rating ?? 0, 1) }}</span>
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
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $books->links() }}
        </div>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3>No books found</h3>
            <p>Try adjusting your search or filters</p>
        </div>
        @endif
    </div>
</div>

<style>
.dashboard-container {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding-bottom: 60px;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
    padding: 80px 20px 120px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    text-align: center;
    margin-bottom: 16px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    text-align: center;
    margin-bottom: 48px;
}

/* Search Panel */
.search-panel {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 900px;
    margin: 0 auto;
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.search-input-wrapper {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    color: #9ca3af;
}

.search-input {
    width: 100%;
    padding: 16px 16px 16px 52px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.filter-group {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 12px;
}

.filter-select {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 14px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #667eea;
}

.search-btn {
    padding: 12px 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

/* Stats Container */
.stats-container {
    max-width: 1200px;
    margin: -60px auto 60px;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    position: relative;
    z-index: 2;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon svg {
    width: 32px;
    height: 32px;
    color: white;
}

.stat-icon.books {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon.borrowed {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.favorites {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.stat-icon.credit {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

/* Books Section */
.books-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-header {
    margin-bottom: 32px;
    text-align: center;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
}

.section-subtitle {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Books Grid */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 32px;
    margin-bottom: 48px;
}

.book-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.book-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
}

.book-image-wrapper {
    position: relative;
    padding-top: 140%;
    background: #f3f4f6;
    overflow: hidden;
}

.book-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.book-card:hover .book-image {
    transform: scale(1.05);
}

.book-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.book-placeholder svg {
    width: 80px;
    height: 80px;
    color: white;
    opacity: 0.5;
}

.book-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.book-badge.available {
    background: #10b981;
    color: white;
}

.book-badge.unavailable {
    background: #ef4444;
    color: white;
}

.favorite-form {
    position: absolute;
    top: 12px;
    left: 12px;
}

.favorite-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.favorite-btn svg {
    width: 20px;
    height: 20px;
    color: #ef4444;
}

.favorite-btn:hover {
    transform: scale(1.1);
}

.favorite-btn.active {
    background: white;}

.favorite-btn.active svg {
    color: #ef4444;
}

.book-content {
    padding: 20px;
}

.book-category {
    display: inline-block;
    padding: 4px 12px;
    background: #ede9fe;
    color: #7c3aed;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.book-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    line-height: 1.3;
}

.book-author {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 16px;
}

.book-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding: 12px 0;
    border-top: 1px solid #e5e7eb;
}

.book-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}

.star {
    width: 16px;
    height: 16px;
    color: #d1d5db;
}

.star.filled {
    color: #fbbf24;
}

.rating-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    margin-left: 4px;
}

.book-copies {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #6b7280;
}

.book-copies svg {
    width: 16px;
    height: 16px;
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
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-details-btn:hover {
    transform: translateX(4px);
}

.view-details-btn svg {
    width: 16px;
    height: 16px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 16px;
}

.empty-state svg {
    width: 80px;
    height: 80px;
    color: #d1d5db;
    margin-bottom: 24px;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 1rem;
    color: #6b7280;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

/* Animations */
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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
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

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

.animate-fade-in-delay {
    animation: fadeIn 0.6s ease-out 0.2s backwards;
}

.animate-slide-up {
    animation: slideUp 0.8s ease-out 0.3s backwards;
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out backwards;
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out backwards;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .search-panel {
        padding: 24px;
    }
    
    .filter-group {
        grid-template-columns: 1fr;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 480px) {
    .hero-section {
        padding: 60px 16px 100px;
    }
    
    .books-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to books section when search is submitted
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Let form submit normally, but add smooth animation
            setTimeout(() => {
                const booksSection = document.querySelector('.books-section');
                if (booksSection) {
                    booksSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        });
    }

    // Add loading animation to favorite buttons
    const favoriteForms = document.querySelectorAll('.favorite-form');
    favoriteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('.favorite-btn');
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.6';
            
            // Re-enable after animation
            setTimeout(() => {
                button.style.pointerEvents = 'auto';
                button.style.opacity = '1';
            }, 1000);
        });
    });

    // Add pulse animation to search input on focus
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }

    // Parallax effect on hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            heroSection.style.transform = `translate3d(0, ${rate}px, 0)`;
        }
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe book cards for scroll animation
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        observer.observe(card);
    });

    // Add hover effect sound (optional visual feedback)
    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
    viewDetailsButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Stat counter animation
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const finalValue = stat.textContent;
        const isCredit = finalValue.includes('RM');
        
        if (!isCredit) {
            const targetValue = parseInt(finalValue.replace(/\D/g, ''));
            let currentValue = 0;
            const increment = Math.ceil(targetValue / 50);
            const duration = 1500;
            const stepTime = duration / (targetValue / increment);
            
            const counter = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    stat.textContent = targetValue;
                    clearInterval(counter);
                } else {
                    stat.textContent = currentValue;
                }
            }, stepTime);
        }
    });

    // Add ripple effect to buttons
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;
        
        ripple.style.width = ripple.style.height = `${diameter}px`;
        ripple.style.left = `${event.clientX - button.offsetLeft - radius}px`;
        ripple.style.top = `${event.clientY - button.offsetTop - radius}px`;
        ripple.classList.add('ripple');
        
        const rippleElement = button.getElementsByClassName('ripple')[0];
        if (rippleElement) {
            rippleElement.remove();
        }
        
        button.appendChild(ripple);
    }
    
    const buttons = document.querySelectorAll('.search-btn, .view-details-btn');
    buttons.forEach(button => {
        button.addEventListener('click', createRipple);
    });
});
</script>

<style>
/* Additional ripple effect styles */
.search-btn, .view-details-btn {
    position: relative;
    overflow: hidden;
}

.ripple {
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

/* Loading spinner for favorite button */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.favorite-btn.loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border: 2px solid #fff;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

/* Hover glow effect for book cards */
.book-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 16px;
    pointer-events: none;
}

.book-card:hover::before {
    opacity: 1;
}

/* Smooth transitions for all interactive elements */
* {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
}

/* Focus styles for accessibility */
.search-input:focus,
.filter-select:focus,
.search-btn:focus,
.view-details-btn:focus,
.favorite-btn:focus {
    outline: 3px solid rgba(102, 126, 234, 0.5);
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .hero-section,
    .search-panel,
    .stats-container,
    .favorite-btn {
        display: none;
    }
    
    .dashboard-container {
        background: white;
    }
    
    .book-card {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}
</style>
@endsection