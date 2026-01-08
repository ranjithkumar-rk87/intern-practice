<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'category_name', 
        'description',
        'price',
        'stock',
        'image',
    ];
      public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function questions()
    {
        return $this->hasMany(ProductQuestion::class)->latest();
    }


        public function setImageAttribute($value)
        {
            if ($value) {
                $fileName = 'product_' . time() . '.' . $value->getClientOriginalExtension();

                $path = $value->storeAs('uploads/products', $fileName, 'public');

                $this->attributes['image'] = $path;
            }
        }

}

