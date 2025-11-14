@extends('layouts.app')

@section('title', 'Fines')

@section('content')

<div class="bh-container">
  <h1 class="bh-h1">Fines</h1>

  {{-- Current Unpaid Fines --}}
  <section class="mb-10">
    <h2 class="bh-h2">Unpaid Fines</h2>

    @if($current->isEmpty())
      <div class="bh-empty">No unpaid fines.</div>
    @else
      <ul class="bh-list">
        @foreach($current as $fine)
          @php
            $borrowing = $fine->borrowHistory;
            $book      = $borrowing?->book;
            $status    = $fine->status;
            $reason    = $fine->reason;

            [$statusLabel, $badgeClass] = match (true) {
                // LOST fines – special labels
                $reason === 'lost' && $status === 'unpaid'  => ['Lost (Unpaid)',  'bh-badge bh-badge--overdue'],
                $reason === 'lost' && $status === 'pending' => ['Lost (Pending)', 'bh-badge bh-badge--pending'],
                $reason === 'lost' && $status === 'paid'    => ['Lost (Paid)',    'bh-badge bh-badge--active'],

                // normal fines
                $status === 'unpaid'  => ['Unpaid',  'bh-badge bh-badge--overdue'],
                $status === 'pending' => ['Pending', 'bh-badge bh-badge--pending'],
                default               => [ucfirst($status), 'bh-badge'],
            };
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
                  <span class="{{ $badgeClass }}">{{ $statusLabel }}</span>
                </div>

                <div class="bh-meta">
                  <div>Reason: <span class="font-semibold">{{ $fine->reason }}</span></div>
                  <div>Amount: <span class="font-semibold">RM {{ number_format($fine->amount, 2) }}</span></div>
                  <div>Created At: <span class="font-semibold">{{ $fine->created_at->format('Y-m-d') }}</span></div>
                </div>
              </div>

              {{-- Actions --}}
              <div class="bh-actions">
                @php
                  $borrowing   = $fine->borrowHistory;
                  $isLost      = $borrowing && $borrowing->status === 'lost';
                  $mustReturn  = $borrowing
                                && $borrowing->returned_at === null
                                && !$isLost;
                @endphp

                @if($mustReturn)
                    <button class="bh-btn bh-btn--ghost" style="color: red;" disabled>
                      Return Book First
                    </button>
                @else
                    <form method="POST" action="{{ route('fines.pay', $fine->id) }}" class="pay-form inline">
                      @csrf
                      <input type="hidden" name="method" value="cash">

                      <button type="button"
                              class="bh-btn bh-btn--extend pay-btn"
                              data-amount="{{ number_format($fine->amount, 2) }}">
                        Pay / Request Payment
                      </button>
                    </form>
                @endif
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
            $borrowing = $fine->borrowHistory;
            $book      = $borrowing?->book;
            $status    = $fine->status;
            $reason    = $fine->reason;

            $badgeClass = match($status) {
                'paid'     => 'bh-badge bh-badge--active',
                'waived'   => 'bh-badge bh-badge--pending',
                'reversed' => 'bh-badge bh-badge--overdue',
                default    => 'bh-badge',
            };

            $label = $reason === 'lost'
                ? 'Lost (' . ucfirst($status) . ')'
                : ucfirst($status);
          @endphp


          <li class="bh-card">
            <div class="bh-row">
              <img src="{{ $book?->photo ?: 'https://placehold.co/64x96?text=Book' }}"
                   alt="{{ $book?->book_name ?? 'Book cover' }}"
                   class="bh-cover" />

              <div class="bh-content">
                <div class="bh-titlebar">
                  <h3 class="bh-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                  <span class="{{ $badgeClass }}">{{ $label }}</span>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.pay-btn').forEach(button => {
    button.addEventListener('click', e => {
      const form   = e.target.closest('.pay-form');
      const amount = e.target.dataset.amount || '0.00';

      Swal.fire({
        title: 'Confirm Fine Payment',
        html: `
          <div style="font-size:0.95rem; color:#4b5563;">
            <div style="margin-bottom:6px;">You are about to pay:</div>
            <div style="
              display:inline-block;
              padding:6px 14px;
              border-radius:999px;
              background:linear-gradient(90deg,#4F46E5,#8B5CF6);
              color:#fff;
              font-size:1.4rem;
              font-weight:700;
              letter-spacing:0.02em;
              margin-bottom:8px;
            ">
              RM ${amount}
            </div>
          </div>
        `,
        icon: 'info',
        input: 'select',
        inputOptions: {
          credit:          'Credit Balance',
          tng:             "Touch \'n Go",
          card:            'Debit / Credit Card',
          online_banking:  'Online Banking',
          cash:            'Cash at Counter'
        },
        inputValue: 'credit',
        inputLabel: 'Payment Method',
        showCancelButton: true,
        confirmButtonColor: '#4F46E5',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Confirm Payment',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
          if (!value) {
            return 'Please select a payment method.';
          }
        }
      }).then(result => {
        if (result.isConfirmed) {
          let methodInput = form.querySelector('input[name="method"]');
          if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = 'method';
            form.appendChild(methodInput);
          }
          methodInput.value = result.value;
          form.submit();
        }
      });
    });
  });
});
</script>
@endpush