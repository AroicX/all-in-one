<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['purchase_date', 'total_invoice_cost', 'shipping', 'commission', 'clearing', 'insurance', 'other_costs' , 'payment_status', 'payment_date', 'amount_paid' , 'supplier_name' , 'date_received' , 'warehouse_id'];

    public function product(){
    	return $this->hasMany('App\inventory\Product');

    }

    public function user(){
    	return $this->belongsTo('App\Model\User');
    }
    public function company(){
    	return $this->belongsTo('App\Company');
    }
}
