<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recips extends Model
{
    protected $fillable = [
        'meals_id', 'item_id'
    ];
}
