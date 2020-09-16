<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorpFinService extends Model
{
    use SoftDeletes;

    protected $fillable = ['name',
        'company_id' ,
        'category',
        'measure',
        'rp',
        'vat_id',
        'wht_id',
        'taxes' ,
        'taxes_description',
        'price'
    ];


    public function setWhtIdAttribute($wht_id)
    {
        if(empty($wht_id))
            $this->attributes['wht_id'] = null;
        else
            $this->attributes['wht_id'] = $wht_id;
    }

    public function setVatIdAttribute($vat_id)
    {
        if(empty($vat_id))
            $this->attributes['vat_id'] = null;
        else
            $this->attributes['vat_id'] = $vat_id;
    }

}
