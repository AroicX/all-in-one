<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class WarehouseMovement extends Model
{
    //
    protected $fillable = ['batch_id', 'from', 'to', 'quantity_moved', 'shipping', 'damages', 'handling'];

    public function batch(){
    	return $this->belongsTo('App\inventory\Batch');
 
    }
    public function warehouseproduct(){
    	return $this->hasMany('App\WarehouseProduct');
    }
}
