<?php

namespace App\Model\CorpPay;

use Illuminate\Database\Eloquent\Model;

class PriceQuote extends Model
{
    protected $table = 'corppay_price_quote';

    public function vendor()
    {
        return $this->hasOne('App\Model\CorpPay\Vendor', 'id');
    }
}
