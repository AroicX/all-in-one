<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
	protected $fillable = ['quantity_ordered',  'unit_cost_sold', 'margin_threshold', 'warehouse_id', 'man_batch_no' ];

    //relationships
    public function product(){
    	return $this->belongsTo('App\inventory\Product');
    }

    public function warehouse(){
    	return $this->belongsTo('App\inventory\Warehouse');
    }

    public function warehouse_movement(){
    	return $this->hasMany('App\inventory\WarehouseMovement');
    }

    public function shop_movement(){
        return $this->hasMany('App\inventory\ShopMovement');
    }
}
