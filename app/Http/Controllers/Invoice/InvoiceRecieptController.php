<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpFIN\InvoiceReciept;
use App\Models\CorpFIN\Invoice;
use App\CorpFinTranPartner;

use App\Jobs\InvoiceRecieptJob;
use Carbon\Carbon;
use Auth;
class InvoiceRecieptController extends Controller
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
        $store = self::store($data);
        if($store)
        {
            $invoice = Invoice::find($data['invoice_id']);
            $invoice->status = "paid";
            $invoice->save();
            /*if($invoice->status == 'paid')
            {
                $request->request->add([
                    'title' => 'coporate liability tax for '.$data['from_date'].' - '.$data['to_date'],
                    'transaction_category_id' => 47,
                    'transaction_type_id' => 105,
                    'transaction_date' => $data['to_date'],
                    'amount' => $data['coporate_tax_liability'],
                ]);
                $create_ledger = CorpfinEntryController::add_entry($request);
            }*/
            $client = CorpFinTranPartner::find($invoice->client_id);
            $email_job = (new InvoiceRecieptJob($invoice, $store, $client, Auth::user()->company,))->delay(Carbon::now()->addSeconds(3));
            dispatch($email_job);
            return response()->json(['status' => 'success', 'data' => $store ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($data)
    {
        $create = InvoiceReciept::create($data);
        return $create;
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
