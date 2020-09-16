<?php

namespace App\Model\CorpPay;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $table = "vendors";

    public function pricequote()
    {
        return $this->belondsTo('App\Model\CorpPay\PriceQuote', 'id');
    }
}
