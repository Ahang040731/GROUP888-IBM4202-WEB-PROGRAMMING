@extends('layouts.app')

@section('title', 'My Credit')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Credit Balance</h1>
        <p class="text-gray-600">Manage your library credit and view transaction history</p>
    </div>

    <!-- Credit Balance Card -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-purple-200 text-sm font-medium mb-2">Available Balance</p>
                <h2 class="text-5xl font-bold mb-4">RM {{ number_format($user->credit, 2) }}</h2>
                <p class="text-purple-200 text-sm">Last updated: {{ now()->format('d M Y, h:i A') }}</p>
            </div>
            <div class="text-right">
                <svg class="w-24 h-24 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                </svg>
            </div>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('client.credit.topup') }}" class="inline-block px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Top Up Credit
            </a>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 bg-gray-50 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Transaction History</h2>
        </div>

        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->created_at->format('d M Y') }}
                                    <span class="block text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $transaction->reason == 'topup' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $transaction->reason_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $transaction->method_label }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $transaction->reference ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold
                                    {{ $transaction->delta >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->delta >= 0 ? '+' : '' }}RM {{ number_format(abs($transaction->delta), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="p-12 text-center text-gray-500">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-lg font-medium mb-2">No transactions yet</p>
                <p class="text-sm">Your transaction history will appear here</p>
            </div>
        @endif
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

<script>
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