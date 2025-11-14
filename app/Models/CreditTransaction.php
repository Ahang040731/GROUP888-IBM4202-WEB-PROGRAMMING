<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditTransaction extends Model
{
    use HasFactory;

    // Only created_at, no updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'delta',
        'reason',
        'method',
        'reference',
    ];

    protected $casts = [
        'delta' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is a credit (positive) transaction
     */
    public function isCredit(): bool
    {
        return $this->delta > 0;
    }

    /**
     * Check if this is a debit (negative) transaction
     */
    public function isDebit(): bool
    {
        return $this->delta < 0;
    }

    /**
     * Get formatted amount with sign
     */
    public function getFormattedAmountAttribute(): string
    {
        $sign = $this->delta >= 0 ? '+' : '';
        return $sign . 'RM ' . number_format(abs($this->delta), 2);
    }

    /**
     * Get reason label
     */
    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'topup' => 'Top Up',
            'fine' => 'Fine Payment',
            'lost' => 'Lost Book',
            'damage' => 'Book Damage',
            'activate' => 'Account Activation',
            'manual' => 'Manual Adjustment',
            default => ucfirst($this->reason),
        };
    }

    /**
     * Get method label
     */
    public function getMethodLabelAttribute(): string
    {
        if (!$this->method) return 'N/A';
        
        return match($this->method) {
            'credit' => 'Credit Card',
            'card' => 'Debit Card',
            'online_banking' => 'Online Banking',
            'tng' => 'Touch n Go',
            'cash' => 'Cash',
            'system' => 'System',
            default => ucfirst($this->method),
        };
    }
}