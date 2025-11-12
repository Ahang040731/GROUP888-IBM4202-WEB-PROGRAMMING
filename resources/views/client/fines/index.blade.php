@extends('layouts.app')

@section('title', 'Fines')

@section('content')

<div class="bh-container">
  <h1 class="bh-h1">Fines</h1>
  <p>Display your fines and payment options.</p>

  {{-- Current Unpaid Fines --}}
  <section class="mb-10">
    <h2 class="bh-h2">Unpaid Fines</h2>

    @if($current->isEmpty())
      <div class="bh-empty">No unpaid fines.</div>
    @else
      <ul class="bh-list">
        @foreach($current as $fine)
          @php
            $book = $fine->borrowHistory->book ?? null;
            $badgeClass = 'bh-badge bh-badge--overdue';
          @endphp

          <li class="bh-card">
            <div class="bh-row">
              {{-- Book Cover --}}
              <img src="{{ $book?->photo ?: 'https://placehold.co/64x96?text=Book' }}"
                   alt="{{ $book?->book_name ?? 'Book cover' }}"
                   class="bh-cover" />

              {{-- Content --}}
              <div class="bh-content">
                <div class="bh-titlebar">
                  <h3 class="bh-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                  <span class="{{ $badgeClass }}">Unpaid</span>
                </div>

                <div class="bh-meta">
                  <div>Reason: <span class="font-semibold">{{ $fine->reason }}</span></div>
                  <div>Amount: <span class="font-semibold">RM {{ number_format($fine->amount, 2) }}</span></div>
                  <div>Created At: <span class="font-semibold">{{ $fine->created_at->format('Y-m-d') }}</span></div>
                </div>
              </div>

              {{-- Actions --}}
              <div class="bh-actions">
                <form method="POST" action="{{ route('fines.pay', $fine->id) }}" class="pay-form inline">
                  @csrf
                  <button type="button" class="bh-btn bh-btn--extend pay-btn">Pay with Credit</button>
                </form>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  {{-- Previous Fines --}}
  <section>
    <h2 class="bh-h2">Previous Fines</h2>

    @if($previous->isEmpty())
      <div class="bh-empty">No previous fines.</div>
    @else
      <ul class="bh-list mb-4">
        @foreach($previous as $fine)
          @php
            $book = $fine->borrowHistory->book ?? null;
            $status = $fine->status;
            $badgeClass = match($status) {
                'paid' => 'bh-badge bh-badge--active',
                'waived' => 'bh-badge bh-badge--pending',
                'reversed' => 'bh-badge bh-badge--overdue',
                default => 'bh-badge'
            };
          @endphp

          <li class="bh-card">
            <div class="bh-row">
              <img src="{{ $book?->photo ?: 'https://placehold.co/64x96?text=Book' }}"
                   alt="{{ $book?->book_name ?? 'Book cover' }}"
                   class="bh-cover" />

              <div class="bh-content">
                <div class="bh-titlebar">
                  <h3 class="bh-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                  <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                </div>

                <div class="bh-meta">
                  <div>Reason: <span class="font-semibold">{{ $fine->reason }}</span></div>
                  <div>Amount: <span class="font-semibold">RM {{ number_format($fine->amount, 2) }}</span></div>
                  <div>Paid At: <span class="font-semibold">{{ $fine->paid_at?->format('Y-m-d') ?? '—' }}</span></div>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>

      {{ $previous->links() }}
    @endif
  </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Pay button confirmation
  document.querySelectorAll('.pay-btn').forEach(button => {
    button.addEventListener('click', e => {
      const form = e.target.closest('.pay-form');
      Swal.fire({
        title: 'Pay this fine with credit?',
        text: 'This will deduct your credit and mark the fine as paid.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4F46E5',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, pay it!',
        cancelButtonText: 'Cancel'
      }).then(result => {
        if (result.isConfirmed) form.submit();
      });
    });
  });
});
</script>
@endpush