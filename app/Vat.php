<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    protected $fillable = [
        'company_id',
        'rate',
        'type',
    ];
}
