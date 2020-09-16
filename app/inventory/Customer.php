<?php

namespace App\inventory;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    
    protected $fillable = ['title', 'lastname', 'middle_name', 'firstname', 'email', 'gender', 'website', 'tax_vat', 'customer_group', 'additional_info', 'DOB'];

    //relationship with user model
    public function user(){
    	return $this->belongsTo('App\Model\User');
    }

}
