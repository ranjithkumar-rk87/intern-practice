<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ProductQuestion extends Model
{
    use CrudTrait;
    protected $fillable = ['product_id', 'user_id', 'question', 'answer', 'answered'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function booted()
{
    static::saving(function ($question) {
        if (!empty($question->answer)) {
            $question->answered = 1;
        }
    });
}

    
}
