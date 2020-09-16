<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class Markup extends Model
{
    //
    protected $fillable = ['type' , 'value'];

    public function company(){
    	return $this->belongsTo('App\Company');
    }
}
