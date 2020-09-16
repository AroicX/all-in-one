<?php

namespace App\Http\Controllers;

use App\CorpFinTranTypes;
use Illuminate\Http\Request;
use App\Models\CorpFIN\TransType;

class CorpFinTransTypeCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trans_types = CorpFinTranTypes::all();
        return view('CorpFIN.panel.view_tt', ['trans_types'=>$trans_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $user_id = Auth::user()->id;
//        $company_id = Auth::user()->company_id;
//        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
//
//        $country_id = $y->country;
//        $sellable = $y->deliverable_type;
//        $currency = DB::select(DB::raw("SELECT `p_currency`,`s_currency` FROM countries where id = '$country_id' "));
//        $WHTtype = DB::select(DB::raw("SELECT * FROM  corpfin_whttype"));

        return view('CorpFIN.panel.add_tt', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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

    public function getTransactionType($id)
    {
        try {
            $ttypes = TransType::where('trans_cat_id',$id)->get();
        }
        catch (\Exception $e) {
            return response("Request Failed", 401);
        }

        return response($ttypes);
    }
}
