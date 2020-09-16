<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wht extends Model
{
    protected $fillable = [
        'company_id',
        'rate',
        'type',
    ];
}
