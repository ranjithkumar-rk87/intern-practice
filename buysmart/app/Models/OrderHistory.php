<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'action',
        'items',
    ];
    protected $casts = [
        'items' => 'array',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
