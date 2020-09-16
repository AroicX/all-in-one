<?php

namespace App\Http\Controllers\Corpfin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth, Validator;
use Response;
use App\Account;
use App\SubAccount;
use App\CorpFinProduct;
use App\CorpFinService;
use App\CorpFinTranPartner;
use Carbon\Carbon;
use App\Http\Controllers\CorpFIN\FixedAssetRegisterController;

class CorpfinEntryController extends Controller
{
    //

    public static function add_entry(Request $request)
    {
        $validation = Validator::make(request()->all(),
        [ 
            'title' => 'required',
            'transaction_category_id' => 'required',
            'transaction_type_id' => 'required',
            'transaction_date' => 'required',
            
        ]);

        if($validation->fails()){
            return $validation->errors()->all();
        }
        $data = $request->all();
        #invoice customer - Sale of goods without taxes
        if ($request->transaction_type_id == 1 || $request->transaction_type_id == 3 || $request->transaction_type_id == 5)
        {
            foreach ($data['products'] as $product) {
                $item = CorpFinProduct::findOrFail($product['id']);
                $data['title'] = $data['title'].' - '.$item->name;
                if ($request->transaction_type_id == 1)
                {
                    $data['amount'] = $item->price * $product['qty'];
                }
                if ($request->transaction_type_id == 3)
                {
                    $data['amount'] = $item->price * $product['qty'];
                    $data['markup'] = $item->markup  * $product['qty'];
                    //$data['vat'] = $item->vat * $product['qty'];
                }
                if ($request->transaction_type_id == 5)
                {
                    $data['net'] = $item->net * $product['qty'];
                    $data['gross'] = $item->gross * $product['qty'];
                    $data['vat'] = $item->vat * $product['qty'];
                }
                // return $data;
                self::save_entry($data);
            }
        } elseif ($request->transaction_type_id == 2 || $request->transaction_type_id == 6)
        {
            #invoice customer - Provision of services without taxes
            foreach ($data['services'] as $service) {
                $item = CorpFinService::findOrFail($service['id']);
                $data['title'] = $data['title'].' - '.$item->name;
                if ($request->transaction_type_id == 2)
                {
                    $data['amount'] = $item->price * $service['qty'];
                }
                if ($request->transaction_type_id == 6)
                {
                    $data['net'] = $item->net;
                    $data['gross'] = $item->gross;
                    $data['vat'] = $item->vat;
                }
               
                return self::save_entry($data);
            }
        }else{
            return self::save_entry($data);
        }
    }
    public static function save_entry($data){
        // $this->validate($request, [
        //     'date' => "required|before_or_equal:".date('m/d/Y').""
        //     ]);
    	$t_type_id = $data['transaction_type_id'];
        $ttypes = DB::table('trans_type_table')->where('trans_type_id', $t_type_id)->get();
        foreach ($ttypes as $key ) {
                $account = DB::table('accounts')->where('id', $key->account_id)->first();
                $acct_name = $account->acct_name;
                $subacct = DB::table('sub_accounts')->where('sub_account_no', $key->sub_acct_no)->first();
                
               
                if($key->sub_acct_no == "Asset sub-account"){
                    $asset_sub_account = DB::table('asset_sub_account')->where('id',  $data['asset_sub_acct'])->first();
                    $subacct_no = $asset_sub_account->sub_account_no;
                    $subacct_name = $asset_sub_account->name;
                    #register fixed asset register if terms match
                    if( $t_type_id == 17 || $t_type_id ==18 )
                    {
                        $dep_rate = 0;
                        $fixed_asset_register = [
                            'account_no' => $subacct_no,
                            'asset_sub_account_id' => $asset_sub_account->id,
                            'description' => $data['title'],
                            'date' => $data['transaction_date'],
                            'amount' => number_format((float)$data['amount'], 2, '.', ''),
                            'dep_rate' => $dep_rate
                        ];
                        #make fixed asset entry
                        FixedAssetRegisterController::store($fixed_asset_register);
                    }
                }
                elseif ($key->sub_acct_no == "OpEx Sub Account") {
                    $opex_sub_account = DB::table('opex_sub_account')->where('id',  $data['opex_sub_acct'])->first();
                   
                    $subacct_no = $opex_sub_account->sub_account_no;
                    $subacct_name = $opex_sub_account->name;
                }
                elseif ($key->sub_acct_no == "Depreciation Expenses sub-account") {
                    $depreciation_subacct = DB::table('depreciation_exp_sub_acct')->where('id', $data['asset_type'])->first();
                    
                    $subacct_no = $depreciation_subacct->sub_account_no;
                    $subacct_name = $depreciation_subacct->name;
                }
                elseif ($key->sub_acct_no == "Accumulated Depreciation sub-account") {
                    $accumulated_subacct = DB::table('accumulated_dep_sub_acct')->where('id', $data['asset_type'])->first();
                    
                    $subacct_no = $accumulated_subacct->sub_account_no;
                    $subacct_name = $accumulated_subacct->name;
                }
                else{
                     $subacct_no = $key->sub_acct_no; 
                     $subacct_name = $subacct->name;
                }
                $description = $subacct_name . "(" . $data['title'] . ")";
                if(!empty($data['transaction_partner_id']))
                {
                    $partner = CorpFinTranPartner::where('id', $data['transaction_partner_id'])->select('id', 'name')->first();
                    $description = $subacct_name . "(" . $data['title'] . ") - ". $partner->name;
                }
                //get the amount to be posted in the entry 
                switch ($key->column_add_entry) {
                        case 'amt':
                            $amount = $data['amount'];
                            break;
                        case 'gross_amt':
                            $amount = $data['gross'];
                            break;
                        case 'net_amt':
                            $amount = $data['net'];
                                break;
                        case 'vat_amt':
                            $amount = $data['vat'];    
                            break;
                        case 'new_amt':
                            $amount = $data['new'];
                            break;
                        case 'old_amt':
                            $amount = $data['old'];
                            break;
                        case 'amt+markup':
                            $amount = $data['amount'];
                            $markup = $data['markup'];
                            $amount += $markup;
                            break;
                        case 'amt_unused':
                            $amount = $data['unused'];
                            break;
                        case 'amt_used':
                            $amount = $data['used'];
                            break;                              
                        default:
                            # code...
                            break;
                    }
                $company_id = Auth::user()->company_id;
                $trans_date = Carbon::parse($data['transaction_date']);
                if($key->dr_cr_1_0 == 1){

                $entry = DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $key->account_id, 'acc_name' => $acct_name, 'date' => $trans_date, 'Dr' => $amount , 'account_no' =>$subacct_no , 'company_id' => Auth::user()->company_id, /*'customer_id' => $data['transaction_partner_id'],*/ 'description' =>$description, 'class_id' => $key->class_id, 'subclass_id' => $key->sub_class_id]
                );   
                }
                else{
                    $entry = DB::table('corpfin_generalledger')->insert(
                    ['account_id' => $key->account_id, 'acc_name' => $acct_name, 'date' => $trans_date, 'Cr' => $amount , 'account_no' =>$subacct_no , 'company_id' => $company_id, /*'customer_id' => $data['transaction_partner_id'],*/ 'description' =>$description, 'class_id' => $key->class_id, 'subclass_id' => $key->sub_class_id]
                );
                }


            } 
            return response::json(['status'=>'ok', 'msg' => 'Ledger Entry Successful', 'entry' => $entry]);
            //return redirect(url('corpfin/view_ledgers'))->with("status", "Success");
 
    }


    //return products 
    public function get_products(){
    	$products = DB::table('corp_fin_products')->where('company_id', Auth::user()->company_id)->get();
    	return response::json($products);
    }

    public function get_product($id){
        $product = DB::table('corp_fin_products')->where(['company_id'=> Auth::user()->company_id, 'id' => $id])->get();
        return response::json($product);
    }

    public function get_asset_sub_acct(){
        $sub_accounts = DB::table('asset_sub_account')->get();
        return response::json($sub_accounts);
    }

    public function get_depreciation_exp_sub_acct(){
        $sub_accounts = DB::table('depreciation_exp_sub_acct')->get();
        return response::json($sub_accounts);
    }

      public function get_opex_sub_acct(){
        $sub_accounts = DB::table('opex_sub_account')->get();
        return response::json($sub_accounts);
    }

    public function get_asset_type(){
        $assets = DB::table('asset_types')->get();
        return response::json($assets);
    }

    public function view_ledgers(){
     $ledgers =   DB::table('corpfin_generalledger')->where('company_id', Auth::user()->company_id)->orderBy('date', 'desc')->paginate(20);

     $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        return view('CorpFIN.panel.view_ledgers', compact('ledgers', 'debit_sum', 'credit_sum'));
    }

    public function filter_ledger(){

        $account = request()->account;
        $from =request()->from;
        $to = request()->to;

        if($account == "all"){

        $ledgers =   DB::table('corpfin_generalledger')->where('company_id', Auth::user()->company_id)->whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();

         $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        
        }
        else{
            $ledgers =   DB::table('corpfin_generalledger')->where(['company_id' => Auth::user()->company_id, 'account_id' => $account])->whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();

         $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        }
        return view('CorpFIN.panel.view_ledgers', compact('ledgers', 'debit_sum', 'credit_sum'));
     
    }
    public function filter_trad_ledger(){

        $account = request()->account;
        $from =request()->from;
        $to = request()->to;

        if($account == "all"){

        $ledgers =   DB::table('corpfin_generalledger')->where('company_id', Auth::user()->company_id)->whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();

         $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        
        }
        else{
            $ledgers =   DB::table('corpfin_generalledger')->where(['company_id' => Auth::user()->company_id, 'account_id' => $account])->whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();

         $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        }
         return view('CorpFIN.traditional.general_ledger', compact('ledgers', 'debit_sum' , 'credit_sum'));
     
    }

    //show the general ledger for the traditional view
    public function trad_general_ledger(){
        $ledgers = DB::table('corpfin_generalledger')->where('company_id', Auth::user()->company_id)->orderBy('date', 'desc')->get();
         $debit_sum = $ledgers->sum('Dr');
         $credit_sum = $ledgers->sum('Cr');
        return view('CorpFIN.traditional.general_ledger', compact('ledgers', 'debit_sum' , 'credit_sum'));
    }

    //return accounts 
    public function get_accounts(){
        $accounts = Account::all();
        return response::json($accounts);
    }

    public function store_diary(Request $request){
       // dd($request->all());
         $date = $request->date;
        $newdate = date('Y-m-d', strtotime($date));
        //dd($newdate);
        $account_id = $request->account_id;
        $subacct = $request->subaccount_id;
        $debit = $request->debit;
        $credit = $request->credit;

        foreach ($account_id as $key => $value) {
            $acct = Account::find($value);
            $acct_name = $acct->acct_name;
            
            $sub_acct = SubAccount::find($subacct[$key]);
           //dd($sub_acct);
            $subacct_no = $sub_acct->sub_account_no;
            $description = $sub_acct->name . "(" . $request->name . ")";
            DB::table("corpfin_generalledger")->insert([ "account_id" =>$value, "account_number" => $subacct_no, "Dr" => $debit[$key], "Cr" => $credit[$key], "date" =>$newdate, "description" => $description, "account_name" => $acct_name, "company_id" => Auth::user()->company_id, 'subclass_id' =>$acct->subclass_id, 'class_id' => $sub_acct->account_class_id
                ]);
        }

        return redirect(url('/corpfin/traditional/general_ledger'))->with('status', 'success');
    }

    public function get_subaccounts(){
        $sub_accounts = SubAccount::all();
        return response::json($sub_accounts);
    }
}
