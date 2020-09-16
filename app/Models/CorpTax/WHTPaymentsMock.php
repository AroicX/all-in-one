<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/27/16
 * Time: 11:38 AM
 */

namespace App\Models\CorpTax;


use Illuminate\Database\Eloquent\Model;

class WHTPaymentsMock extends Model
{

    protected $guarded = ['id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movementSchedule()
    {
        return $this->belongsTo(WHTMovementScheduleMock::class, 'payment_id');
    }
}