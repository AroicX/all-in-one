<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    //
    public function warehouse(){
    	return $this->belongsTo('App\inventory\Warehouse');
    }
}
