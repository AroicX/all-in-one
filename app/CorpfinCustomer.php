<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorpfinCustomer extends Model
{
    protected $table = "corpfin_customers";


    public function scopeWithStatus($query, $company_id, $status)
    {
        return $query->where('company_id', $company_id)
            ->where('status', $status);
    }

}
