<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['account_id','username','phone'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

?>