<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use CrudTrait,SoftDeletes;
    protected $fillable = [
        'user_id',
        'address_id',
        'total_amount',
        'status',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'payment_method',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
//     public function address()
// {
//     return $this->belongsTo(Address::class);
// }
 public function deliveryAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function histories()
    {
        return $this->hasMany(OrderHistory::class);
    }


}

