<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\Shop;
use Auth;
use App\inventory\ShopMovement;
use App\inventory\Batch;
use App\inventory\ShopProduct;
use App\inventory\ShopLedger;
use App\inventory\Product;
use App\SubAccount;
use App\Account;
use App\inventory\Warehouse;
use App\inventory\ManRetailLedger;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $shop = Shop::where('company_id', Auth::user()->company_id)->get();
        return view('inventory.shop.index', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('inventory.shop.create');
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
        $shop = new Shop($request->all());
        $shop->user_id = Auth::user()->id;
        $shop->company_id = Auth::user()->company_id;
        $shop->save();
        return redirect(route('shop.show', $shop->id));
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
        $shop = Shop::find($id);
        $shop_products = ShopProduct::where('shop_id', $id)->get();
        $products = Product::where('company_id', Auth::user()->company_id)->get();
        $ledgers = ShopLedger::where('shop_id', $shop->id)->orderBy('date', 'desc')->get();
        $debit_sum = $ledgers->sum('Dr');
        $credit_sum = $ledgers->sum('Cr');
        return view('inventory.shop.show', compact('shop', 'shop_products' , 'products' , 'ledgers' , 'debit_sum', 'credit_sum'));
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
        $shop= Shop::find($id);
        return view('inventory.shop.edit', compact('shop'));
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
        $shop = Shop::find($id);
        $shop->update($request->all());
        return redirect(route('shop.show', $id));
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
        $shop = Shop::find($id);
        $shop->delete();
        return redirect(route('shop.show', $id));
    }

    public function shop_movement(Request $request){
        //dd($request->all());
        $shop_move = new ShopMovement($request->all());
        $shop_move->from = $request->from;
        $shop_move->save();

        //update the quantity remaining for batch
        $batch = Batch::find($request->batch_id);
        $quantity = $batch->quantity;
        $qty_moved = $request->quantity_moved;
        $qty_remaining = $quantity - $qty_moved;
        $batch->quantity = $qty_remaining;

        $batch->save();

        //add moved product to shop table
        $shopproduct = ShopProduct::where(['batch_id' => $request->batch_id, 'shop_id' => $request->shop_id ])->first();
        if(count($shopproduct) > 0){
            $shop_product = ShopProduct::find($shopproduct->id);
            $quantity_moved = $qty_moved;
            $quantity = $shop_product->quantity;
            $new_qty = $quantity + $quantity_moved;
            //$shop_product->quantity = $new_qty;
            //$shop_product->from = $request->from;
            $shop_product->save();

        }
        else{
            $shop_product = new ShopProduct();
            $shop_product->batch_id = $batch->id;
            //$shop_product->quantity = $qty_moved;
            $shop_product->shop_id = $request->shop_id;
            $shop_product->product_id = $batch->product_id;

            
            $shop_product->save();
        }

        //entries to shop ledger
         $batch = Batch::find($request->batch_id);
        //make entries to man retail ledger dr goods in transit shop a
        $ledger = new ShopLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Shop::find($request->shop_id)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr = floatval($request->quantity_moved) * floatval($batch->unit_cost_sold) ;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->shop_id = $request->shop_id;
        $ledger->save();
        
        //credit inventory warehouse a
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
         ($request->all());
        $wm = ShopMovement::find($id);
        $wm->quantity_received = $request->quantity;
        $wm->status = "Confirmed";
        $wm->date_received = date('y-m-d', strtotime($request->date_received));
        $wm->save();

         $shopproduct = ShopProduct::where(['batch_id' => $wm->batch_id, 'shop_id' => $wm->shop_id ])->first();
         $shopproduct->quantity = intval($wm->quantity_received) + intval($shopproduct->quantity);
         $shopproduct->save();
        //make entries to warehouse ledger dr inventory warehouse b
        $batch = Batch::find($wm->batch_id);
         $product = $batch->product()->first();
        $order = $product->order()->first();

        //make entries to man retail ledger dr
        $inventory = SubAccount::where('name', $order->description);
        $ledger = new ShopLedger();
        $subacct =  SubAccount::where('name', $order->description)->first();

        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description = $subacct->name ."(" . Shop::find($wm->shop_id)->name .")";
        $ledger->date = $wm->date_received;
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr = floatval($request->quantity) * floatval($batch->unit_cost_sold);
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->shop_id = $wm->shop_id;
        $ledger->save();

        //make entries to man retail ledger cr goods in transit warehouse b
        $ledger = new ShopLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Shop::find($wm->shop_id)->name .")";
        $ledger->date = $wm->date_received;
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Cr = floatval($request->quantity) * floatval($batch->unit_cost_sold) ;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->shop_id =$wm->shop_id;
        $ledger->save();
        return back();
    }


    public function shop_shop(Request $request){
        //dd($request->all());
        $shop_move = new ShopMovement($request->all());
        $shop_move->from = $request->from;
        $shop_move->type = $request->type;
        $shop_move->save();

        //update the quantity remaining for batch
        $batch = Batch::find($request->batch_id);
        $quantity = $batch->quantity;
        $qty_moved = $request->quantity_moved;
        $qty_remaining = $quantity - $qty_moved;
        $batch->quantity = $qty_remaining;
        
        $batch->save();

        //add moved product to shop table
        $shopproduct = ShopProduct::where(['batch_id' => $request->batch_id, 'shop_id' => $request->shop_id ])->first();
        if(count($shopproduct) > 0){
            $shop_product = ShopProduct::find($shopproduct->id);
            $quantity_moved = $qty_moved;
            $quantity = $shop_product->quantity;
            $new_qty = $quantity + $quantity_moved;
            $shop_product->quantity = $new_qty;
            $shop_product->save();

        }
        else{
            $shop_product = new ShopProduct();
            $shop_product->batch_id = $batch->id;
            $shop_product->quantity = $qty_moved;
            $shop_product->shop_id = $request->shop_id;
            $shop_product->product_id = $batch->product_id;
            $shop_product->save();
        }
    
        //entries to shop ledger
         $batch = Batch::find($request->batch_id);
        //make entries to man retail ledger dr goods in transit shop b
        $ledger = new ShopLedger();
        $subacct = SubAccount::find(13);
        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description =  $subacct->name ."(" . Shop::find($request->shop_id)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Dr = floatval($request->quantity_moved) * floatval($batch->unit_cost_sold) ;
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->shop_id = $request->shop_id;
        $ledger->save();

          //credit inventory warehouse a
        $product = $batch->product()->first();
        $order = $product->order()->first();

        //make entries to man retail ledger cr
        $inventory = SubAccount::where('name', $order->description);
        $ledger = new ShopLedger();
        $subacct =  SubAccount::where('name', $order->description)->first();

        $ledger->account_id = $subacct->account_id;
        $ledger->company_id = Auth::user()->company_id;
        $ledger->acc_name = Account::find($subacct->account_id)->acct_name;
        $ledger->description = $subacct->name ."(" . Shop::find($request->from)->name .")";
        $ledger->date = date('y-m-d');
        $ledger->class_id = $subacct->account_class_id;
        $ledger->Cr = floatval($request->quantity_moved) * floatval($batch->unit_cost_sold);
        $ledger->account_no = $subacct->sub_account_no;
        $ledger->subclass_id = $subacct->acct_subclass_id;
        $ledger->shop_id = $request->from;
        $ledger->save();
         return redirect(route('batch.show', $request->batch_id));
    
    }
}
