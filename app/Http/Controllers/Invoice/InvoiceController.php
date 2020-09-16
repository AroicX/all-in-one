<?php

namespace App\Http\Controllers\Invoice;

use App\Company;
use App\CorpfinCustomer;
use App\CorpfinInvoiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use Response;
use Validator;
use Input;
use Hash;
use PDF;
//Use App\pdf\src\LaravelPdf\Facades\Pdf;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CorpFIN\CorpFinInvoiceItemController;

//jobs
use App\Jobs\QouteJob;
use Carbon\Carbon;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\SubscriptionTrait;
use App\Models\CorpFIN\InvoiceGroup;
use App\Models\CorpFIN\Invoice;
use App\Models\CorpFIN\CorpFinInvoiceItem;

use App\CorpFinProduct;
use App\CorpFinService;
use Cart;
use App\Models\CorpFIN\Payment;
use App\Notifications\SaleInvoice;
use App\CorpFinTranPartner;
use App\SubAccount;
use App\Account;
class InvoiceController extends Controller
{


    use SubscriptionTrait;

    /////////Quotes page//////////

    /////////Add Quote/////////////////
    private function cq()
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if(!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $clients = DB::select(DB::raw("SELECT * FROM corpfin_customers WHERE  company_id = '$company_id' AND status = 1 "));
                $invoice_groups = DB::select(DB::raw("SELECT * FROM corpfin_invoice_groups WHERE  company_id = '$company_id'"));
                return view('CorpFIN.Invoice.Create_Quote', ['deliverable_type'=>$sellable,'clients'=>$clients, 'invoice_groups'=>$invoice_groups]);
            }
            else
            {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function Create_quote()
    {
        if (Auth::check()) {
            $query = $this->cq();
            return $this->is_corpfin_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////End Add Quotes/////////////
    ///////////////View Quotes////////////////////
    private function vq()
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if(!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $quotes = DB::select(DB::raw("SELECT * FROM corpfin_invoice WHERE  company_id = '$company_id' AND type = 'Quote' "));
                $products = DB::select(DB::raw("SELECT * FROM corpfin_deliverables WHERE company_id = '$company_id' "));
                $services = DB::select(DB::raw("SELECT * FROM corpfin_deliverables WHERE category = 'Services' AND company_id = '$company_id' "));
                $invoice_groups = DB::select(DB::raw("SELECT * FROM corpfin_invoice_groups WHERE  company_id = '$company_id'"));
                $tax_rates = DB::select(DB::raw("SELECT * FROM corpfin_taxrate WHERE  company_id = '$company_id'"));
                return view('CorpFIN.Invoice.View_Quotes', ['deliverable_type'=>$sellable,'tax_rates'=>$tax_rates,'quotes'=>$quotes,'products'=>$products,'invoice_groups'=> $invoice_groups,'services'=>$services]);
            }
            else
            {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function View_quotes()
    {
        if (Auth::check()) {
            $query = $this->vq();
            return $this->is_corpfin_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    ///////////////////End View Quotes//////////////

    
    //////////////////////End Quotes///////////////////////

    /////////////////////////PDF///////////////////////////
    private function pdf($id)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        //$deliverables = array();
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if(!empty($y->CRN) && !empty($y->FYE)) {
                $country = $y->country;
                $currency = DB::select(DB::raw("SELECT `id`,`p_currency`,`s_currency` FROM countries where name = '$country' "));
                $sellable = $y->deliverable_type;
                $quotes = DB::select(DB::raw("SELECT * FROM corpfin_invoice WHERE  company_id = '$company_id' AND id = '$id' "));
                $deliverables = $this->get_deliverables($quotes);
                return view('CorpFIN.Invoice.pdf', ['deliverable_type'=>$sellable,'quotes'=>$quotes, 'deliverables'=> $deliverables,'company_details' =>$x, 'currencyy' =>$currency]);
            }
            else
            {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    private function get_deliverables($quotes)
    {
        foreach ($quotes as $quote) {
            $company_id = Auth::user()->company_id;
            $id = $quote->id;
            $x = array();
            $x[] = DB::select(DB::raw("SELECT * FROM corpfin_invoice_deliverables WHERE  invoice_id = '$id' "));
        }
        return $x;
    }

    public function view_pdf($id)
    {
        if (Auth::check()) {
            $query = $this->pdf($id);
            return $this->is_corpfin_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////////////////////END PDF///////////////////////

    /////////////////////////Token///////////////////////////
    public function genetratetoken($length,$table,$row) 
    {
        $code = 0;
        $check = true;//$this->check_code_exist($code);
        while($check)
        {
            $code = $this->generate_new_token($length);
            $check = $this->check_token($table, $row, $code);
        } 
        return $code;
    }

    private function generate_new_token($length) 
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    private function check_token($table,$row,$code) 
    {
     
        $p_exist = DB::select(DB::raw("SELECT * FROM $table WHERE $row = '$code' "));

        if (!empty($p_exist)) {
                $result = true;
        }
        else
        {
                $result = false;
        }
        
        return $result;

    }
    ///////////////////////End Token/////////////////////////

    public function email_invoices()
    {
        // Mail::send('emails.quote', ['user' => $user], function ($m) use ($user) {
        //     $m->to($user->email, $user->name)->subject('Your Reminder!');

        //     $m->attach($pathToFile);
        // });
        // $pdf = PDF::loadView('pdf.collage', compact('load'));
        // if ($pdf->save(storage_path('app/loadings/'.$load->id.'/collage.pdf'))) {
        //     return true;
        // } else {
        //     return false;
        // }
        return Redirect::back();
    }

    /////////Invoice page//////////

    /////////Add Invoice/////////////////
    private function ci()
    {
        $company_id = Auth::user()->company_id;
        try{
            $company = Company::find($company_id);
            $clients = $company->clientsWithStatus(1)->get();

            if(!empty($company->CRN) && !empty($company->FYE)) {
                return view('CorpFIN.Invoice.Create_invoice', ['company'=>$company,'clients'=>$clients]);
            }
            else
            {
                return redirect('corpfin/setup');
            }
        }
        catch(\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function Create_invoice()
    {
//        exit;
        if (Auth::check()) {
            $query = $this->ci();
            return $this->is_corpfin_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////End Add invoice/////////////
    ///////////////View invoice////////////////////


    public function View_invoice($id)
    {
        $invoice = Invoice::find($id);
        $products = CorpFinProduct::where('company_id' , Auth::user()->company_id)->get();
        Cart::instance($id)->restore($id);
        
        $content = Cart::instance($id)->content();
        $invoice_items = CorpFinInvoiceItem::where('invoice_id', $id)->where('type', '!=', 'vat')->get();
        $invoice_vat_items = CorpFinInvoiceItem::where('invoice_id', $id)->where('type', 'vat')->get();
        foreach ($invoice_items as $item) {
            if($item->type === 'product')
            {
                $item['item'] = CorpFinProduct::find($item->item_id);
            }
            if($item->type === 'service')
            {
                $item['item'] = CorpFinService::find($item->item_id);
            }
        }
        
        /*DB::table('shoppingcart')->insert([ 'identifier' => $id,
            'instance' => $id,
            'content' => serialize($content)]);*/
        return view('CorpFIN.Invoice.view_invoice', compact('invoice' ,'products', 'invoice_items', 'invoice_vat_items'));
    }
    /**
     * @method view_user_quotes
     *
     */
    public function view_user_quotes($invoice_crypt)
    {
        $invoice_id =  \Crypt::decrypt($invoice_crypt);
        $invoice = Invoice::find($invoice_id);
        $client = CorpFinTranPartner::find($invoice->client_id);
        $company = Auth::user()->company;
        // Cart::instance($id)->restore($id);
        
        // $content = Cart::instance($id)->content();
        $invoice_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->where('type', '!=', 'vat')->get();
        $invoice_vat_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->where('type', 'vat')->get();
        foreach ($invoice_items as $item) {
            if($item->type === 'product')
            {
                $item['item'] = CorpFinProduct::find($item->item_id);
            }
            if($item->type === 'service')
            {
                $item['item'] = CorpFinService::find($item->item_id);
            }
        }
        
        /*DB::table('shoppingcart')->insert([ 'identifier' => $id,
            'instance' => $id,
            'content' => serialize($content)]);*/
        return view('CorpFIN.Invoice.view_client_invoice', compact('invoice', 'client', 'company', 'invoice_items', 'invoice_vat_items'));
    }
    /**
     * @method view_user_quotes
     *
     */
    public function view_accept_user_quotes($invoice_crypt)
    {
        $invoice_id =  \Crypt::decrypt($invoice_crypt);
        $invoice = Invoice::find($invoice_id);

        if($invoice->status == 'draft')
        {
            $split = explode('-', $invoice->invoice_no);
            $split[0] = 'INV';
            $join = implode('-', $split);
            $invoice->invoice_no = $join;
            $invoice->status = "accepted";
            $invoice->save();
            $status_msg = 'Qoute accepted Successfully please proceed to payment';
        }elseif($invoice->status == 'accepted'){
            $status_msg = 'This Qoute has already been accepted please proceed to payment';
        }elseif($invoice->status == 'balance'){
            $status_msg = 'Qoute has been accepted already and part payment has been made, please proceed to pay the balance';
        }elseif($invoice->status == 'paid'){
            $status_msg = 'This Invoice has been fully Paid';
        }
        
        $client = CorpFinTranPartner::find($invoice->client_id);
        $company = Auth::user()->company;
        return view('CorpFIN.Invoice.accept_qoute')->with(['success'=> $status_msg, 'invoice' => $invoice]);
    }

    ///////////////////End View Quotes//////////////

    public function post_invoice(Request $request)
    {
            //    dd($request->all());
             //store new invoice   
            $date = $request->invoice_date;
            $newdate = date('Y-m-d', strtotime($date));
            if($request->type != "invoice"){

            $invoice_no = "QUO" . '-'  . $request->client_id . '-' . date('Y-m-d');   

            }
            else{
                // $invoice->type = "invoice";
            $invoice_no = "INV" . '-'  . $request->client_id . '-' . date('Y-m-d');
               
            }

            $invoice = new Invoice($request->all());
            $invoice->company_id = Auth::user()->company_id;
            $invoice->invoice_date = $newdate;
            
            $invoice->invoice_no = $invoice_no;
            $invoice->save();
            return redirect(url('corpfin/invoice/view', $invoice->id))->with('status', 'success');
       
    }

    /////////////////////////Invoice PDF///////////////////////////

  

    public function view_invoice_pdf($id)
    {
       $invoice = Invoice::find($id);
       Cart::instance($id)->restore($id);
        $content = Cart::instance($id)->content();
        DB::table('shoppingcart')->insert([ 'identifier' => $id,
            'instance' => $id,
            'content' => serialize($content)]);
       $pdf = PDF::loadView('CorpFIN.Invoice.invoice_pdf', ["invoice" =>$invoice ]);
       return $pdf->stream('invoice.pdf');

    }

   public function Invoicegroups(){
    $invoice_groups = InvoiceGroup::where('company_id', Auth::user()->company_id)->paginate(10);
    return view('CorpFIN.Invoice.invoice_group')->with(['invoice_groups' => $invoice_groups]);
   } 

   public function add_Invoicegroup(Request $request){
    $this->validate($request, [
        'name' => 'unique:invoice_groups'
        ]);
        $invoice_grp = new InvoiceGroup($request->all());
        $invoice_grp->save();
        return redirect(url('corpfin/settings/invoice_groups'))->with('status', 'success');
   }

   public function edit_Invoicegroup(Request $request){
   
    $invoice_grp = InvoiceGroup::find($request->id);
    $invoice_grp->name = $request->editname;
    $invoice_grp->save();
    return redirect(url('corpfin/settings/invoice_groups'))->with(['success'=> 'Updated Successfully']);
   }
   public function delete_Invoicegroup($id){
   
    $invoice_grp = InvoiceGroup::where('id',$id)->delete();
    return redirect(url('corpfin/settings/invoice_groups'))->with(['success'=> 'Data Deleted Successfully']);
   }

   public function add_product(){
        $data =Input::all();
       
        foreach ($data as $key => $value) {
            if($key == "product_id"){
                $products = $value;
            }

            elseif ($key == "id") {
                $id = $value;
            }
        }
        foreach ($products  as $key => $value) {
            $product = CorpFinProduct::find($value);
            Cart::instance($id)->add($product);
        }
         
        return $this->store_cart($id);
        
   }

   //remove product from invoice 

   public function remove_product($id){
        
    $invoice_id = request()->invoice_id;
    // Cart::instance($invoice_id)->remove($id);
    CorpFinInvoiceItem::where('id', $id)->where('invoice_id', $invoice_id)->delete();
    return $this->store_cart($invoice_id);
   }

   public function edit_invoice(Request $request, $id){
    //dd($request->all());
    $invoice = Invoice::find($id);
    $invoice->update($request->all());
    $invoice->invoice_date = date('y-m-d', strtotime($request->invoice_date));
    $invoice->due_date = date('y-m-d', strtotime($request->due_date));
    $invoice->date_sent = date('y-m-d', strtotime($request->date_sent));
    $invoice->save();

    return back()->with('status', 'success');



   }

   //edit invoice discount 

   public function edit_invoice_discount(Request $request){
    $this->validate($request, [
        'discount_percent' => 'numeric',
        'discount_amount' => 'numeric'
        ]);
        $invoice =Invoice::find($request->invoice_id);
        $invoice->update($request->all());

        //calculate discount
        $tot = self::get_inv_item_total($request->invoice_id);//str_replace(",", "", Cart::instance($request->invoice_id)->total());
        $total = floatval($tot);
        // $sub = str_replace(",", "", Cart::instance($request->invoice_id)->subtotal());
        $subtotal = $total;

        if(!empty($request->discount_amount)){
            $discount = $total - $request->discount_amount;
            $invoice->subtotal = $subtotal;
            $invoice->total = $discount;
            $invoice->save(); 
        }
        elseif (!empty($request->discount_percent)) {
            //dd($total);
            $discount = ($request->discount_percent /100 ) * $total ;
            //dd($discount);
            $invoice->subtotal = $subtotal;
            $invoice->total = $total - $discount ;
            $invoice->save();
        }

        return $this->store_cart($request->invoice_id);
   }


   public function store_cart($identifier){
         //calculate discount
    
        $invoice = Invoice::find($identifier);
            $tot = self::get_inv_item_total($identifier);//str_replace(",", "", Cart::instance($identifier)->total());
            $sub = self::get_inv_item_subtotal($identifier);//str_replace(",", "", Cart::instance($identifier)->subtotal());
            $total_item_tax = CorpFinInvoiceItemController::get_items_vat_total($identifier);//str_replace(",", "", Cart::instance($identifier)->subtotal());
            $total_inv_item_tax = CorpFinInvoiceItemController::get_inv_item_vat_total($identifier);//str_replace(",", "", Cart::instance($identifier)->subtotal());
            $total = floatval($tot);
            $subtotal = floatval($sub);
            if(!empty($invoice->discount_amount)){
                $discount = $total - $invoice->discount_amount;
                $invoice->total = $discount;
                $invoice->subtotal = $subtotal;
                //$invoice->save(); 
            }
            elseif (!empty($invoice->discount_percent)) {
                
                $discount = ($invoice->discount_percent /100 ) * $total ;
                $invoice->subtotal = $subtotal;
                $invoice->total = $total - $discount ;
                //$invoice->save();
            }
            else{
                $invoice->subtotal = $subtotal;
                $invoice->total = $total;
            }
            $invoice->item_tax = $total_item_tax;
            $invoice->invoice_tax = $total_inv_item_tax + $total_item_tax;
            $invoice->save();

        //store invoice items in database
        $cart = DB::table('shoppingcart')->where('identifier', $identifier)->get();
            if(count($cart) > 0){
              DB::table('shoppingcart')->where('identifier',$identifier)->delete();
        }

        $content = Cart::instance($identifier)->content();
        DB::table('shoppingcart')->insert([ 'identifier' => $identifier,
            'instance' => $identifier,
            'content' => serialize($content)]);

        return redirect(url('/corpfin/invoice/view' , $identifier));
        
   }

   /**
    *@method get_inv_item_total
    *
    */
   public static function get_inv_item_total($invoice_id)
   {
        return $total_item = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->sum('total');
   }
   /**
    *@method get_inv_item_subtotal
    *
    */
   public static function get_inv_item_subtotal($invoice_id)
   {
        return $sub_total = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->sum('sub_total');
   }

   /**
    *@method get_inv_item_vat
    *
    */
   public static function get_inv_product_service_vat($invoice_id)
   {
        return $total_vat = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->sum('vat');
   }
   

   public function add_payment(Request $request){
        //dd($request->all());
      $payment = new Payment($request->all());  
      $payment->payment_date = date('y-m-d', strtotime($request->invoice_date));
      $payment->save();
      $invoice = Invoice::find($request->invoice_id);
      $invoice->paid += $request->amount;
      $invoice->balance = $invoice->total - $invoice->paid;
      $invoice->save();
      if ($request->payment_method == "Cash") {
          # code...
            
        $subacct = SubAccount::find(1);
    $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
    DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Dr' => $request->amount , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            );

      }
      else{
          $subacct = SubAccount::find(4);
    $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
    DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Dr' => $request->amount , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            );
      }
           $subacct = SubAccount::find(6);
    $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
    DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Cr' => $request->amount , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            ); 
      return redirect(url('/corpfin/invoice/view' , $invoice->id));
   }
    //////////////////////End Invoice///////////////////////
   public function convert_quote($id){
    $invoice = Invoice::find($id);
    $invoice->type = "invoice";
    $invoice_no = str_replace("QUO", "INV", $invoice->invoice_no);         
    $invoice->invoice_no = $invoice_no;
    $invoice->save();

     //add entries
    $subacct = SubAccount::find(6);
    $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
    DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Dr' => $invoice->total , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            ); 
     $subacct = SubAccount::find(79);
     $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
    DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Cr' => $invoice->total , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            ); 

        if (!empty($invoice->invoice_tax)) {
           $subacct = SubAccount::find(64);
             $description = $subacct->acct_name . "(". CorpFinTranPartner::find($invoice->client_id)->name . ")";
            DB::table('corpfin_generalledger')->insert(
                ['account_id' => $subacct->account_id, 'acc_name' => Account::find($subacct->account_id)->acct_name, 'date' => date('Y-m-d') , 'Cr' => $invoice->invoice_tax , 'account_no' => $subacct->sub_account_no , 'company_id' => Auth::user()->company_id,  'description' => $description, 'class_id' => $subacct->account_class_id, 'subclass_id' => $subacct->acct_subclass_id]
            ); 
        }
       return back();

   }

    public function send_quote($id){
       $invoice = Invoice::find($id);
       $client = CorpFinTranPartner::find($invoice->client_id);
       $client->notify(new SaleInvoice($id));
       return back();
    }

    public function view_invoices(){
        $invoices = Invoice::where('type' , 'invoice')->orderBy('created_at', 'desc')->paginate(10);
        return view('CorpFIN.Invoice.view_invoices')->with(['invoices' => $invoices]);
    }
    // send_invoices
    public static function send_invoice(int $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $client = CorpFinTranPartner::find($invoice->client_id);
        $invoice_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->where('type', '!=', 'vat')->get();
        $invoice_vat_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->where('type', 'vat')->get();
        foreach ($invoice_items as $item) {
            if($item->type === 'product')
            {
                $inv_item = CorpFinProduct::find($item->item_id);
                $item['name'] = $inv_item->name;
                $item['price'] = $inv_item->price;
            }
            if($item->type === 'service')
            {
                $inv_item = CorpFinService::find($item->item_id);
                $item['name'] = $inv_item->name;
                $item['price'] = $inv_item->price;
            }
            //return $item;
        }
        // return $invoice_items;
        $email_job = (new QouteJob($invoice, $client, Auth::user()->company, $invoice_items, $invoice_vat_items))->delay(Carbon::now()->addSeconds(3));
        dispatch($email_job);
        return redirect()->back()->with('success', 'Quoute has been mailed to this client');

    }
}
