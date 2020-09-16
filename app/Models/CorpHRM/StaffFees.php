<?php

namespace App\Models\CorpHRM;

use Illuminate\Database\Eloquent\Model;

class StaffFees extends Model
{
    //
    protected $table = "payroll_staff_fees";


    public function employee()
    {
        return $this->belongsTo('App\Models\CorpHRM\Employee','employee_id','employee_id');
    }
}
