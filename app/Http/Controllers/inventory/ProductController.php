<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\Product;
use Auth;
use App\inventory\ProductLineItem;
use App\inventory\ProductLine;
use App\inventory\Order;
use App\inventory\Returns;
use App\Company;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Auth::user()->product()->get();
        $product_lines = ProductLine::all();
        return view('inventory.product.index', compact('products', 'product_lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('inventory.product.create');
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
        $product = new Product($request->all());
        $order = Order::find($request->order_id);
        $date = str_replace("-", "",  $order->purchase_date);
        $barcode = $request->serial_no . "/" . $date;
        $product->barcode = $barcode;
        $product->user_id = Auth::user()->id;
        $product->company_id = Auth::user()->company_id;
        $product->save();
        $order = $product->order()->first();
        // if (!empty($order->warehouse_id) ) {
        //     $transit = Warehouse::where(['company_id' => Auth::user()->company_id, 'name' => 'Transit warehouse'])->first();
            
        //     $wm = new WarehouseMovement();
        //      $wm->from  = $transit->id;
        //      $wm->to = $order->warehouse_id;
        //      $wm->product_id = $value->id;
        //      $wm->save();
        // }
        return redirect(route('product.show', $product->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show a single product 

        $product = Product::find($id);
        $batches = $product->batch()->get();
        $product_lines = Company::find(Auth::user()->company_id)->product_line()->get();
        //dd($product_lines);
        $product_line_item = $product->product_line_item()->get();
        $pli = new ProductLineItem;
        $pli_id = $pli->id;
        if(count($product_line_item)  > 0){
            $pli_exists = true; 
             foreach ($product_line_item as $key ) {
            $pli_id = $key->id;
        
        }
       $pli = ProductLineItem::find($pli_id);
            }
        else{
            $pli_exists = false;
        }
       //    dd($product_lines);
        //dd(count($product_line_item));
        return view('inventory.product.show', compact('product', 'batches', 'product_lines', 'product_line_item', 'pli_exists', 'pli_id', 'pli'));
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
        $product = Product::find($id);
        return view('inventory.product.edit', compact('product'));
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
        $product = Product::find($id);
        $product->update($request->all());
        return redirect(route('product.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete a product
        $product = Product::find($id);
        $product->delete();
        return redirect(route('product.index'));
    }

    public function create_product($id){
        $order = Order::find($id);
        return view('inventory.product.create', compact('order'));
    }

    public function return_product(Request $request){
        dd($request->all());

        $return = new Returns($request->all());
        $return->save();
        $batch = Batch::find($request->batch_id);
        $product = $batch->product()->first();
        $order = $product->order()->first();
        $cost = floatval($batch->unit_cost_sold) * $request->quantity_returned;
        //dr payables 
        
         if($request->amount_returned > 0){
             $subacct = SubAccount::find(57);
             $description = $subacct->name . "(" . $order->supplier_name . ")";
            DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->name, 'date' => date('m-d-y') , 'Dr' => $request->amount_returned , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->acctount_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );
         }

         // cr inventory 
         $subacct = SubAccount::where('name', $batch->description)->first();
          $description = $subacct->name . "(" . $order->supplier_name . ")";
         DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->name, 'date' => date('m-d-y') , 'Cr' => $cost , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->acctount_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );
    }
 }
