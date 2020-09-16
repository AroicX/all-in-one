<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = [
        'account_class_id',
        'account_sub_class_id',
        'acct_name',
        'acct_no',
    ];


    /**
     * An account belongs to a subclass
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subclass()
    {
        return $this->belongsTo('App\Models\CorpFIN\AccountSubClass');
    }

    /**
     * An account belongs to a class of account
     * such as Liabilities, Assets etc
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acct_class()
    {
        return $this->belongsTo('App\Models\CorpFIN\AccountClass');
    }

    /**
     * Each account may be attached to many transaction types
     * @return $this many to many relationships
     */
    public function trans_types()
    {
        return $this->belongsToMany('App\Models\CorpFIN\TransType')
            ->withPivot(['dr_cr', 'vat_inc', 'vat_exc', 'wht', 'without_tax'])
            ->withTimestamps();
    }


    /**
     * an acoount Is related to sbaccount
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_account()
    {
        return $this->belongsTo('App\Models\CorpFIN\SubAccount');
    }
}
