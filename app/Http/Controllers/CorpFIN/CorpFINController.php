<?php

namespace App\Http\Controllers\CorpFIN;

use App\Company;
use App\CorpFinProduct;
use App\CorpfinWhttype;
use App\Country;
use App\SubAccount;
use App\Models\CorpFIN\FixedAssetRegister;

use App\Http\Controllers\Controller;
use App\State;
use App\Vat;
use App\Wht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use App\Models\CorpFIN;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;
use PDF, Excel;
use App\Models\CorpFIN\Markup;
use App\Exports\LedgerExport;

class CorpFINController extends Controller
{
    use SubscriptionTrait;

    ///////setup page////////////////
    private function set()
    {
        $company = Auth::user()->company;

        if (empty($company->FYE)) {
            $timezones = $this->tz_list();
            $country = Country::where('id', $company->country)->get();

            $states = State::where('country_id', $company->country)->get();

            return view('CorpFIN.panel.Setup2', ['states' => $states, 'timezones' => $timezones, 'deliverable_type' => $company->deliverable_type, 'company_id' => $company->id, 'currency' => $country]);
        } else {
            return Redirect::intended('corpfin/dashboard');
        }
    }

    public function setup()
    {
        if (Auth::check()) {

            $query = $this->set();

            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    /////////End Setup Page//////////


    /////////Dashoard page//////////
    private function D()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);


        if (!empty($company->CRN) && !empty($company->FYE)) {
            $sellable = $company->deliverable_type;

            $count_tp = $company->customers->count();
            $count_tt = DB::table('corpfin_ttype_custom')->where(['company_id' => $company_id])->count();
            $count_product = DB::table('corpfin_deliverables')->where(['company_id' => $company_id, 'category' => "Product"])->count();
            $count_service = DB::table('corpfin_deliverables')->where(['company_id' => $company_id, 'category' => "Services"])->count();
            $counter = [
                'tp' => $count_tp,
                'product' => $count_product,
                'services' => $count_service,
                'tt' => $count_tt
            ];

            return view('CorpFIN.panel.Dashboard', ['company' => $company, 'counter' => $counter]);
        } else {
            return redirect('corpfin/setup');
        }

    }

    public function Dashboard()
    {
        //Todo: add Auth middleware
        $query = $this->D();

        return $this->is_corpfin_user_set($query);

    }
    //////End Dashboard Page///////

    /////////Add Product page//////////
    private function A_P()
    {
        $company = Auth::user()->company;
        if (!empty($company->CRN) && !empty($company->FYE)) {
            $country = $company->country;

            $currency = Country::where('name', $country)->get();
//            $WHTtype = CorpfinWhttype::all();
            return view('CorpFIN.panel.Add_product', ['currency' => $currency, 'company' => $company]);
        } else {
            return redirect('corpfin.setup');
        }
    }

    public function add_product_form()
    {
        if (Auth::check()) {
            $query = $this->A_P();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }

    public function updateProduct(Request $request)
    {
        //Todo: manage validation
        try {
            $corpProduct = CorpFinProduct::find($request->get('id'));
            $corpProduct->update($request->all());
        } catch (\Exception $e) {
            \Session::flash('error', 'Product update failed');
            return redirect()->back();
        }

        \Session::flash('success', 'Product update successful');
        return redirect()->back();
    }

    public function post_newproduct(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make(
                Input::all(),
                [
                    'name' => 'required',
                    'measure' => 'required',
                    'rp' => 'required',
                ],
                [
                    'name.required' => 'Product name is Required',
                    'measure.required' => 'measure is required',
                    'RP.required' => 'Rate / Price is required',
                ]
            );
            if ($validator->fails()) {
                $messages = response($validator->messages());
                return response(['result' => 'val_fail', 'error' => $messages]);
            } else {

                $input = $request->all();
                $input['rp'] = $request->get('rp');
                $input['company_id'] = Auth::user()->company_id;

//                dd($input);
                try {
                    CorpFinProduct::create($input);
//                    DB::table('corpfin_deliverables')->insert($data);
                } catch (\Exception $e) {
                    return response(['result' => 'fail'], 400);
                }
//                $query = DB::table('corpfin_deliverables')->insert($data);

                return response(['result' => 'success']);
            }
        }


        return response(['result' => 'login']);
    }

    ///////////End Add Product///////////

    ///////////function compute VAT///////

    public function compute_VAT($type, $sub_type, $price)
    {
        if ($type == "VAT") {
            $VAT = 0.05;
            if ($sub_type == "Inclusive") {
                $recievable = $price;
                $sales = $price - $VAT;
                $vatpay = $VAT;
            } elseif ($sub_type == "Exclusive") {
                $recievable = $price + $VAT;
                $sales = $price;
                $vatpay = $VAT;
            }
        }
        // elseif($type=="WHT"){

        // }
        // elseif(){

        // }

    }

