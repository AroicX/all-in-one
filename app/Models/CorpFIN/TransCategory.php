<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class TransCategory extends Model
{
    protected $table = 'trans_categories';
    protected $fillable = [
        'code',
        'name',
    ];

    public function trans_types()
    {
        return $this->hasMany('App\Models\CorpFIN\TransType');
    }
}
