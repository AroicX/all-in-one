<?php

namespace App\Http\Controllers\CorpFIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpFIN\FinancialYearReport;
use Auth, Validator;
use App\Http\Controllers\CorpFIN\CorpfinEntryController;

class FinancialYearReportController extends Controller
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
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'to_date' => 'required',
            'from_date' => 'required',
            'coporate_income_tax' => 'required',
            'coporate_tax_liability' => 'required',
            'gross_profit' => 'required',
            'profit_before_tax' => 'required',
        ]);

        if($validation->fails()){
            return $validation->errors();
        }
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['company_id'] = Auth::user()->company->id;
        // return $data;
        $store = self::store($data);
        $request->request->add([
            'title' => 'coporate liability tax for '.$data['from_date'].' - '.$data['to_date'],
            'transaction_category_id' => 47,
            'transaction_type_id' => 105,
            'transaction_date' => $data['to_date'],
            'amount' => $data['coporate_tax_liability'],
        ]);
        $create_ledger = CorpfinEntryController::add_entry($request);
        return response()->json([ 'status' => 'ok', 'data' => $store, 'msg' => 'CIT Computation Save Successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(array $data)
    {
        
        $store = new FinancialYearReport;
        $store->user_id =  $data['user_id'];
        $store->company_id =  $data['company_id'];
        $store->from_date =  $data['from_date'];
        $store->to_date =  $data['to_date'];
        $store->gross_profit =  $data['gross_profit'];
        $store->revenue =  $data['revenue'];
        $store->direct_cost =  $data['direct_cost'];
        $store->depreciation =  $data['depreciation'];
        $store->finance_cost =  $data['finance_cost'];
        $store->operating_cost =  $data['operating_cost'];
        $store->profit_before_tax =  $data['profit_before_tax'];
        $store->accessable_profit =  $data['accessable_profit'];
        $store->capital_allowance =  $data['capital_allowance'];
        $store->minimum_tax =  $data['minimum_tax'];
        $store->taxable_profit =  $data['taxable_profit'];
        $store->capital_allowance_bf =  $data['capital_allowance_bf'];
        $store->capital_allowance_cf =  $data['capital_allowance_cf'];
        $store->capital_allowance_utitlized =  $data['capital_allowance_utitlized'];
        $store->edu_tax =  $data['edu_tax'];
        $store->disallowed_items =  $data['disallowed_items'];
        $store->disallowed_value =  $data['disallowed_value'];
        $store->coporate_income_tax =  $data['coporate_income_tax'];
        $store->coporate_tax_liability =  $data['coporate_tax_liability'];
        $store->meta =  $data['meta'] ?? '';
        $store->save();
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
}
