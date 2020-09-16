<?php

namespace App\Http\Controllers;

use App\Wht;
use Auth;
use Illuminate\Http\Request;
use Session;

class TaxWHTController extends Controller
{

    public function __construct()
    {
        $this->middleware('CorpFINSub');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->company;
        return view('CorpFIN.Settings.Tax_rate_wht', ['company' => $company]);
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
        $data = [
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate')
        ];

        try {
            Wht::create($data);
            Session::flash("success", "WHT added successfully");
        } catch (\Exception $e) {
            Session::flash("error", "WHT update Failed");
        }

        return redirect()->back();
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
    public function update(Request $request)
    {
        $data = array(
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate'),
        );

        try{
            $vat = Wht::find($request->get('id'));
            $vat->update($data);
            Session::flash("success", "at updated successfully");
        }
        catch(\Exception $e)
        {
            Session::flash("error", "Update failed");
        }

        return redirect()->back();
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
            $wht = Wht::findOrFail($request->get('id'));
            $wht->delete();
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => 'fail'], 400);
        }

        return redirect()->back()->with(['success' => 'success']);

    }
}
