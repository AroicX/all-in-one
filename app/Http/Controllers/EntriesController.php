<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Entry;
use App\CorpFinProduct;
use App\Models\CorpFIN\TransType;
use App\Models\CorpFIN\TransCategory;
use App\Models\CorpFIN\Account;


class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $entries = Entry::all();
        return $entries;
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
    public function store(Request $request)
    {
        $trans_title = $request->input('title');
        $trans_partner = $request->input('transaction_partners');
        $trans_date = $request->input('transaction_date');
        $trans_category_id = $request->input('transaction_category_id');
        $trans_type_id = $request->input('transaction_type_id');
        $product = $request->input('products[]'); 
        $trans_type = TransType::where('id', $trans_type_id)->get();
        $trans_cat = TransCategory::where('id', $trans_category_id)->first();
        $cat_name = $trans_cat->name;
        $description = $cat_name. "_ ".$trans_partner."(".$trans_title.")";
        $productxs = [];
        $total = 0;

            foreach ($trans_type as $ttype ) {
                $account = Account::where('name', $ttype->acc)->first();
                $acct_name = $account->acct_name;
                $acct_no = $ttype->acc_no;
                $dr_cr = $ttype->dr_cr;
                
                

                switch ($ttype->name){
                    case 'Sale of goods without taxes':
                    
                //get each product and check amount
                foreach($products as $prod){
                    $id = $prod[0];
                    $unit = $prod[1];
                    $product = DB::table('corp_fin_products')->where('id', $id)->first();
                    // $amount = $product->amount * $unit;
                    $total += $unit;

                    
                    
                }
                
                    
                    
                }
                    
            }

        
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
