<?php

namespace App\Http\Controllers\Corpfin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpFIN\FixedAssetRegister;
use Auth;
class FixedAssetRegisterController extends Controller
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

        $data = $request->all();
        $register = self::store($data);
        return response()->json(['status' => 'ok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($data)
    {
        $store = new FixedAssetRegister;
        $store->company_id = Auth::user()->company->id;
        $store->account_no = $data['account_no'];
        $store->asset_sub_account_id = $data['asset_sub_account_id'];
        $store->description = $data['description'];
        $store->date = $data['date'];
        $store->amount = $data['amount'];
        $store->dep_rate = $data['dep_rate'] ?? '';
        $store->save();
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
    public static function update(Request $request)
    {
        $update = FixedAssetRegister::find($request->id);
        if(!empty($request->disposed))
        {
            $update->disposed = $request->disposed;
        }
        if(!empty($request->capital_allowance_completed))
        {
            $update->capital_allowance_completed += $request->capital_allowance_completed;
        }
        $update->save();
        return $update;
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
