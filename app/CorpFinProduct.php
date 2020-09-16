<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorpFinProduct extends Model
{

    protected $table = 'corp_fin_products';

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
        'price',
        'type',
        'gross',
        'net',
        'vat',
        'markup'
    ];

    public function getBuyableIdentifier($options = null){
        return $this->id;
    }

    public function getBuyableDescription($options = null){
        return $this->name;
    }

    public function getBuyablePrice($options = null){
        return $this->price;
    }

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
