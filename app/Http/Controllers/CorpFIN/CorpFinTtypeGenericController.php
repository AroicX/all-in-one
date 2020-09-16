<?php

namespace App\Http\Controllers\CorpFIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpFIN\CorpFinTtypeGeneric;
use App\Models\CorpFIN\AccountClass;
use App\Models\CorpFIN\AccountSubClass;
use App\Models\CorpFIN\TransCategory;
use App\Models\CorpFIN\TransType;
use DB;

class CorpFinTtypeGenericController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($data)
    {
        $store = CorpFinTtypeGeneric::create($data);
        return $store; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function migrate_old_to_new()
    {
        $generics = DB::table('corpfin_ttype_generic')->get();
        foreach ($generics as $generic) {
            $trans_type = DB::table('trans_types')->where('name', $generic->name)->select('id', 'trans_cat_id')->first();
            $acc_sub_class = AccountSubClass::where('name', $generic->sub_class)->select('id', 'class_id')->first();
            $account = DB::table('coa')->where('account_number', $generic->acc_no)->where('account', $generic->acc)->select('id', 'account_number')->first();
            // return $trans_type->trans_cat_id;
            if(!empty($trans_type->id) && !empty($trans_type->trans_cat_id) && !empty($account) && !empty($acc_sub_class))
            {
                $data = [
                    'sub_id' => $generic->sub_id,
                    'code' => $generic->code,
                    'trans_category_id' => $trans_type->trans_cat_id,
                    'trans_type_id' => $trans_type->id,
                    'acc_class_id' => $acc_sub_class->class_id,
                    'acc_sub_class_id' => $acc_sub_class->id,
                    'account_id' => $account->id,
                    'dr_cr' => $generic->dr_cr,
                    'vat_inc' => $generic->vat_inc,
                    'vat_exc' => $generic->vat_exc,
                    'wht' => $generic->wht,
                    'without_tax' => $generic->without_tax

                ];
                // if(CorpFinTtypeGeneric::where())
                // return $data;
                $store = self::store($data);
            }
        }
        return 1;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
