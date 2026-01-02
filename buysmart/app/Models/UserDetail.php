<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'state',
        'pincode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
