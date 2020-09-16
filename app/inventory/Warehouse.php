<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    protected $fillable = ['name', 'address', 'city', 'state', 'country'];

    //relationships
    public function user(){
    	return $this->belongsTo('App\Model\User');
    }
    public function country(){
        return $this->belongsTo('App\Country', 'country', 'id');
    }

    public function batch(){
    	return $this->hasMany('App\inventory\Batch');
    }

    public function warehouseproduct(){
    	return $this->hasMany('App\WarehouseProduct');
    }
}
