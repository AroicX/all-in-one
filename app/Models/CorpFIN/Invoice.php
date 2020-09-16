<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable= ['client_id', 'invoice_date', 'password', 'invoice_group_id' , 'company_id', 'discount_percent', 'discount_amount'];

    public function company(){
    	return $this->belongsTo('App\Company');
    }

    public function payment(){
    	return $this->hasMany('App\Models\CorpFIN\Payment');
    }
    public function invoice_items(){
    	return $this->hasMany('App\Models\CorpFIN\CorpFinInvoiceItem');
    }
}
