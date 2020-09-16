<?php
/**
 * Created by PhpStorm.
 * User: dubem
 * Date: 1/19/17
 * Time: 5:46 PM
 */

namespace App\Models\CorpTax;


use Illuminate\Database\Eloquent\Model;

class TrialBalanceMock extends Model
{
    protected $table = 'trial_balance';

    protected $guarded = ['id'];
}