<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class SubAccount extends Model
{
    protected $fillable = ['name'];

    /**
     * sub account has many associated account
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\CorpFIN\Account');
    }
}
