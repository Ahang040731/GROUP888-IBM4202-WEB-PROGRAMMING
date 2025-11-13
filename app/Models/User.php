<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class User extends Model
{
    protected $fillable = [
        'account_id',
        'username',
        'phone',
        'is_active',
        'credit',
        'photo',
        'address'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function carts(): HasMany
    {   
        return $this->hasMany(Cart::class);
    }   

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function favouriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favourites')
                    ->withTimestamps(); // if you decide to add timestamps later
    }

    public function creditTransactions()
    {
        return $this->hasMany(\App\Models\CreditTransaction::class);
    }

    // If you want live computed balance from the ledger:
    public function getLedgerBalanceAttribute()
    {
        return (float) $this->creditTransactions()->sum('delta');
    }
}