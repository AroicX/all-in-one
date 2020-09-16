<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable = ['name', 'address', 'city', 'state', 'country'];

    public function user(){
    	return $this->belongsTo('App\Model\User');
    }
}
