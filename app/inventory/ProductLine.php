<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    //
    protected $fillable = ['name', 'additional_info'];
  	
  	public function company(){
  		return $this->belongsTo('App\Company');
  	}

  	public function product_line_item(){
  		return $this->hasMany('App\inventory\ProductLineItem', 'product_line_id', 'id');
  	}
}
