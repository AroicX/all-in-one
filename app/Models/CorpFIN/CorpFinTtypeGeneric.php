<?php

namespace App\Models\CorpFIN;

use Illuminate\Database\Eloquent\Model;

class CorpFinTtypeGeneric extends Model
{
    protected $fillable = ['sub_id', 'code', 'trans_category_id', 'trans_type_id','acc_class_id','acc_sub_class_id', 'account_id', 'dr_cr', 'vat_inc', 'vat_exc', 'wht', 'without_tax', 'created_at', 'updated_at'];
}
