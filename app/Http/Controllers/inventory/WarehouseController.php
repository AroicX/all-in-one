<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\inventory\Warehouse;
use App\inventory\Batch;
use App\inventory\WarehouseMovement;
use App\WarehouseProduct;
use App\inventory\ManRetailLedger;
use App\inventory\Product;
use App\SubAccount;
use App\Account;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $warehouses = Warehouse::with('country')->paginate(10);
        // return $warehouse;
        return view('inventory.warehouse.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('inventory.warehouse.create');
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
        $warehouse = new Warehouse($request->all());
        $warehouse->user_id = Auth::user()->id;
        $warehouse->company_id = Auth::user()->company_id;
        $warehouse->save();
        return redirect(route('warehouse.show', $warehouse->id));
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
        $warehouse = Warehouse::find($id);
        $warehouseproduct = $warehouse->warehouseproduct()->get();
        $products = Product::where('company_id', Auth::user()->company_id)->get();
        $ledgers = ManRetailLedger::where('warehouse_id', $warehouse->id)->orderBy('date', 'desc')->get();
        $debit_sum = $ledgers->sum('Dr');
        $credit_sum = $ledgers->sum('Cr');
        return view('inventory.warehouse.show', compact('warehouse', 'warehouseproduct', 'products' ,  'ledgers' , 'debit_sum', 'credit_sum'));
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
        $warehouse = Warehouse::find($id);
        return view('inventory.warehouse.edit', compact('warehouse'));
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
        $warehouse = Warehouse::find($id);
        $warehouse->update($request->all());
        return redirect(route('warehouse.show', $id));
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
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        return redirect(route('warehouse.index'));
    }

    //display form to move a batch
    public function create_movement($id){
        $batch = Batch::find($id);
        $warehouses = Auth::user()->warehouse()->get();
        $shops = Auth::user()->shop()->get();
        return view('inventory.warehouse.create_move', compact('batch', 'warehouses', 'shops'));
    }

    public function store_warehouse_movement(Request $request){

        $warehouse_move = new WarehouseMovement($request->all());
        $warehouse_move->save();
        $warehouseproduct = WarehouseProduct::where(['batch_id' => $request->batch_id, 'warehouse_id' => $request->to ])->first();
        if(count($warehouseproduct ) > 0){
            $edit_record = WarehouseProduct::find($warehouseproduct->id);
            $quantity = $request->quantity_moved;
            $current_quantity = $warehouseproduct->quantity;
            $new_quantity = $quantity + $current_quantity;
           // $edit_record->quantity = $new_quantity;
            $edit_record->save();
        }
        else{
            $new_record = new WarehouseProduct();
            $new_record->batch_id = $request->batch_id;
            $new_record->warehouse_id = $request->to;
            //$new_record->quantity = $request->quantity_moved;
            $batch = Batch::find($request->batch_id);
            $product = Product::find($batch->product_id);
            $product_id = $product->id;
            $new_record->product_id = $product_id;
            $new_record->save();
        }

        $warehousefrom = WarehouseProduct::where(['batch_id' => $request->batch_id, 'warehouse_id' => $request->from ])->first();
           if(count($warehousefrom ) > 0){
            $edit_record = WarehouseProduct::find($warehousefrom->id);
            $quantity = $request->quantity_moved;
            $current_quantity = $warehousefrom->quantity;
            $new_quantity =  $current_quantity - $quantity;
            $edit_record->quantity = $new_quantity;
            $edit_record->save();
        }
        $batch = Batch::find($request->batch_id);
        //make entries to man retail ledger dr
        $ledger = new ManRetailLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Warehouse::find($request->to)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr = floatval($request->quantity_moved) * floatval($batch->unit_cost_sold) ;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $request->to;
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
        $ledger->description = $subacct->name ."(" . Warehouse::find($request->from)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Cr = floatval($request->quantity_moved) * floatval($batch->unit_cost_sold);
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $request->from;
        $ledger->save();
        return redirect(route('batch.show', $request->batch_id));
    }

    public function confirm_move(Request $request, $id){
        $messages = ['date_received.before_or_equal' => 'The date must be before or today'];
        $this->validate($request, [
            'quantity' => 'integer',
            'date_received' => "date|before_or_equal:".date('d-m-Y').""
            ], $messages);
        // dd($request->all());
        $wm = WarehouseMovement::find($id);
        $wm->quantity_received = $request->quantity;
        $wm->status = "Confirmed";
        $wm->date_received = date('y-m-d', strtotime($request->date_received));
        $wm->save();
        $warehouseproduct = WarehouseProduct::where(['batch_id' => $wm->batch_id, 'warehouse_id' => $wm->to ])->first();
       // dd($request->all());  
        $warehouseproduct->quantity = intval($request->quantity) + intval($warehouseproduct->quantity);
        $warehouseproduct->save();
        //make entries to warehouse ledger dr inventory warehouse b
        $batch = Batch::find($wm->batch_id);
         $product = $batch->product()->first();
        $order = $product->order()->first();

        //make entries to man retail ledger dr
        $inventory = SubAccount::where('name', $order->description);
        $ledger = new ManRetailLedger();
        $subacct =  SubAccount::where('name', $order->description)->first();

        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description = $subacct->name ."(" . Warehouse::find($wm->to)->name .")";
        $ledger->date = $wm->date_received;
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr = floatval($request->quantity) * floatval($batch->unit_cost_sold);
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $wm->to;
        $ledger->save();

        //make entries to man retail ledger cr goods in transit warehouse b
        $ledger = new ManRetailLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Warehouse::find($wm->to)->name .")";
        $ledger->date = $wm->date_received;
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Cr = floatval($request->quantity) * floatval($batch->unit_cost_sold) ;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->warehouse_id = $wm->to;
        $ledger->save();
        return back();
    }
}
