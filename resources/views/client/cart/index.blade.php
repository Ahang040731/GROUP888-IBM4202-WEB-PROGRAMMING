@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">My Borrow Cart</h1>
            <p class="text-gray-600">Review your selected books before submitting a borrow request</p>
        </div>
        <a href="{{ route('client.books.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Continue Browsing
        </a>
    </div>

    <!-- Warning for unavailable items -->
    @if($unavailableItems->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Some items are no longer available</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        {{ $unavailableItems->count() }} {{ $unavailableItems->count() > 1 ? 'items have' : 'item has' }} insufficient copies. Please remove them or adjust quantities.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 bg-gray-50 border-b">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">
                                Cart Items ({{ $cartItems->count() }}/10)
                            </h2>
                            @if($cartItems->count() > 0)
                                <form action="{{ route('client.cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Clear Cart
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div class="p-6 {{ !$item->isAvailable() ? 'bg-red-50' : '' }}">
                                <div class="flex gap-4">
                                    <!-- Book Cover -->
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('client.books.show', $item->book) }}">
                                            @if($item->book->photo)
                                                <img 
                                                    src="{{ $item->book->photo }}" 
                                                    alt="{{ $item->book->book_name }}" 
                                                    class="w-24 h-32 object-cover rounded shadow"
                                                >
                                            @else
                                                <div class="w-24 h-32 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Book Details -->
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('client.books.show', $item->book) }}" class="block">
                                            <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 mb-1">
                                                {{ $item->book->book_name }}
                                            </h3>
                                        </a>
                                        <p class="text-sm text-gray-600 mb-2">by {{ $item->book->author }}</p>
                                        
                                        <div class="flex items-center gap-2 mb-3">
                                            @if($item->book->category)
                                                <span class="px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded">
                                                    {{ $item->book->category }}
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $item->book->published_year }}</span>
                                        </div>

                                        <!-- Availability Status -->
                                        @if($item->isAvailable())
                                            <div class="flex items-center text-sm text-green-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $item->book->available_copies }} copies available
                                            </div>
                                        @else
                                            <div class="flex items-center text-sm text-red-600 font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Only {{ $item->book->available_copies }} copies available (you requested {{ $item->quantity }})
                                            </div>
                                        @endif

                                        <!-- Quantity and Actions -->
                                        <div class="mt-4 flex items-center gap-3">
                                            <!-- Quantity Selector -->
                                            <form action="{{ route('client.cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <label class="text-sm text-gray-600">Copies:</label>
                                                <select 
                                                    name="quantity" 
                                                    onchange="this.form.submit()"
                                                    class="px-3 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 text-sm"
                                                >
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
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Borrow Summary</h2>
                    
                    <div class="space-y-3 mb-6 pb-6 border-b">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Books:</span>
                            <span class="font-semibold">{{ $cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Total Copies:</span>
                            <span class="font-semibold">{{ $cartItems->sum('quantity') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Borrow Period:</span>
                            <span class="font-semibold">7 days</span>
                        </div>
                    </div>

                    @if($unavailableItems->count() > 0)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-red-800 font-medium">
                                Please remove unavailable items before proceeding
                            </p>
                        </div>
                        <button 
                            class="w-full px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed"
                            disabled
                        >
                            Cannot Submit Request
                        </button>
                    @else
                        <form id="borrowRequestForm" action="{{ route('client.cart.submit') }}" method="POST">
                            @csrf
                            <button 
                                type="button"
                                id="submitBorrowBtn"
                                class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition"
                            >
                                Submit Borrow Request
                            </button>
                        </form>
                    @endif

                    <p class="text-xs text-gray-500 text-center mt-4">
                        You can borrow up to 3 copies per book and have a maximum of 10 items in your cart
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Your cart is empty</h3>
            <p class="text-gray-600 mb-6">Start browsing books and add them to your cart to create a borrow request</p>
            <a 
                href="{{ route('client.books.index') }}" 
                class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
                Browse Books
            </a>
        </div>
    @endif
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

    // Handle borrow request submission with SweetAlert
    document.addEventListener('DOMContentLoaded', () => {
        const submitBtn = document.getElementById('submitBorrowBtn');
        const form = document.getElementById('borrowRequestForm');

        console.log('Submit button:', submitBtn); // Debug
        console.log('Form:', form); // Debug

        if (submitBtn && form) {
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Button clicked!'); // Debug
                
                // Check if SweetAlert is available
                if (typeof Swal === 'undefined') {
                    console.log('SweetAlert not found, using confirm'); // Debug
                    if (confirm('Submit borrow request? This will send your request to the admin for approval.')) {
                        form.submit();
                    }
                    return;
                }

                console.log('Showing SweetAlert'); // Debug
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
                    console.log('SweetAlert result:', result); // Debug
                    if (result.isConfirmed) {
                        console.log('Confirmed, submitting form'); // Debug
                        form.submit();
                    }
                });
            });
        } else {
            console.error('Submit button or form not found!'); // Debug
        }
    });
</script>
@endsection