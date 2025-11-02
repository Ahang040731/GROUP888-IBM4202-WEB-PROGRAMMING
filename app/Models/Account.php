<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $fillable = ['email', 'password', 'role'];

    protected $hidden = ['password'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}

?>