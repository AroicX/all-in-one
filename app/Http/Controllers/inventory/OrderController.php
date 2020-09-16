<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\Order;
use Auth;
use App\SubAccount;
use App\Account;
use DB;
use App\inventory\Warehouse;
use App\inventory\WarehouseMovement;

class OrderController extends Controller
{
    //
    public function index(){
        $orders = Auth::user()->order()->paginate(10);
        return view('inventory.order.index', compact('orders'));
    }

    public function create(){
    	return view('inventory.order.create');
    }

    public function store(Request $request){
        $messages= ['payment_date.before_or_equal' => 'The payment date must be on or before today'];
        //dd($request->all());
        $this->validate($request, [
            'purchase_date' => 'date',
            'total_invoice_cost' => 'numeric',
            'shipping' => 'numeric',
            'clearing' => 'numeric',
            'insurance' => 'numeric',
            'other_costs' => 'numeric',
            'commission' => 'numeric',
            'amount_paid' => 'numeric',
            'payment_date' => "date|before_or_equal:".date('d-m-Y')."",
            ], $messages);
    	$order = new Order($request->all());
    	$order->user_id = Auth::user()->id;
        $order->company_id = Auth::user()->company_id;
        $order->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
      
        $total = floatval($request->total_invoice_cost) + floatval($request->shipping) + floatval($request->clearing) + floatval($request->insurance) + floatval($request->other_costs) + floatval($request->commission); 
    	$order->total = $total;
          if (!empty($request->payment_date)) {
         
            $order->payment_date = date('Y-m-d', strtotime($request->payment_date));
            
            $order->balance = $total - $request->amount_paid;
        } 
            $order->balance = $total - floatval($request->amount_paid);
        $order->save();

        //make entry to ledger DR
            $subacct = SubAccount::find(13);
            $acct = Account::find($subacct->account_id);
            $description = $subacct->name . "( " . $request->supplier_name . ")";
           DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d', strtotime($request->purchase_date)) , 'Dr' => $total , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );

        //CR entry 
          if($request->payment_status == "Not yet paid")  {
            $subacct = SubAccount::find(57);
            $description = $subacct->name . "( " . $request->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d', strtotime($request->purchase_date)) , 'Cr' => $total , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );   
          }   
          else{
              $subacct = SubAccount::find(4);
            $description = $subacct->name . "( " . $request->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d', strtotime($request->purchase_date)) , 'Cr' => $request->amount_paid , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );
          }
    	return redirect(url('inventory\order\show', $order->id))->with('status', 'success');
    }

    public function show($id){
    	$order = Order::find($id);
        $products = $order->product()->get();
    	return view('inventory.order.show', compact('order', 'products'));
    }

    public function edit($id){
    	$order = Order::find($id);
    	return view('inventory.order.edit', compact('order'));
    }

    public function update(Request $request, $id){
           $messages= ['payment_date.before_or_equal' => 'The payment date must be on or before today' , 
                        'date_received.before_or_equal' => 'The date of receipt must be on or before today',
            ];
        $this->validate($request, [
            'purchase_date' => 'date',
            'total_invoice_cost' => 'numeric',
            'shipping' => 'numeric',
            'clearing' => 'numeric',
            'insurance' => 'numeric',
            'other_costs' => 'numeric',
            'commission' => 'numeric',
            'amount_paid' => 'numeric',
            'payment_date' => "date|before_or_equal:".date('d-m-Y')."",
            'date_received' => "date|before_or_equal:".date('d-m-Y')."",
            ], $messages);
    	$order = Order::find($id);
         $paid = $order->amount_paid;
    	$order->update($request->all());

 
        // if payment was made, make entries to the general ledger
         if(!empty($request->payment_date)){
           
             $order->payment_date = date('Y-m-d', strtotime($request->payment_date));
             $order->amount_paid = $paid + $request->amount_paid;
             $order->save();
            //debit inventory
             $subacct = SubAccount::find(57);
            $description = $subacct->name . "( " . $order->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d' , strtotime($request->date_received)) , 'Dr' => $request->amount_paid , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );

            //credit bank
               $subacct = SubAccount::find(4);
            $description = $subacct->name . "( " . $order->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d' , strtotime($request->date_received)) , 'Cr' => $request->amount_paid , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );
        }
    	return redirect(url('inventory\order\show', $order->id))->with('status', 'success');
    }

    public function confirm_order(Request $request , $id){
           //if the date received was updated, add entries to general ledger
           $messages= [ 
                        'date_received.before_or_equal' => 'The date of receipt must be on or before today'
            ];
        $this->validate($request, [
            'description' => 'required',
            
            'date_received' => "date|before_or_equal:".date('d-m-Y')."",
            ], $messages);
        $order = Order::find($id);
        $order->update($request->all());
        $order->date_received = date('Y-m-d', strtotime($request->date_received));
        $order->status = "Received";
        $order->save();
        if(!empty($request->date_received)){
            //debit inventory
             $subacct = SubAccount::find($request->description);
            $description = $subacct->name . "( " . $order->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d' , strtotime($request->date_received)) , 'Dr' => $order->total , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );

            //credit inventory in transit
               $subacct = SubAccount::find(13);
            $description = $subacct->name . "( " . $order->supplier_name . ")";
            $acct = Account::find($subacct->account_id);
             DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $subacct->account_id, 'acc_name' => $acct->acct_name, 'date' =>date('Y-m-d' , strtotime($request->date_received)) , 'Cr' => $order->total , 'account_no' =>$subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' =>$description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
                );
        
          
        }
        return back()->with('status', 'success');
    }

}
