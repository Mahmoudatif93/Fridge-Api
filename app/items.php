<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    protected $fillable = [
        'item_name', 'item_amount','item_addDate','item_expiryDate'
    ];
}
