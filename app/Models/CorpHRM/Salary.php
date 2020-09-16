<?php

namespace App\Models\CorpHRM;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    protected $table = "corphrm_salary";


    public function employee()
    {
        return $this->belongsTo('App\Models\CorpHRM\Employee','employee_id','employee_id');
    }

    
}
