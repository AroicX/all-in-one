<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class CorpFinInvoiceItem extends Model
{
    protected $guarded = ['id'];
    public function product(){
    	return $this->belongsTo('App\CorpFinProduct');
    }
    public function service(){
    	return $this->belongsTo('App\CorpFinService');
    }
}
