<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class ProductLineItem extends Model
{
    //
	protected $fillable = ['product_id','product_line_id', 'quantity','reorder_level', 'reorder_quantity', 'overhead_allocation'];

	public function product(){
		return $this->belongsTo('App\inventory\Product');
	}

	public function productline(){
		return $this->belongsTo('App\inventory\ProductLine', 'product_line_id');
	}
}
