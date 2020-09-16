<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/27/16
 * Time: 11:37 AM
 */

namespace App\Models\CorpTax;


use Illuminate\Database\Eloquent\Model;

class WHTMovementScheduleMock extends Model
{

    protected  $guarded = ['id'];

    protected $table = 'WHT_movement_schedule';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(WHTPaymentsMock::class, 'movement_id');
    }
}