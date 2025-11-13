<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class BorrowHistory extends Model
{
    protected $table = 'borrow_history';

    protected $fillable = [
        'user_id','book_id','copy_id',
        'borrowed_at','due_at','returned_at',
        'status','extension_count','extension_reason','approve_status',
    ];
    
    public $timestamps = true;

    /** Make sure these are Carbon instances */
    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at'      => 'datetime',
        'returned_at' => 'datetime',
    ];

    /** Expose handy, date-only/computed fields to Blade */
    protected $appends = [
        'borrow_date','due_date','returned_date','late_days','is_overdue',
    ];

    /* ==========================
       Relationships
    =========================== */
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function book(): BelongsTo { return $this->belongsTo(Book::class); }
    public function copy(): BelongsTo { return $this->belongsTo(BookCopy::class,'copy_id'); }
    public function fine(): HasOne { return $this->hasOne(Fine::class, 'borrowing_id'); }


    /* ==========================
       Scopes
    =========================== */
    public function scopeActive($q)   { return $q->where('status','active'); }
    public function scopeOverdue($q)  { return $q->where('status','overdue'); }
    public function scopeReturned($q) { return $q->where('status','returned'); }

    /* ==========================
       Accessors / Helpers
    =========================== */

    /** Date-only strings (YYYY-MM-DD) — UI can use these */
    public function getBorrowDateAttribute(): ?string { return $this->borrowed_at?->toDateString(); }
    public function getDueDateAttribute(): ?string     { return $this->due_at?->toDateString(); }
    public function getReturnedDateAttribute(): ?string{ return $this->returned_at?->toDateString(); }

    /** Same-day return is not late. Overdue only if today is AFTER due date. */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->returned_at || !$this->due_at) return false;

        return \Illuminate\Support\Carbon::today()->gt(
            $this->due_at->copy()->startOfDay()
        );
    }


    /**
     * Late days by DATE only:
     * - if returned: max(return_date - due_date, 0)
     * - else:        max(today - due_date, 0)
     */
    public function getLateDaysAttribute(): int
    {
        if (!$this->due_at) return 0;

        $due = $this->due_at->copy()->startOfDay();

        // If returned: late days based on returned_at
        if ($this->returned_at) {
            $ret = $this->returned_at->copy()->startOfDay();
            return $ret->gt($due) ? $due->diffInDays($ret) : 0;
        }

        // Else: based on today
        $today = \Illuminate\Support\Carbon::today();
        return $today->gt($due) ? $due->diffInDays($today) : 0;
    }


    /** Convenience (kept from your version) */
    public function isReturned(): bool
    {
        return !is_null($this->returned_at);
    }
}
