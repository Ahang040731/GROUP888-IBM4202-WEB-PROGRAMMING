@extends('layouts.app')

@section('title', 'Top Up Credit')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('client.credit.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Credit
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Top Up Credit</h1>
        <p class="text-gray-600">Add funds to your library credit account</p>
    </div>

    <!-- Current Balance -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8 text-white">
        <p class="text-blue-200 text-sm mb-1">Current Balance</p>
        <p class="text-3xl font-bold">RM {{ number_format($user->credit, 2) }}</p>
    </div>

    <!-- Top-up Form -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('client.credit.process-topup') }}" method="POST" id="topupForm">
            @csrf

            <!-- Amount Selection -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Select Amount</label>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <button type="button" class="amount-btn" data-amount="10">RM 10</button>
                    <button type="button" class="amount-btn" data-amount="20">RM 20</button>
                    <button type="button" class="amount-btn" data-amount="50">RM 50</button>
                    <button type="button" class="amount-btn" data-amount="100">RM 100</button>
                    <button type="button" class="amount-btn" data-amount="200">RM 200</button>
                    <button type="button" class="amount-btn" data-amount="500">RM 500</button>
                </div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Or Enter Custom Amount</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">RM</span>
                    <input 
                        type="number" 
                        name="amount" 
                        id="amountInput"
                        min="10" 
                        max="1000" 
                        step="0.01"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                        placeholder="10.00"
                        required
                    >
                </div>
                <p class="mt-2 text-sm text-gray-500">Minimum: RM 10.00 | Maximum: RM 1,000.00</p>
                @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Method -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Payment Method</label>
                <div class="space-y-3">
                    <label class="payment-method-card">
                        <input type="radio" name="method" value="online_banking" class="mr-3" required>
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Online Banking</p>
                                    <p class="text-sm text-gray-500">FPX, Bank Transfer</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-method-card">
                        <input type="radio" name="method" value="credit" class="mr-3">
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Credit Card</p>
                                    <p class="text-sm text-gray-500">Visa, Mastercard</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-method-card">
                        <input type="radio" name="method" value="card" class="mr-3">
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Debit Card</p>
                                    <p class="text-sm text-gray-500">Bank debit cards</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-method-card">
                        <input type="radio" name="method" value="tng" class="mr-3">
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Touch 'n Go eWallet</p>
                                    <p class="text-sm text-gray-500">Pay with TnG</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-method-card">
                        <input type="radio" name="method" value="cash" class="mr-3">
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-3 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Cash</p>
                                    <p class="text-sm text-gray-500">Pay at library counter</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('method')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Top-up Amount:</span>
                        <span class="font-semibold">RM <span id="summaryAmount">0.00</span></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Processing Fee:</span>
                        <span class="font-semibold">RM 0.00</span>
                    </div>
                    <div class="border-t pt-2 mt-2 flex justify-between text-lg font-bold text-gray-800">
                        <span>Total:</span>
                        <span>RM <span id="summaryTotal">0.00</span></span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                id="submitBtn"
                class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:from-blue-700 hover:to-purple-700 transition shadow-lg"
            >
                Proceed to Payment
            </button>
        </form>
    </div>
</div>

<style>
    .amount-btn {
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-weight: 600;
        font-size: 18px;
        transition: all 0.3s;
        background: white;
        color: #374151;
    }

    .amount-btn:hover {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #3b82f6;
    }

    .amount-btn.active {
        border-color: #3b82f6;
        background: #3b82f6;
        color: white;
    }

    .payment-method-card {
        display: flex;
        align-items: center;
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-method-card:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .payment-method-card:has(input:checked) {
        border-color: #3b82f6;
        background: #eff6ff;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const amountInput = document.getElementById('amountInput');
        const summaryAmount = document.getElementById('summaryAmount');
        const summaryTotal = document.getElementById('summaryTotal');
        const amountButtons = document.querySelectorAll('.amount-btn');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('topupForm');

        // Handle amount button clicks
        amountButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                amountButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const amount = btn.dataset.amount;
                amountInput.value = amount;
                updateSummary(amount);
            });
        });

        // Handle amount input change
        amountInput.addEventListener('input', () => {
            amountButtons.forEach(b => b.classList.remove('active'));
            updateSummary(amountInput.value || 0);
        });

        function updateSummary(amount) {
            const formatted = parseFloat(amount).toFixed(2);
            summaryAmount.textContent = formatted;
            summaryTotal.textContent = formatted;
        }

        // Handle form submission with SweetAlert
        form.addEventListener('submit', (e) => {
            if (typeof Swal !== 'undefined') {
                e.preventDefault();
                
                const amount = amountInput.value;
                const method = form.querySelector('input[name="method"]:checked');
                
                if (!amount || !method) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Confirm Top-up?',
                    html: `
                        <p class="text-gray-600 mb-2">You are about to top up <strong>RM ${parseFloat(amount).toFixed(2)}</strong></p>
                        <p class="text-sm text-gray-500">Payment method: ${method.nextElementSibling.querySelector('p').textContent}</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endsection