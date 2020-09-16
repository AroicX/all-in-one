<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class TransType extends Model
{
    protected $table = 'corpfin_ttype_generic';

    protected $fillable = [
        'trans_category_id',
        'name',
    ];


    /**
     * A type transaction belongs to a category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trans_category()
    {
        return $this->belongsTo('App\Models\CorpFIN\TransCategory');
    }

    /**
     * A transaction type may be attached to many accounts
     * @return $this many to many relationship
     */
    public function trans_accounts()
    {
        return $this->belongsToMany('App\Models\CorpFIN\Account')
            ->withPivot(['dr_cr', 'vat_inc', 'vat_exc', 'wht', 'without_tax'])
            ->withTimestamps();
    }
}