    ///////////end compute VAT function/////

    /////////Add Services page//////////
    private function A_S()
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $country = $y->country;
                $currency = DB::select(DB::raw("SELECT `p_currency`,`s_currency` FROM countries where name = '$country' "));
                $WHTtype = DB::select(DB::raw("SELECT * FROM  corpfin_whttype"));
                return view('CorpFIN.panel.Add_services', ['currency' => $currency, 'WHTtypes' => $WHTtype, 'company_id' => $company_id, 'deliverable_type' => $sellable]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function Add_service()
    {
        if (Auth::check()) {
            $query = $this->A_S();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    //////End Add Service Page///////

    /////////////view service////////////
    private function view_se()
    {
        $company_id = Auth::user()->company_id;
        $services = DB::select(DB::raw("SELECT * FROM corpfin_deliverables WHERE  company_id = '$company_id' AND deleted = '0' AND category = 'Services' "));
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                return view('CorpFIN.panel.view_service', ['deliverable_type' => $sellable, 'services' => $services]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function View_service()
    {
        if (Auth::check()) {
            $query = $this->view_se();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    ////////////end view service//////////////

    /////////////view product////////////
    private function view_pt()
    {
        $company = Auth::user()->company;

        $corpFinProducts = $company->corpFinProducts->where('category', 'Product');

        if (!empty($company->CRN) && !empty($company->FYE)) {
            return view('CorpFIN.panel.view_product', ['company' => $company, 'corpFinProducts' => $corpFinProducts]);
        } else {
            return Redirect::intended('corpfin.setup');
        }
    }

    public function view_product()
    {
        if (Auth::check()) {
            $query = $this->view_pt();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    ////////////end view service//////////////

    //////////Get TT List///////////
    public function list_tt($fs_id, $at_id)
    {
        if ($fs_id == 3 || $fs_id == 4 || $fs_id == 2) {
            $fetch = DB::select(DB::raw("SELECT * FROM corpfin_ttlists WHERE  fs_category_id = '$fs_id' AND asset_type_id = '0' "));
            return Response::json($fetch);
        } else {
            $fetch = DB::select(DB::raw("SELECT * FROM corpfin_ttlists WHERE  fs_category_id = '$fs_id' AND asset_type_id = '$at_id' "));
            return Response::json($fetch);
        }
    }
    ////////////End TT List/////////////

    //////////Get WT List from Corpfin_WHTtype table///////////
    public function list_wt(Request $request)
    {
        try {
            $fetch = Wht::findOrFail($request->get('id'));
        } catch (\Exception $e) {
            $e->getMessage();
            return response(['error' => "WHT not found"], 400);
        }
        return response($fetch);
    }
    ////////////End WT List/////////////


    ////process corpfin company setup form///
    public function setup2(Request $request)
    {

        $validator = Validator::make(
            Input::all(),
            [
                'industry_type' => 'required',
                'business_type' => 'required',
                'TZ' => 'required',
                'inventory' => 'required',
            ],
            ['business_type.required' => 'Business Type Is Required',
                'industry_type.required' => 'Industry Type Is Required',
                'TZ.required' => 'Timezone Is Required',
                'inventory.required' => 'Inventory Type is required',
            ]
        );
        if ($validator->fails()) {
            //         $messages = json_encode($validator->messages());
            // return redirect()->back()
            //                 ->with('message',$messages)
            //                 ->with('status', 'danger')
            //                 ->withInput();
            return json_encode(['result' => 'val_fail']);
        } else {
            $branches = implode(',', $request->input('branches'));

            //     if(!empty($request->input('product_price'))){
            // $products = implode(',',$request->input('products'));
            // $product_price = implode(',',$request->input('product_price'));
            //     }
            //     else{
            //      $products= "";
            //      $product_price= "";
            //     }
            //     if(!empty($request->input('service_price'))){
            // $services = implode(',',$request->input('services'));
            // $service_price = implode(',',$request->input('service_price'));
            //     }else{
            // $service_price = "";
            // $services= "";
            //     }
            $data = array(
                'industry_type' => $request->input('industry_type'),
                'business_type' => $request->input('business_type'),
                'FYE' => "" . $request->input('FYE1') . "_" . $request->input('FYE2') . "",
                'TJ' => $request->input('TJ'),
                'TZ' => $request->input('TZ'),
                'FC' => "" . $request->input('FC1') . "." . $request->input('FC2') . "",
                'branches' => $branches,
                'inventory' => $request->input('inventory'),
                'deliverable_type' => $request->input('FD'),
                // 'products' => $products,
                // 'product_price'=>$product_price,
                // 'services' =>$services,
                // 'service_price' => $service_price,
            );

            //$query = DB::table('company')->insert($data);
            //$company_id = DB::table('company')->insertGetId($data); 
            //$user_id = Auth::user()->id;
            $company_id = $request->input('c_id');
            $where = array('id' => $company_id,);
            //$data = array('company_id' =>$company_id,);
            $query = DB::table('company')->where($where)->update($data);
            if ($query) {

                return json_encode(['result' => 'success']);
            } else {
                return json_encode(['result' => 'fail']);
            }
            //return Redirect::intended('corpfin/dashboard'); 
        }

    }
    ////////end corpfin company form/////////

    ////Get all time zones////
    function tz_list()
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }
    //////end get all time zones////////

    /////change menu view//////
    public function change_view($view)
    {

        $user = Auth::user();
        $user->corpfin_menutype = $view;
        $user->save();
            
        return redirect()->back();
        // $user_id = Auth::user()->id;
        // $where = array('id' => $user_id,);
        // $data = array('corpfin_menutype' => $view,);
        // $query = DB::table('users')->where($where)->update($data);
        // if ($query) {
        //     return redirect()->back();
        // } else {
        //     return redirect()->back();
        // }
    }
    ////////end change menu view/////////


    /////////////////////Transaction Types////////////////////////////////

    ////Add Transaction type////
    private function A_tt()
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $country_id = $y->country;
                $sellable = $y->deliverable_type;
                $currency = DB::select(DB::raw("SELECT `p_currency`,`s_currency` FROM countries where id = '$country_id' "));
                $WHTtype = DB::select(DB::raw("SELECT * FROM  corpfin_whttype"));
                return view('CorpFIN.panel.add_tt', ['deliverable_type' => $sellable, 'company_id' => $company_id]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function Add_tt()
    {
        if (Auth::check()) {
            $query = $this->A_tt();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }

    public function post_tt(Request $request)
    {
        //dd($request->all());
      

        if ($request->input('type') == "Assets" || $request->input('type') == "Liabilities") {
            $maincat = $request->input('main_cat');
        } else {
            $maincat = $request->input('main_cat1');
        }
        if ($request->input('type') == "Assets") {
            $row_name = "asset_" . $request->input('acc_cat') . "";
        } elseif ($request->input('type') == "Equity") {
            $row_name = "equity_" . $request->input('acc_cat') . "";
        } elseif ($request->input('type') == "Expenses") {
            $row_name = "expenses_" . $request->input('acc_cat') . "";
        } elseif ($request->input('type') == "Income") {
            $row_name = "income_" . $request->input('acc_cat') . "";
        } elseif ($request->input('type') == "Liabilities") {
            $row_name = "liability_" . $request->input('acc_cat') . "";
        }
        $data = array(
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'main_cat' => $maincat,
            'sub_cat' => $request->input('sub_cat'),
            'acc_name' => $request->input('acc_name'),
            'acc_num' => $request->input('acc_num')
        );

        $ttype = array(
            'company_id' => Auth::user()->company_id,
            'name' => $request->input('TTN'),
            'code' => $request->input('tcode'),
            'sub_cat' => $request->input('sub_cat'),
            'acct_num' => $request->input('acc_num'),
            '' . $row_name . '' => "1",
        );
        $ttype_id = DB::table('corpfin_ttype_custom')->insertGetId($ttype);
        $chartofaccount_id = DB::table('Corpfin_chartofaccount_custom')->insertGetId($data);
        if ($chartofaccount_id) {
            if ($ttype_id) {
                return json_encode(['result' => 'success']);
            } else {
                return json_encode(['result' => 'fail']);
            }
        } else {
            return json_encode(['result' => 'fail']);
        }

        

    }
    /////End Add Transaction Type/////

    ////View Transaction type////
    private function v_tt()
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $country_id = $y->country;
                $sellable = $y->deliverable_type;
                $currency = DB::select(DB::raw("SELECT `p_currency`,`s_currency` FROM countries where id = '$country_id' "));
                $WHTtype = DB::select(DB::raw("SELECT * FROM  corpfin_whttype"));
                $tts = DB::select(DB::raw("SELECT * FROM  Add_tt where company_id = '$company_id' "));
                return view('CorpFIN.panel.view_tt', ['deliverable_type' => $sellable, 'tts' => $tts]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function View_tt()
    {
        if (Auth::check()) {
            $query = $this->v_tt();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    /////End View Transaction Type/////

    //////////////////////////End Transaction Types/////////////////////////////////


    /////////////////////Transaction Partners////////////////////////////////

    ////Add Transaction partners////
    private function a_tps()
    {
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $countries = DB::select(DB::raw("SELECT `id`,`name`,`sortname` FROM countries"));
                return view('CorpFIN.panel.add_tp', ['deliverable_type' => $sellable, 'countries' => $countries, 'company_id' => $company_id]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function Add_tp()
    {
        if (Auth::check()) {
            $query = $this->a_tps();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    /////End Add Transaction Partners/////

    //////////////Post Transaction Partners/////////////////
    public function post_tp(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make(
                Input::all(),
                [
                    'name' => 'required|unique:corpfin_customers',
                    'email' => 'required|unique:corpfin_customers',
                    'cin' => 'required|unique:corpfin_customers',
                ],
                [
                    'email.unique' => 'Email Address Already Registered',
                    'name.required' => 'Individual / Incorporation name is Required',
                    'cin.required' => 'Company Incorporation number is required',
                    'cin.unique' => 'Company Incorporation number Already Exist',
                    'name.unique' => 'Individual / Incorporation name Already Exist',
                ]
            );
            if ($validator->fails()) {
                $messages = json_encode($validator->messages());
                // return redirect()->back()
                //                 ->with('message',$messages)
                //                 ->with('status', 'danger')
                //                 ->withInput();
                return json_encode(['result' => 'val_fail', 'error' => $messages]);
            } else {
                if (!empty($request->file('document'))) {
                    $file = $request->file('document');
                    $name = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $destinationPath = 'uploads/documents';
                    $file->move($destinationPath, $file->getClientOriginalName());
                    $document_url = "/" . $destinationPath . "" . $name . "" . $extension . "";
                } else {
                    $document_url = "";
                }
                $data = array(
                    'company_id' => $request->input('company_id'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'country' => $request->input('country'),
                    'state' => $request->input('state'),
                    'tin' => $request->input('tin'),
                    'document_url' => $document_url,
                    'cin' => $request->input('cin'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'status' => '1'
                );

                //$query = DB::table('company')->insert($data);
                $customer_id = DB::table('corpfin_customers')->insertGetId($data);
                if ($customer_id) {

                    return json_encode(['result' => 'success']);

                } else {

                    return json_encode(['result' => 'fail']);

                }
            }
        } else {
            return json_encode(['result' => 'login']);
        }
    }

    ///////////////End Post Transaction Partners////////////

    public function deleteWht(Request $request)
    {
        if (Auth::check()) {
            try {
                $wht = Wht::findOrFail($request->get('id'));
                $wht->delete();
                return response(['result' => 'success']);
            } catch (\Exception $e) {
                return response(['result' => 'fail'], 400);
            }
        } else {
            return response(['result' => 'login']);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $product = CorpFinProduct::find($request->get('id'));
            $product->delete();
        } catch (\Exception $e) {
            return json_encode(['result' => 'fail']);
        }

        return response(['result' => 'success']);
    }

    public function deleteVat(Request $request)
    {
        if (Auth::check()) {
            $company = Auth::user()->company;

            ///////////delete transaction Partner///////////
            try {
                $vat = Vat::findOrFail($request->get('id'));
                $vat->delete();
                return response(['result' => 'success']);
            } catch (\Exception $e) {
                return response(['result' => 'fail'], 400);
            }

//            if($page=="tp") {
//                $where = array('company_id' =>$company->id,'id' =>$id);
//                $data = array(
//                'status' => 0,
//                );
//                $query = DB::table('corpfin_customers')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            //////////End Transaction Partner delete/////////

            ///////////delete transaction type///////////
//            if($page=="tt") {
//                $where = array('company_id' =>$company_id,'id' =>$id);
//                $query = DB::table('corpfin_ttype_custom')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            //////////End Transaction Type delete/////////

            //////////////product & serices//////////////////////
//            if($page=="ps") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                $data = array(
//                'deleted' => 1,
//                );
//                $query = DB::table('corpfin_deliverables')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end product & services///////////////

            //////////////quotes//////////////////////
//            if($page=="quote") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                DB::table('corpfin_quote_deliverables')->where(['quote_id'=>$id])->delete();
//                $query = DB::table('corpfin_quotes')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end quotes///////////////

            //////////////invoices//////////////////////
//            if($page=="inv") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                DB::table('corpfin_invoice_deliverables')->where(['invoice_id'=>$id])->delete();
//                $query = DB::table('corpfin_invoice')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end invoices///////////////

            //////////////invoice group//////////////////////
//            if($page=="invoice_group") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                $query = DB::table('corpfin_invoice_groups')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end invoice group///////////////

            //////////////tax rate//////////////////////
//            if($page=="tax_rate") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                $query = DB::table('corpfin_taxrate')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end tax rate///////////////

            //////////////payment method//////////////////////
//            if($page=="payment_method") {
//                $where = array(
//                'company_id' =>$company_id,
//                'id' =>$id);
//                $query = DB::table('corpfin_paymentmethod')->where($where)->delete();
//                if($query) {
//                    return json_encode([ 'result' => 'success' ]);
//                }else{
//                    return json_encode([ 'result' => 'fail' ]);
//                }
//            }
            ////////////////end payment method///////////////
            /////////////////////////inv tax//////////////////////////
//            if($page=="invtax") {
//                $data = [
//                'invoice_taxrate' => 0,
//                'invoice_taxplacement' => "",
//                ];
//                $query = DB::table('corpfin_invoice')->where(['id'=>$id,'company_id'=>$company_id])->update($data);
//                if($query) {
//                    return Redirect::back();
//                }else{
//                    return Redirect::back();
//                }
//            }
            ////////////////////////inv tax///////////////////////////
        } else {
            return response(['result' => 'login']);
        }
    }


    public function getWht(Request $request)
    {
        try {
            $wht = Wht::findorFail($request->get('id'));
            return response($wht);
        } catch (\Exception $e) {
            return response([], 400);
        }
    }


    public function getVat(Request $request)
    {
        try {
            $vat = Vat::findorFail($request->get('id'));
            return response($vat);
        } catch (\Exception $e) {
            return response([], 400);
        }


        exit;
        $company_id = Auth::user()->company_id;
        if ($page == "tp") {
            $data = DB::table('corpfin_customers')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        if ($page == "deliverable") {
            $data = DB::table('corpfin_deliverables')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        // if($page == "quote")
        // {
        //    $data = DB::table('corpfin_quotes')->where(['id' => $id, 'company_id' => $company_id])->first(); 
        //    echo json_encode($data);
        // }
        if ($page == "inv") {
            $data = DB::table('corpfin_invoice')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        if ($page == "invoice_group") {
            $data = DB::table('corpfin_invoice_groups')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        if ($page == "tax_rate") {
            $data = DB::table('corpfin_taxrate')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        if ($page == "payment_method") {
            $data = DB::table('corpfin_paymentmethod')->where(['id' => $id, 'company_id' => $company_id])->first();
            echo json_encode($data);
        }
        if ($page == "inv_payment") {
            $data = DB::select(DB::raw("SELECT * FROM corpfin_invoice_deliverables WHERE  invoice_id = '$id'"));
            $payments = DB::select(DB::raw("SELECT * FROM corpfin_invoice_payment WHERE  invoice_id = '$id'"));
            //  DB::table('corpfin_invoice_deliverables')->where(['invoice_id' => $id]);
            $i = 0;
            $j = 0;
            $k = 0;
            foreach ($data as $key => $d) {
                $i = $i + ($d->price * $d->quantity) - $d->discount;
            }
            foreach ($payments as $key => $p) {
                $j = $j + $p->amount;
            }
            //return $i;
            $k = $i - $j;
            $result = [
                'amount' => $k,
                'payments' => $payments
            ];
            echo json_encode($result);
        }
        // if($page == "inv_products")
        // {
        // //$product_id = $request->input('product_ids');
        // $data = DB::table('corpfin_deliverables')->where(['id' => $id, 'company_id' => $company_id])->first(); 
        // echo json_encode($data);
        // }
    }

    public function get_inv_products(Request $request)
    {
        $product_ids = $request->input('product_ids');
        $company_id = Auth::user()->company_id;
        $data = array();
        foreach ($product_ids as $product_id) {
            $data[] = DB::table('corpfin_deliverables')->where(['id' => $product_id, 'company_id' => $company_id])->first();
        }
        echo json_encode($data);
    }

    public function edit(Request $request, $page)
    {
        $id = $request->input('id');
        $company_id = Auth::user()->company_id;
        if ($page == "deliverable") {
            $data = array(
                'name' => $request->input('name'),
                'measure' => $request->input('measure'),
                'RP' => $request->input('RP'),
                'price' => $request->input('price')
            );
            $update = DB::table('corpfin_deliverables')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
        if ($page == "tp") {
            $data = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            );
            $update = DB::table('corpfin_customers')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
        //   if($page == "quote")
        //  {
        //     $data = array(
        // 'client_name' => $request->input('name'),
        // 'invoice_date' => $request->input('qdate'),
        // 'date_due' => $request->input('date_due'),
        // 'invoice_group' =>$request->input('group'),
        // 'status' => $request->input('status'),
        //     );
        //     $update = DB::table('corpfin_invoice')->where(['id'=>$id,'company_id'=>$company_id])->update($data);
        // $product_ids = $request->input('product_ids');
        // foreach ($product_ids as $key => $product_id) {
        // $query = [
        // 'invoice_id' => $id,
        // 'item' =>  $request->input(''.$product_id.'_product_name'),
        // 'quantity' => $request->input(''.$product_id.'_product_quantity'),
        // 'price' =>  $request->input(''.$product_id.'_product_price'),
        // ];
        // $insert = DB::table('corpfin_invoice_deliverables')->insert($query);
        // }
        //     return Redirect::back();
        //  } 
        if ($page == "inv") {
            $data = array(
                'client_name' => $request->input('client'),
                'invoice_date' => $request->input('invoice_date'),
                'date_due' => $request->input('date_due'),
                'invoice_password' => $request->input('invoice_password'),
                'discount' => $request->input('inv_discount'),
                'invoice_group' => $request->input('group'),
                'date_created' => date('Y-m-d'),
                'status' => $request->input('status'),
            );
            $update = DB::table('corpfin_invoice')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            $product_ids = $request->input('product_id');
            $dd_id = $request->input('dd_id');
            $product_name = $request->input('product_name');
            $product_quantity = $request->input('product_quantity');
            $product_price = $request->input('product_price');
            $product_discount = $request->input('product_discount');
            //$product_tax = $request->input('product_tax');
            $product_description = $request->input('product_description');
            $i = 0;
            foreach ($product_ids as $key => $product_id) {
                $query = [
                    'invoice_id' => $id,
                    'item' => $product_name[$i],
                    'quantity' => $product_quantity[$i],
                    'price' => $product_price[$i],
                    'discount' => $product_discount[$i],
                    //'tax_rate' => $product_tax[$i],
                    'description' => $product_description[$i]
                ];
                $x = DB::table('corpfin_invoice_deliverables')->where(['id' => $dd_id[$i]])->first();
                if ($x) {
                    $update = DB::table('corpfin_invoice_deliverables')->where(['id' => $dd_id[$i]])->update($query);
                } else {
                    $insert = DB::table('corpfin_invoice_deliverables')->insert($query);
                }
                $i = $i + 1;
            }
            return Redirect::back();
        }
        if ($page = "inv_tax") {
            $data = array(
                'invoice_taxrate' => $request->input('invoice_taxrate'),
                'invoice_taxplacement' => $request->input('invoice_taxplacement')
            );
            $update = DB::table('corpfin_invoice')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
        if ($page == "inv_payment") {
            $data = array(
                'invoice_id' => $id,
                'amount' => $request->input('amount_paid'),
                'date' => $request->input('pdate'),
                'method' => $request->input('pmethod'),
                'note' => $request->input('pnote'),
            );
            $insert = DB::table('corpfin_invoice_payment')->insert($data);
            $update = DB::table('corpfin_invoice')->where(['id' => $id, 'company_id' => $company_id])->update(['status' => "Paid"]);
            return Redirect::back();
        }
    }

    ////View Transaction Partners////
    private function view_tps()
    {
        $company_id = Auth::user()->company_id;
        $partners = DB::select(DB::raw("SELECT * FROM corpfin_customers WHERE  company_id = '$company_id' AND status = '1'"));
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                return view('CorpFIN.panel.view_tp', ['deliverable_type' => $sellable, 'partners' => $partners]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    public function View_tp()
    {
        if (Auth::check()) {
            $query = $this->view_tps();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
    /////End View Transaction partners/////

    //////////////////////////End Transaction partners/////////////////////////////////

    ///////////////////////////Enteries///////////////////////////////////////////

    //////////////////Add Enteries///////////////////////////
    public function add_entries()
    {

        $company = Auth::user()->company;

            if (!empty($company->CRN) && !empty($company->FYE)) {
//                $type = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
                $sellable = $company->deliverable_type;
                $clients = $company->transPartners()->get();


                $T_types = DB::table('corpfin_ttype_generic')->select(
                    array(DB::raw(
                        'GROUP_CONCAT(DISTINCT name) as   name,
        GROUP_CONCAT(DISTINCT category) AS category,
        GROUP_CONCAT(DISTINCT id) AS id'
                    )
                    )
                )->groupBy('sub_id')->where(['code' => 'INV'])->get();

                return view('CorpFIN.panel.add_entry', [ 'company' => $company, 'products' => $company, 'deliverable_type' => $sellable, 'types' => $company, 'T_types' => $T_types, 'clients' => $clients]);
            }

    }
    //////////////////////End add enteries//////////////////////

    ///////////////////View Enteries//////////////////////////

    public function view_entries()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $fetch = DB::select(DB::raw("SELECT * FROM users WHERE  id = '$user_id' "));
            foreach ($fetch as $key => $query) {
                $company_id = $query->company_id;
                $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
                if ($x) {
                    foreach ($x as $key => $y) {
                        if (!empty($y->CRN) && !empty($y->FYE)) {
                            $sellable = $y->deliverable_type;
                            return view('CorpFIN.panel.view_entry', ['deliverable_type' => $sellable]);
                        } else {
                            return Redirect::intended('corpfin/setup');
                        }
                    }
                } else {
                    return Redirect::intended('corpfin/setup');
                }
            }
            return Redirect::intended('corpfin/setup');
        } else {
            //return view('auth.login');
            return Redirect::intended('login');
        }

    }

    ////////////////////End view Entries//////////////////////

    /////////////////////////////End Entries/////////////////////////////////////

    ////////////////////////Get TTN///////////////////////////////////////////
    public function get_ttn($id)
    {

        //return transaction types that correspond to the selected id

        $ttypes = DB::table('trans_types')->where('trans_cat_id', $id)->get();
        return response::json($ttypes);


    }
    ////////////////////////End Get TTN///////////////////////////////////////


    ////////////////////////Get Deliverable/////////////////////////////////
    public function getProducts(Request $request)
    {
        $company = Auth::user()->company;
        $result = $company->corpFinProducts->find($request->get('id'));
        return response($result);

    }

    public function list_product_details($id)
    {
        $company_id = Auth::user()->company_id;
        $fetch = DB::select(DB::raw("SELECT * FROM corpfin_deliverables WHERE  company_id = '$company_id' AND id = '$id' "));
        return Response::json($fetch);
    }
    ////////////////////////End Get Deliverable/////////////////////////////

    //////////////////////////Entry Calendar///////////////////////////////////
    //Todo: not reviewed

    public function calendar_event_post($type, $title, $id)
    {

        if ($type == 'changetitle') {
            $where = array(
                'id' => $id,
            );
            $data = array(
                'title' => $title,
            );
            $update = DB::table('calendar')->where($where)->update($data);
            //mysqli_query($con,"UPDATE calendar SET title='$title' where id='$eventid'");
            if ($update) {
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'failed'));
            }
        }


    }

    //Todo: not reviewed
    public function calendar_event_get($type)
    {
        $user_id = Auth::user()->id;
        if ($type == 'fetch') {
            $events = array();
            // $query = mysqli_query($con, "SELECT * FROM calendar");
            $fetch = DB::select(DB::raw("SELECT * FROM calendar WHERE  user_id = '$user_id' "));
            //$fetch = DB::table('calendar')->where('user_id', '=', '$user_id')->get();
            foreach ($fetch as $result) {
                $e = array();
                $e['id'] = $result->id;
                $e['title'] = $result->title;
                $e['colorcode'] = $result->colorcode;
                $e['start'] = $result->startdate;
                $e['end'] = $result->enddate;
                $allday = ($result->allDay == "true") ? true : false;
                $e['allDay'] = $allday;

                array_push($events, $e);
            }
            echo json_encode($events);
        }

    }


    //////////////////////////////END Entry Calendar///////////////////////////

   

    

    ////////////////////////// virtual tables/////////////////////////////////

    /////Equity table/////

    public function Equity_table()
    {

        CorpFIN::retrieve_fxn1();

    }

    ////End Equity table////

    /////Liabilities table////

    public function liabilities_table()
    {

    }

    ////End Liabilities table/////

    /////////Assets table///////

    public function assets_table()
    {

    }

    /////End Assets table/////

    //////Sales Table//////

    public function sales_table()
    {

    }

    ////End Sales table/////

    //////purchases table/////

    public function purchases_table()
    {

    }

    //////End Purchases table////

    ///////Inventory table//////

    public function inventory_table()
    {

    }

    ///////End Inventory table/////////

    //////Ownings table///////

    public function ownings_table()
    {

    }


    ///////End Ownings table///////

    /////Owings table//////

    public function owings_table()
    {

    }

    /////End Owings table//////

    //////////////////End virtual tables////////////////

    ////////////////////////////////SETTINGS///////////////////////////////////////
    private function ig()
    {
        $company_id = Auth::user()->company_id;
        $company = Auth::user()->company;
        foreach ($company as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $countries = Country::all();
                $igs = DB::select(DB::raw("SELECT * FROM corpfin_invoice_groups WHERE  company_id = '$company_id' "));
                return view('CorpFIN.Settings.Invoice_groups', ['deliverable_type' => $sellable, 'igs' => $igs, 'countries' => $countries, 'company_id' => $company_id]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    //Todo: not reviewed
    public function Invoicegroups()
    {
        if (Auth::check()) {
//            $query = $this->a_ig();
            return $this->is_corpfin_user_set("");
        } else {
            return Redirect::intended('login');
        }
    }

    private function tax_rate_vat()
    {
        $company = Auth::user()->company;
        if (!empty($company->CRN) && !empty($company->FYE)) {
            return view('CorpFIN.Settings.Tax_rate', ['company' => $company]);
        } else {
            return redirect('corpfin.setup');
        }
    }

    private function tax_rate_wht()
    {
        $company = Auth::user()->company;
        if (!empty($company->CRN) && !empty($company->FYE)) {
            return view('CorpFIN.Settings.Tax_rate_wht', ['company' => $company]);
        } else {
            return redirect('corpfin.setup');
        }
    }

    public function vatrates()
    {
        $query = $this->tax_rate_vat();
        return $this->is_corpfin_user_set($query);
    }

    public function whtrates()
    {
        $query = $this->tax_rate_wht();
        return $this->is_corpfin_user_set($query);
    }

    private function pm()
    {
        $company_id = Auth::user()->company_id;
        $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
        foreach ($x as $key => $y) {
            if (!empty($y->CRN) && !empty($y->FYE)) {
                $sellable = $y->deliverable_type;
                $countries = DB::select(DB::raw("SELECT `id`,`name`,`sortname` FROM countries"));
                $trs = DB::select(DB::raw("SELECT * FROM corpfin_paymentmethod WHERE  company_id = '$company_id' "));
                return view('CorpFIN.Settings.Payment_method', ['deliverable_type' => $sellable, 'trs' => $trs, 'countries' => $countries, 'company_id' => $company_id]);
            } else {
                return Redirect::intended('corpfin/setup');
            }
        }
    }

    //Todo: not reviewed
    public function paymentmethod()
    {
        if (Auth::check()) {
            $query = $this->pm();
            return $this->is_corpfin_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }

    public function addVatrates(Request $request)
    {
        $data = [
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate')
        ];

        try {
            Vat::create($data);
        } catch (\Exception $e) {
            Session::flash("error", "Integrity constraint violation");
//            dd($e->getMessage());
        }

        Session::flash("success", "Vat rate successfully added");
        return redirect()->back();
    }

    public function addWHtrates(Request $request)
    {
        $data = [
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate')
        ];

        try {
            Wht::create($data);
            Session::flash("success", "WHT added successfully");
        } catch (\Exception $e) {
            Session::flash("error", "WHT update Failed");
        }

        return redirect()->back();
    }

    public function settings_add(Request $request, $page)
    {
        $company_id = Auth::user()->company_id;
        if ($page == "invoice_group") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'identifier_year' => $request->input('identifier_year'),
                'identifier_month' => $request->input('identifier_month'),
                'identifier_day' => $request->input('identifier_day'),
                'next_id' => $request->input('next_id'),
                'left_pad' => $request->input('left_pad'),
                'date' => date('Y-m-d')
            );

            $query = DB::table('corpfin_invoice_groups')->insert($data);
            return Redirect::back();
        }
        if ($page == "tax_rate") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'rate' => $request->input('rate'),
                'date' => date('Y-m-d')
            );

            $query = DB::table('corpfin_taxrate')->insert($data);
            return Redirect::back();
        }
        if ($page == "payment_method") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'date' => date('Y-m-d')
            );

            $query = DB::table('corpfin_paymentmethod')->insert($data);
            return Redirect::back();
        }
    }

    public function updateWht(Request $request)
    {
        $data = array(
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate'),
        );

        try {
            $vat = Wht::find($request->get('id'));
            $vat->update($data);
            Session::flash("success", "at updated successfully");
        } catch (\Exception $e) {
            Session::flash("error", "Update failed");
        }

        return redirect()->back();
    }

    public function updateVatrates(Request $request)
    {
        $data = array(
            'company_id' => Auth::user()->company_id,
            'type' => $request->input('type'),
            'rate' => $request->input('rate'),
            'date' => date('Y-m-d')
        );

        try {
            $vat = Vat::find($request->get('id'));
            $vat->update($data);
            Session::flash("success", "Vat updated successfully");
        } catch (\Exception $e) {
            Session::flash("error", "Integrity constraint violation");
        }

        return redirect()->back();
    }

    //Todo: old settings to review
    public function settings_edit(Request $request, $page)
    {
        $company_id = Auth::user()->company_id;
        $id = $request->input('id');
        if ($page == "invoice_group") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'identifier_year' => $request->input('identifier_year'),
                'identifier_month' => $request->input('identifier_month'),
                'identifier_day' => $request->input('identifier_day'),
                'next_id' => $request->input('next_id'),
                'left_pad' => $request->input('left_pad'),
                'date' => date('Y-m-d')
            );

            $query = DB::table('corpfin_invoice_groups')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
        if ($page == "tax_rate") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'rate' => $request->input('rate'),
                'date' => date('Y-m-d')
            );
            $query = DB::table('corpfin_taxrate')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
        if ($page == "payment_method") {
            $data = array(
                'company_id' => $company_id,
                'name' => $request->input('name'),
                'date' => date('Y-m-d')
            );
            $query = DB::table('corpfin_paymentmethod')->where(['id' => $id, 'company_id' => $company_id])->update($data);
            return Redirect::back();
        }
    }

    //set the markup 
    public function set_markup(){
        return view('CorpFIN.Settings.set_markup');
    }

    public function store_markup(Request $request){

        $this->validate($request, [
            'type' => 'required', 
            'value' => 'numeric']);
        $company = Company::find(Auth::user()->company_id);
        $markup = $company->markup()->first();

        if(count($markup) > 0){
            $markup->update($request->all());
        }
        else{
            $markup = new Markup($request->all());
            $markup->company_id = Auth::user()->company_id;
            $markup->save();
        }

        return back()->with('status', 'success');
    }

}
