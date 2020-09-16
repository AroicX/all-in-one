<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class InvoiceGroup extends Model
{
    //
    protected $fillable = ['company_id', 'name'];

    public function company(){
    	return $this->belongsTo('App\Company');
    }
}
