@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('client.books.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Books
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
            <!-- Book Cover Column -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    @if($book->photo)
                        <img 
                            src="{{ $book->photo }}" 
                            alt="{{ $book->book_name }}" 
                            class="w-full rounded-lg shadow-md"
                        >
                    @else
                        <div class="w-full aspect-[2/3] bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        @if($cartItem)
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-2">Already in cart ({{ $cartItem->quantity }} {{ $cartItem->quantity > 1 ? 'copies' : 'copy' }})</p>
                                <a href="{{ route('client.cart.index') }}" class="block w-full px-4 py-3 bg-blue-600 text-white text-center font-medium rounded-lg hover:bg-blue-700 transition">
                                    Go to Cart
                                </a>
                            </div>
                        @elseif($book->available_copies > 0)
                            <form action="{{ route('client.cart.store', $book) }}" method="POST">
                                @csrf
                                <button 
                                    type="submit"
                                    class="w-full px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Borrow Cart
                                </button>
                            </form>
                        @else
                            <button 
                                class="w-full px-4 py-3 bg-red-400 text-white font-medium rounded-lg cursor-not-allowed"
                                disabled
                            >
                                Currently Unavailable
                            </button>
                        @endif

                        <!-- Favorite Button -->
                        <form action="{{ $isFavorite ? route('client.favourites.destroy', $book) : route('client.favourites.store', $book) }}" method="POST">
                            @csrf
                            @if($isFavorite)
                                @method('DELETE')
                            @endif
                            <button 
                                type="submit"
                                class="w-full px-4 py-3 {{ $isFavorite ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} font-medium rounded-lg transition flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                {{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Book Details Column -->
            <div class="lg:col-span-2">
                <!-- Title and Author -->
                <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $book->book_name }}</h1>
                <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>

                <!-- Rating and Year -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= floor($book->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                        <span class="ml-2 text-lg font-semibold text-gray-700">{{ number_format($book->rating, 1) }}</span>
                    </div>
                    @if($book->category)
                        <span class="px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">
                            {{ $book->category }}
                        </span>
                    @endif
                    <span class="text-gray-600">{{ $book->published_year }}</span>
                </div>

                <!-- Availability Status -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Availability</h3>
                            <p class="text-gray-600">
                                <span class="font-bold text-lg {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->available_copies }}
                                </span> 
                                of {{ $book->total_copies }} copies available
                            </p>
                        </div>
                        @if($book->available_copies > 0)
                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $book->description ?? 'No description available for this book.' }}
                    </p>
                </div>

                <!-- Available Copies List -->
                @if($availableCopies->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Available Copies</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($availableCopies as $copy)
                                <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-mono text-sm text-gray-700">{{ $copy->copy_number }}</span>
                                    </div>
                                    <span class="text-xs font-semibold text-green-700 uppercase">Available</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Book Information Table -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Book Information</h3>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-100">Author</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-100">Published Year</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $book->published_year }}</td>
                                </tr>
                                @if($book->category)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-100">Category</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $book->category }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-100">Total Copies</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $book->total_copies }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-700 bg-gray-100">Rating</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($book->rating, 1) }} / 5.0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    // Auto-hide flash messages after 3 seconds
    setTimeout(() => {
        const messages = document.querySelectorAll('.fixed.bottom-4');
        messages.forEach(msg => {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        });
    }, 3000);
</script>
@endsection