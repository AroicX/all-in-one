<?php

namespace App\Http\Controllers\CorpFIN;

use App\CorpFinTranPartner;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\CorpFinTransAddRequest;
use App\Models\CorpFIN\TransCategory;
use App\Models\CorpFIN\TransType;
use Auth, DB;
use Illuminate\Http\Request;
use Session;

class CorpFinTransactionCtrl extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = CorpFinTranPartner::paginate(10);
        return view('CorpFIN.panel.view_tp', ['partners'=>$partners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Auth::user()->company;
            
        $countries = Country::all();
        return view('CorpFIN.panel.add_tp', ['countries' => $countries, 'company' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorpFinTransAddRequest $request)
    {
        try{
            $input = $request->all();
            Auth::user()->company->transPartners()->create($input);
            Session::flash('success', "Transaction partner successfully added");
        }
        catch(\Exception $e)
        {
            Session::flash('error', "Error: failed to save data");
            return redirect()->back()->withInput();
        }

        return redirect()->route("corpfin.transaction.view");
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
        try {
            $partner = CorpFinTranPartner::find($id);
        }
        catch(\Exception $e)
        {
            return redirect()->back();
        }

        return view('CorpFIN.panel.add_tp', ['partner'=> $partner]);
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
        try{
            $input = $request->all();
            $partner = CorpFinTranPartner::find($id);
            $partner->update($input);
            Session::flash('success', "Transaction partner successfully updated");
        }
        catch(\Exception $e)
        {
            Session::flash('error', "Error: failed to save data");
        }

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request)
    {
        try {
            $product = CorpFinTranPartner::find($request->get('id'));
            $product->delete();
        }
        catch(\Exception $e)
        {
            return response(['result' => 'fail']);
        }

        return response(['result' => 'success']);
    }

    public function getTransactionType($id)
    {
        try {
            // return $id;
            $cat = TransCategory::findOrFail($id);
            return $ttypes = DB::table('trans_types')->where('trans_cat_id',$id)->get();
            $ttypes = $cat->trans_types()->get();
        }
        catch (\Exception $e) {
            return response("Request Failed", 401);
        }

        return response($ttypes);
    }
}
