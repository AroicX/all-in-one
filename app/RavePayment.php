<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RavePayment extends Model
{
    //
    protected $table = 'rave_payments';

    protected $guarded = ['id','user_id','company_id'];
}
