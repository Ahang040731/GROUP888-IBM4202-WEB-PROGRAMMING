@extends('layouts.app')

@section('title', 'Borrow History')

@section('content')
<div class="bh-container">
  <h1 class="bh-h1">Borrow & Return History</h1>

  <section class="mb-10">
    <h2 class="bh-h2">Current Borrow</h2>

    @if($current->isEmpty())
      <div class="bh-empty">No current borrows.</div>
    @else
      <ul class="bh-list">
        @foreach($current as $row)
          @php
              $book = $row->book ?? null;
              $copy = $row->copy ?? null;

              $isPending = $row->approve_status === 'pending';

              if ($isPending) {
                  $badgeClass = 'bh-badge bh-badge--pending';
                  $badgeText  = 'Pending';
              } elseif ($row->status === 'overdue' || $row->is_overdue) {
                  $badgeClass = 'bh-badge bh-badge--overdue';
                  $badgeText  = 'Overdue';
              } else {
                  // active / others that are still with user
                  $badgeClass = 'bh-badge bh-badge--active';
                  $badgeText  = 'Active';
              }
          @endphp


          <li class="bh-card">
            <div class="bh-row">
              {{-- Cover --}}
              <img
                src="{{ $book?->photo ?: 'https://placehold.co/64x96?text=Book' }}"
                alt="{{ $book?->book_name ?? 'Book cover' }}"
                class="bh-cover"
                loading="lazy"
              />

              {{-- Content --}}
              <div class="bh-content">
                <div class="bh-titlebar">
                  <h3 class="bh-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                  <span class="bh-copy">{{ $copy->barcode ?? $row->copy_id }}</span>
                  <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                </div>

                {{-- “by Author” line --}}
                <div class="bh-by">
                  <span class="bh-author">{{ $book->author ?? 'Unknown Author' }}</span>
                </div>

                <div class="bh-meta">
                  <div class="bh-meta-left">
                    <div>Borrowed  :<span class="font-semibold">{{ $row->borrow_date }}</span></div>
                    <div>Due       :<span class="font-semibold">{{ $row->due_date }}</span></div>
                  </div>

                  <div class="bh-meta-right">
                    <div>Extensions:<span class="font-semibold">{{ $row->extension_count }}</span></div>
                  </div>
                </div>
              </div>

              {{-- Actions --}}
              @if(is_null($row->returned_at))
                <div class="bh-actions">
                  @if($isPending)
                    <form method="POST" action="{{ route('client.borrowhistory.cancel', $row->id) }}" class="cancel-form inline">
                      @csrf
                      <button type="button" class="bh-btn bh-btn--cancel cancel-btn">
                        Cancel Request
                      </button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('client.borrowhistory.extend', $row->id) }}" class="extend-form inline">
                      @csrf
                      <button type="button" class="bh-btn bh-btn--extend extend-btn">
                        Extend
                      </button>
                    </form>
                  @endif
                </div>
              @endif

            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section>
    <h2 class="bh-h2">Previous Borrow</h2>

    @if($previous->isEmpty())
      <div class="bh-empty">No previous borrows.</div>
    @else
      <ul class="bh-list mb-4">
        @foreach($previous as $row)
          @php
              $book = $row->book ?? null;
              $copy = $row->copy ?? null;

              $status = $row->status; // 'returned', 'lost', 'overdue', etc.
              $isPending = $row->approve_status === 'pending';

              if ($isPending) {
                  $badgeClass = 'bh-badge bh-badge--pending';
                  $badgeText  = 'Pending';
              } elseif ($status === 'lost') {
                  $badgeClass = 'bh-badge bh-badge--overdue';
                  $badgeText  = 'Lost / Missing';
              } elseif ($status === 'returned') {
                  $badgeClass = 'bh-badge bh-badge--returned';
                  $badgeText  = 'Returned';
              } elseif ($row->is_overdue) {
                  $badgeClass = 'bh-badge bh-badge--overdue';
                  $badgeText  = 'Overdue (Late Return)';
              } else {
                  $badgeClass = 'bh-badge bh-badge--active';
                  $badgeText  = ucfirst($status);
              }
          @endphp


          <li class="bh-card">
            <div class="bh-row">
              <img
                src="{{ $book?->photo ?: 'https://placehold.co/64x96?text=Book' }}"
                alt="{{ $book?->book_name ?? 'Book cover' }}"
                class="bh-cover"
                loading="lazy"
              />

              <div class="bh-content">
                <div class="bh-titlebar">
                  <h3 class="bh-title">{{ $book->book_name ?? 'Unknown Book' }}</h3>
                  <span class="bh-copy">{{ $copy->barcode ?? $row->copy_id }}</span>
                  <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                </div>
                
                {{-- “by Author” line --}}
                <div class="bh-by">
                  <span class="bh-author">{{ $book->author ?? 'Unknown Author' }}</span>
                </div>

                <div class="bh-meta">
                  <div class="bh-meta-left">
                    <div>Borrowed :<span class="font-semibold">{{ $row->borrow_date }}</span></div>
                    <div>Due :<span class="font-semibold">{{ $row->due_date }}</span></div>
                  </div>

                  <div class="bh-meta-right">
                    <div>Returned :<span class="font-semibold">{{ $row->returned_date ?? '—' }}</span></div>
                    <div>Late Days :<span class="font-semibold" style="color:{{ $row->late_days ? 'red' : 'inherit' }}">{{ $row->late_days }}</span></div>
                  </div>
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

  // Handle "Extend" button popup
  document.querySelectorAll('.extend-btn').forEach(button => {
    button.addEventListener('click', e => {
      const form = e.target.closest('.extend-form');
      Swal.fire({
        title: 'Extend Borrow Duration?',
        text: 'This will send an extension request for approval.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4F46E5',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, send request!',
        cancelButtonText: 'Cancel'
      }).then(result => {
        if (result.isConfirmed) form.submit();
      });
    });
  });

  // Handle "Cancel Request" button popup
  document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', e => {
      const form = e.target.closest('.cancel-form');
      Swal.fire({
        title: 'Cancel Extension Request?',
        text: 'Your current pending request will be cancelled.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Keep it'
      }).then(result => {
        if (result.isConfirmed) form.submit();
      });
    });
  });
});
</script>
@endpush