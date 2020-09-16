<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class ShopMovement extends Model
{
    //
    protected $fillable = ['batch_id', 'shop_id', 'quantity_moved', 'shipping', 'damages', 'handling'];

    public function batch(){
    	return $this->belongsTo('App\inventory\Batch');
    }
}
