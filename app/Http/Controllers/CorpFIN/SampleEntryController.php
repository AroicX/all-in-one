<?php

namespace App\Http\Controllers\CorpFIN;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CorpFIN\SampleEntry;
use Auth;
class SampleEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = Auth::user()->company->id;
        $sample_entry = SampleEntry::where('company', $company_id)->get();
        return response(['status' => 'success', 'data' => $sample_entry]);
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
        $company_id = Auth::user()->company->id;
        $data = $request->all();
        $sample_entry = new SampleEntry;
        $sample_entry->company_id = $company_id;
        $sample_entry->title = $data['title'];
        $sample_entry->color = $data['color'];
        $sample_entry->data = json_encode($data);
        $sample_entry->save();
        return response(['status' => 'success', 'data' => $sample_entry]);

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
