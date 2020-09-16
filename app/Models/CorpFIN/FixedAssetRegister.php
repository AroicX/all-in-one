<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class FixedAssetRegister extends Model
{
    public function asset_sub_account(){
    	return $this->belongsTo('App\AssetSubAccount');
    }
}
