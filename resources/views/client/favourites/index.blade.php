@extends('layouts.app')

@section('title', 'Favourites')

@section('content')
<div class="bh-container">
  <h1 class="bh-h1 mb-6">Your Favourite Books</h1>
    <p class="section-subtitle">
      {{ method_exists($books, 'total') ? $books->total() : $books->count() }} books saved
    </p>

  @if(($books ?? collect())->isEmpty())
    <div class="bg-white rounded-xl border p-8 text-center text-slate-600">
      No favourites yet. Go add some ❤️
    </div>
  @else
    <div class="books-section">
      <div class="books-grid books-grid-sm">
        @foreach($books as $index => $book)
        <div class="book-card animate-fade-in-up" style="animation-delay: {{ ($index % 12) * 0.04 }}s">
          <div class="book-image-wrapper">

            {{-- Favourites toggle (unfavourite) --}}
            <form method="POST" action="{{ route('favourites.toggle', $book->id) }}" 
                  class="favourite-form favourite-form-right">
              @csrf
              <button type="submit" class="favourite-btn {{ $book->is_favorited ? 'active' : '' }}">
                <svg fill="{{ $book->is_favorited ? 'currentColor' : 'none' }}"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
              </button>
            </form>

            @php
              $src = null;
              if (!empty($book->photo)) {
                $src = Str::startsWith($book->photo, ['http://','https://'])
                        ? $book->photo
                        : asset('storage/'.$book->photo);
              }
            @endphp

            @if($src)
              <img src="{{ $src }}" alt="{{ $book->book_name }}" class="book-image">
            @else
              <div class="book-placeholder">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
              </div>
            @endif

            {{-- Optional status badge (if you want) --}}
            @if(isset($book->available_copies, $book->total_copies))
              <div class="book-badge {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                {{ $book->available_copies > 0 ? 'Available' : 'Unavailable' }}
              </div>
            @endif
          </div>

          {{-- Compact content --}}
          <div class="book-content book-content-sm">
            @if(!empty($book->category))
              <div class="book-category book-category-sm">
                {{ $book->category }}
              </div>
            @endif

            <h3 class="book-title book-title-sm text-center">
              {{ Str::limit($book->book_name, 40) }}
            </h3>

            @if(!empty($book->author))
              <p class="book-author book-author-sm text-center">
                by {{ $book->author }}
              </p>
            @endif

            <a href="{{ route('books.show', $book->id) }}" class="view-details-btn view-details-btn-sm">
              <span>View Details</span>
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </div>
        @endforeach
      </div>

      @if(method_exists($books, 'links'))
      <div class="pagination-wrapper mt-6">
        {{ $books->links() }}
      </div>
      @endif
    </div>
  @endif
</div>
@endsection
<style>
  /* Base layout for the books grid (needed if not already defined globally) */
  .books-section {
      max-width: 1200px;
      margin: 0 auto;
  }

  .section-subtitle {
      text-align: center;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      font-size: 1rem;
      color: white;
      margin-bottom: 16px;
  }

  /* Make the grid actually a grid */
  .books-grid.books-grid-sm {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 20px;
  }

  /* Base card style (simplified from your good UI) */
  .book-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.25s ease;
  }

  .book-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }

  /* Image wrapper – slightly shorter for smaller cards */
  .book-image-wrapper {
      position: relative;
      padding-top: 130%;
      background: #f3f4f6;
      overflow: hidden;
  }

  /* Image itself */
  .book-image {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
  }

  .book-card:hover .book-image {
      transform: scale(1.05);
  }

  /* Placeholder when no image */
  .book-placeholder {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .book-placeholder svg {
      width: 56px;
      height: 56px;
      color: white;
      opacity: 0.6;
  }

  /* Status badge */
  .book-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.03em;
  }

  .book-badge.available {
      background: #10b981;
      color: white;
  }

  .book-badge.unavailable {
      background: #ef4444;
      color: white;
  }

  /* Favourite button – top-right */
  .favourite-form.favourite-form-right {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 2; /* important so it stays above the image */
  }

  .favourite-btn {
      width: 36px;
      height: 36px;
      border-radius: 999px;
      background: white;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.18s ease, box-shadow 0.18s ease;
  }

  .favourite-btn:hover {
      transform: scale(1.08);
      box-shadow: 0 4px 12px rgba(0,0,0,0.18);
  }

  .favourite-btn svg {
      width: 18px;
      height: 18px;
      color: #d1d5db;
  }

  .favourite-btn.active svg {
      color: #ef4444; /* heart becomes red and filled because fill="currentColor" */
  }

  .favourite-btn:hover {
      transform: scale(1.08);
      box-shadow: 0 4px 12px rgba(0,0,0,0.18);
  }


  /* Smaller card padding & fonts */
  .book-content-sm {
      padding: 14px 14px 16px;
  }

  .book-title-sm {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 6px;
      color: #111827;
  }

  .book-author-sm {
      font-size: 0.75rem;
      margin-bottom: 10px;
      color: #6b7280;
  }

  /* Smaller category pill */
  .book-category-sm {
      font-size: 0.7rem;
      padding: 3px 8px;
      border-radius: 999px;
      background: #ede9fe;
      color: #7c3aed;
      display: inline-block;
      margin-bottom: 6px;
  }

  /* "View Details" button – compact */
  .view-details-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      width: 100%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      border-radius: 12px;
      font-weight: 600;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .view-details-btn-sm {
      padding: 8px 10px;
      font-size: 0.8rem;
      border-radius: 10px;
  }

  .view-details-btn svg {
      width: 14px;
      height: 14px;
  }

  .view-details-btn:hover {
      transform: translateX(3px);
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.45);
  }

  /* Simple fade-in-up animation */
  @keyframes fadeInUp {
      from {
          opacity: 0;
          transform: translateY(14px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  .animate-fade-in-up {
      animation: fadeInUp 0.45s ease-out backwards;
  }
</style>