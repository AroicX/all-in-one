<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class AccountClass extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * A class {Assets|liabilities etc} may be attached to many accounts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\CorpFIN\Account');
    }
}
