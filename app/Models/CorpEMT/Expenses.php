<?php

namespace App\Models\CorpEMT;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    // set fillable field
    protected $fillable = [
        'deal_id',
        'client_id',
        'company_id',
        'name',
        'description',
        'amount'
    ];
}
