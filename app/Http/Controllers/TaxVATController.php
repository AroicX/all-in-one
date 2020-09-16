<?php

namespace App\Http\Controllers;

use App\Vat;
use Auth;
use Illuminate\Http\Request;
use Session;

class TaxVATController extends Controller
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
        return view('CorpFIN.Settings.Tax_rate', ['company' => $company]);
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
            Vat::create($data);
        } catch (\Exception $e) {
            Session::flash("error", "Integrity constraint violation");
//            dd($e->getMessage());
        }

        Session::flash("success", "Vat rate successfully added");
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
            'date' => date('Y-m-d')
        );

        try{
            $vat = Vat::find($request->get('id'));
            $vat->update($data);
            Session::flash("success", "Vat updated successfully");
        }
        catch(\Exception $e)
        {
            Session::flash("error", "Integrity constraint violation");
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
        $company = Auth::user()->company;

        try {
            $vat = Vat::where('id', $request->get('id'));
            $vat->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'fail'], 400);
        }
        return redirect()->back()->with(['success' => 'Deleted Successfully']);
    }
}
