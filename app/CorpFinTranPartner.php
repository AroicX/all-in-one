<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CorpFinTranPartner extends Model
{
    use Notifiable;
    
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'tel',
        'comp_numb',
        'tin',
        'address',
        'country_id',
        'country_id',
        'state_id',
        'state_id',
        'document',
    ];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    /**
     * A transaction partner belongs to a company
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
