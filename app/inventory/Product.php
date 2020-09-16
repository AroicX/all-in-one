<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['serial_no', 'order_id', 'description', 'SKU', 'margin_control', 'price_method', 'price_setting'];


    //relationship with user model 
    public function user(){
    	return $this->belongsTo('App\Model\User');
    }
    
    public function order(){
        return $this->belongsTo('App\inventory\Order');
    }

    public function batch(){
    	return $this->hasMany('App\inventory\Batch');
    }
    public function product_line_item(){
    	return $this->hasMany('App\inventory\ProductLineItem');
    }
}
