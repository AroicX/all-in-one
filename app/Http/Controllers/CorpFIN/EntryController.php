<?php

namespace App\Http\Controllers\CorpFIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\CorpFinProduct;
use App\Models\CorpFIN\TransCategory;
use App\Models\CorpFIN\SampleEntry;

class EntryController extends Controller
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
        $company = auth()->user()->company;
           
        if (!empty($company->CRN) && !empty($company->FYE)) {
//                $type = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
            $sellable = $company->deliverable_type;
            $clients = $company->transPartners()->get();
            

            $T_types = DB::table('corpfin_ttype_generic')->select(
                array(DB::raw(
                    'GROUP_CONCAT(DISTINCT name) as   name,
                    GROUP_CONCAT(DISTINCT category) AS category,
                    GROUP_CONCAT(DISTINCT id) AS id'
                )
                )
            )->groupBy('sub_id')->where(['code' => 'INV'])->get();
            $products = CorpFinProduct::where('company_id', $company->id)->get();
            $sample_entries = SampleEntry::where('company_id', $company->id)->get();
            $trans_categories = TransCategory::get();
            return view('CorpFIN.panel.add_entry', [ 'company' => $company, 'products' => $products, 'deliverable_type' => $sellable, 'types' => $company, 'T_types' => $T_types, 'clients' => $clients, 'trans_categories' => $trans_categories, 'sample_entries' => $sample_entries]);
        }

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
}
