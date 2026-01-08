<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use CrudTrait;
     protected $fillable = [ 'pincode','city', 'is_active'];
}
