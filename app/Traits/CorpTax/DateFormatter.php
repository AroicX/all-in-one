<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/25/16
 * Time: 5:48 AM
 */

namespace App\Traits\CorpTax;


use Carbon\Carbon;

trait DateFormatter
{

    public function formatDateForDB($data)
    {
        $date = explode('/', $data);
        $date = Carbon::createFromDate((int) $date[2], (int) $date[0], (int) $date[1], 'Africa/lagos');
        
        return $date;
    }
}