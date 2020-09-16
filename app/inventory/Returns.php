<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    //
     protected $fillable = ['batch_id', 'quantity_returned', 'amount_returned', 'note'];
}
