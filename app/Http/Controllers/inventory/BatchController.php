<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\Product;
use App\inventory\Batch;
use Auth;
use App\inventory\Warehouse;
use App\inventory\WarehouseMovement;
use App\WarehouseProduct;
use App\inventory\ManRetailLedger;

use App\SubAccount;
use App\Account;
class BatchController extends Controller
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
        //

        $batch = new Batch($request->all());
        $batch->product_id = $request->product_id;
        $batch->quantity = $request->quantity_ordered;
        $batch->save();
        $warehouse_movement = new WarehouseMovement();
        $warehouse = Warehouse::where('name' , 'Transit warehouse')->first();
        
        $warehouse_movement->batch_id = $batch->id;
        $warehouse_movement->from = $warehouse->id;
        $warehouse_movement->to = $request->warehouse_id;
        $warehouse_movement->quantity_moved = $request->quantity_ordered;
        $warehouse_movement->save();
        

        $warehouseproduct = new WarehouseProduct();
        $warehouseproduct->batch_id = $batch->id;
        $warehouseproduct->quantity = $batch->quantity;
        $warehouseproduct->warehouse_id = $batch->warehouse_id;
        $warehouseproduct->product_id = $request->product_id;
        $warehouseproduct->save();
       
        //record entries
          //make entries to man retail ledger dr
        $ledger = new ManRetailLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Warehouse::find($request->warehouse_id)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr =  floatval($request->unit_cost_sold) * $request->quantity_ordered;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $request->warehouse_id;
        $ledger->save();

        
        $product = $batch->product()->first();
        $order = $product->order()->first();

        //make entries to man retail ledger cr
        $inventory = SubAccount::where('name', $order->description);
        $ledger = new ManRetailLedger();
        $subacct =  SubAccount::where('name', $order->description)->first();
        
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description = $subacct->name ."(" . Warehouse::find($request->warehouse_id)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Cr = floatval($request->unit_cost_sold) * $request->quantity_ordered;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $request->warehouse_id;
        
        $ledger->save();
        return redirect(route('batch.show', $batch->id));
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
        $batch = Batch::find($id);
        $product = Product::find($batch->product_id);
        $warehouse_movement = $batch->warehouse_movement()->get();
        $warehouses  = Auth::user()->warehouse()->get();
        $shop_movement = $batch->shop_movement()->get();
        $shops = Auth::user()->shop()->get();
        
        return view('inventory.batch.show', compact('batch', 'product', 'warehouse_movement', 'warehouses', 'shop_movement', 'shops'));
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
        $batch = Batch::find($id);
        return view('inventory.batch.edit', compact('batch'));
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
        $batch = Batch::find($id);
        $batch->update($request->all());
        return redirect(route('batch.show', $id));
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
        $batch = Batch::find($id);
        $batch->delete();
        return redirect(route('product.index'));
    }

    public function create_batch($id){

        $product = Product::find($id);
        $warehouses = Auth::user()->warehouse()->get();
       // dd($warehouses);
        return view('inventory.batch.create', compact('product', 'warehouses'));
    }
}
