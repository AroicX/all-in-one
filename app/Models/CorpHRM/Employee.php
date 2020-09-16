<?php

namespace App\Models\CorpHRM;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function fees()
    {
        return $this->hasMany('App\Models\CorpHRM\StaffFees','employee_id','employee_id');
    }

    public function profile()
    {
        return $this->belongsTo('App\Models\CorpHRM\EmployeeProfile','employee_id','user_id');
    }

}
