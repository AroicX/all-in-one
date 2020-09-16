<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = ['amount', 'payment_method', 'payment_date', 'invoice_id'];

    public function invoice(){
    	return $this->belongsTo('App\Models\CorpFIN\Invoice');
    }
}
