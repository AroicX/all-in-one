<?php

namespace App\Http\Controllers;

use App\Country;
use App\Payment;
use App\Product;
use App\State;
use App\Subscription;
use App\Trial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorpHRM;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Traits\GenerateCodeTrait;
use App\Traits\RavePaymentTrait;
use Bican\Roles\Models\Role;
use App\corperm_packages;
use App\RavePayment as RavePaymentModel;

class SubscriptionController extends Controller
{
    use GenerateCodeTrait;
    use RavePaymentTrait;

    /**
     * Checks if user has set up company profile
     * @return bool
     */
    public function check_company_setup_status()
    {
        return (Auth::user()->company_id > 0) ? true : false;
    }

    public function Get_states($country_id)
    {
        $fetch = State::where('country_id', $country_id)->get();
        return Response::json($fetch);
    }

    public function setup_company()
    {
        if(Auth::check()){
            if(!$this->check_company_setup_status()){
                $countries = Country::all();
                return view('panel.Setup', ['countries'=>$countries])/*->with(['title'=> 'setup'])*/;
            }
            else{
    
                return Redirect::intended('dashboard');
    
            }
        }else{
            return Redirect::intended('login');
        }


    }

    public function post_setup(Request $request)
    {
        $validator = Validator::make(
            Input::all(),
            [
                'name'=>'required|unique:company',
                'email'=>'required|unique:company',
                'crn'=>'required|unique:company',
            ],
            [
                'name.required'   => 'Company name is Required',
                'crn.unique'        => 'Company Registration Number Already Registered',
                'name.unique'          => 'Company name Already Registered',
                'email.unique'          => 'Email-Address Already Registered',
            ]
        );
        if($validator->fails()) {
            $messages = json_encode($validator->messages());
            return json_encode([ 'result' => 'val_fail','error'=>$messages  ]);
        }else{
            $data = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'CRN' => $request->input('crn'),
                'logo' => "/uploads/Company/logo.jpg",
                'address' => $request->input('address'),
                'country' => $request->input('country'),
                'state' =>$request->input('state'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),

            );
            $company_id = DB::table('company')->insertGetId($data);
            $user_id = Auth::user()->id;
            $data = ['company_id' =>$company_id,
                    'level' => 3];
            $query = DB::table('users')->where('id', $user_id)->update($data);
            if($query) {
                return json_encode([ 'result' => 'success' ]);
            }else{
                return json_encode([ 'result' => 'fail' ]);
            }

        }
    }

    public function Subscription()
    {
        if(Auth::check()){
            $company_id = Auth::user()->company_id;
            $corpfin_packages = corperm_packages::where(['parent' => "CorpFIN"])->get();
            $corphrm_packages = corperm_packages::where(['parent' => "CorpHRM"])->get();
            $corppay_packages = corperm_packages::where(['parent' => "CorpPAY"])->get();
            $corptax_packages = corperm_packages::where(['parent' => "CorpTAX"])->get();
            $corpemt_packages = corperm_packages::where(['parent' => "CorpEMT"])->get();
            $Packages = [
                'corpfin' => $corpfin_packages,
                'corphrm' => $corphrm_packages,
                'corppay' => $corppay_packages,
                'corptax' => $corptax_packages,
                'corpemt' => $corpemt_packages
            ];
            return view('panel.Subscription', ['Packages'=>$Packages,'company_id'=>$company_id]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function Active_Subscription()
    {
        if(Auth::check()) {
            $active_sub = $this->active_sub();
            $expired_sub = $this->expired_sub();
            return view(
                'panel.Active_Subscription', ['active_subs'=>$active_sub ,
                    'expired_subs'=>$expired_sub]
            );

        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function active_sub()
    {
        $company_id = Auth::user()->company_id;
        return $active_packages = DB::select(DB::raw("SELECT * FROM subscription WHERE company_id = '$company_id' AND status = '1' "));
   
    }

    public function expired_sub()
    {
        $company_id = Auth::user()->company_id;
        return $active_packages = DB::select(DB::raw("SELECT * FROM subscription WHERE company_id = '$company_id' AND status = '0' "));
    }

    public function cancel_plan($id)
    {
        $company_id = Auth::user()->company_id;
        $where = array(
            'company_id' =>$company_id,
            'id' =>$id
        );
        $data = array(
            'status' => 0,
        );
        $query = DB::table('subscription')->where($where)->update($data);
        if($query) {
            return json_encode([ 'result' => 'success' ]);
        }else{
            return json_encode([ 'result' => 'fail' ]);
        }
    }

    public function Complete_transaction(Request $request)
    {

        
      
        $company_id = Auth::User()->company_id;
        $carbon = Carbon::now();
     
       
        $sub = new Subscription;
        $sub->company_id = $company_id;
        $sub->product_id = 1;
        $sub->package = $request->package;
        $sub->product = 'CorpFin';
        $sub->refx_code = $request->refx_code;
        $sub->duration = $request->duration;
        $sub->date = $carbon->toDateString();
        $sub->time = $carbon->toTimeString();
        $sub->status = 1;
        $sub->save();
       
        $sub = new Subscription;
        $sub->company_id = $company_id;
        $sub->product_id = 4;
        $sub->package = $request->package;
        $sub->product = 'CorpHRM';
        $sub->refx_code = $request->refx_code;
        $sub->duration = $request->duration;
        $sub->date = $carbon->toDateString();
        $sub->time = $carbon->toTimeString();
        $sub->status = 1;
        $sub->save();
       
        $sub = new Subscription;
        $sub->company_id = $company_id;
        $sub->product_id = 14;
        $sub->package = $request->package;
        $sub->product = 'CorpTAX';
        $sub->refx_code = $request->refx_code;
        $sub->duration = $request->duration;
        $sub->date = $carbon->toDateString();
        $sub->time = $carbon->toTimeString();
        $sub->status = 1;
        $sub->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription Successful'
        ]);

       
    }
    
    public function post_subscription(Request $request)
    {   

        
        $total_fee = 0;
        $plan_count = 0;
        $_corpfin_duration = 0;
        $_corphrm_duration = 0;
        $_corpemt_duration = 0;
        $_corppay_duration = 0;
        $_corptax_duration = 0;
        $meta = [];
        $refxCode = $this->generate_code('trials','7','refx_code');
        $companyId = $request->input('company_id');
        $userId = $request->input('user_id');
        $request->merge(['payment_method'=>"both"]);
        $request->merge(['description'=>"Subscription to CorpERM"]);
        $request->merge(['pay_button_text'=>"Make Payment"]);
        $request->merge(['ref'=> "CorpERM_SUB_".$refxCode]);
        $request->merge(['country'=>"NG"]);
        $request->merge(['currency'=>"NGN"]);

        $corpfin_package = $request->input('package_corpfin');
        $corpfin_package = explode(',',$corpfin_package[0]);
        $_corpfin_pack = $corpfin_package[1];
        $_corpfin_duration = $corpfin_package[2];
        $_corpfin_fee = $corpfin_package[3];

        $corphrm_package = $request->input('package_corphrm');
        $corphrm_package = explode(',',$corphrm_package[0]);
        $_corphrm_pack = $corphrm_package[1];
        $_corphrm_duration = $corphrm_package[2];
        $_corphrm_fee = $corphrm_package[3];

        $corpemt_package = $request->input('package_corpemt');
        $corpemt_package = explode(',',$corpemt_package[0]);
        $_corpemt_pack = $corpemt_package[1];
        $_corpemt_duration = $corpemt_package[2];
        $_corpemt_fee = $corpemt_package[3];

        $corppay_package = $request->input('package_corppay');
        $corppay_package = explode(',',$corppay_package[0]);
        $_corppay_pack = $corppay_package[1];
        $_corppay_duration = $corppay_package[2];
        $_corppay_fee = $corppay_package[3];

        $corptax_package = $request->input('package_corptax');
        $corptax_package = explode(',',$corptax_package[0]);
        $_corptax_pack = $corptax_package[1];
        $_corptax_duration = $corptax_package[2];
        $_corptax_fee = $corptax_package[3];

        if($_corpfin_fee > 0){$query_corpfin = corperm_packages::where(['parent' => "CorpFIN", 'name' => $_corpfin_pack])->first(); $total_fee = $total_fee + ($query_corpfin['fee'] * $_corpfin_duration); $plan_count= $plan_count +1; $meta[] = ['parent' => 'CorpFIN', 'package_id' => $query_corpfin['id'], 'duration' =>$_corpfin_duration * 30];}
        if($_corphrm_fee > 0){$query_corphrm = corperm_packages::where(['parent' => "CorpHRM", 'name' => $_corphrm_pack])->first(); $total_fee = $total_fee + ($query_corphrm['fee'] * $_corphrm_duration); $plan_count= $plan_count +1; $meta[] = ['parent' => 'CorpHRM', 'package_id' => $query_corphrm['id'], 'duration' =>$_corphrm_duration * 30];}
        if($_corpemt_fee > 0){$query_corpemt = corperm_packages::where(['parent' => "CorpEMT", 'name' => $_corpemt_pack])->first(); $total_fee = $total_fee + ($query_corpemt['fee'] * $_corpemt_duration); $plan_count= $plan_count +1; $meta[] = ['parent' => 'CorpEMT', 'package_id' => $query_corpemt['id'], 'duration' =>$_corpemt_duration * 30];}
        if($_corppay_fee > 0){$query_corppay = corperm_packages::where(['parent' => "CorpPAY", 'name' => $_corppay_pack])->first(); $total_fee = $total_fee + ($query_corppay['fee'] * $_corppay_duration); $plan_count= $plan_count +1; $meta[] = ['parent' => 'CorpPAY', 'package_id' => $query_corppay['id'], 'duration' =>$_corppay_duration * 30];}
        if($_corptax_fee > 0){$query_corptax = corperm_packages::where(['parent' => "CorpTAX", 'name' => $_corptax_pack])->first(); $total_fee = $total_fee + ($query_corptax['fee'] * $_corptax_duration); $plan_count= $plan_count +1; $meta[] = ['parent' => 'CorpTAX', 'package_id' => $query_corptax['id'], 'duration' =>$_corptax_duration * 30];}
        $total_fee = round($total_fee, 2);
        $request->merge(['amount'=>$total_fee]);
        
        $trial_data = [
            'user_id' => $userId,
            'company_id' => $companyId,
            'refx_code' => $refxCode,
            'amount'=> $total_fee,
            'no_plan'=> $plan_count,
            'narration' => 'Subscription',
            'status'=> 0, //transaction pending
            'meta' => json_encode($meta),
            'date'=> date('Y-m-d h:i:s')
        ];
        Trial::create($trial_data);
        $this->InitializeRavePay();

        // return json_encode([ 'result' => 'processing','refx_code'=>$refxCode ]);

    }

    public function ravepay_before_transaction_webook(){

    }

    public function ravepay_after_transaction_webhook(Request $request){
        $status = "2";  //transaction failed
        $refx_code = $this->input('txRef');
        $amount = $this->input('amount');
        $charged_amount = $this->input('charged_amount');
        if($this->input('status') == "successful")$status = "1"; //transaction successful
        Trial::updateOrCreate(['refx_code' => $refx_code], ['status' => $status, 'amount' => $amount]);
        $trial_data = Trial::where('refx_code', $refx_code)->first();
        $payment_data = [
            'user_id' => $trial_data['user_id'],
            'company_id' => $trial_data['company_id'],
            'refx_code' => $refx_code,
            'amount' => $amount,
            'charged_amount' => $charged_amount,
            'narration' => $trial_data['narration'],
            'status' => $status
        ];
        RavePaymentModel::create($payment_data);
        if($trial_data['narration'] == "Subscription"){
            $thic->subscribe_client($refx_code);
        }
        return json_encode(['status' => "successful"]);
    }

    protected function subscribe_client($refx_code){
        $trial_data = Trial::where('refx_code', $refx_code)->first();
        if($trial_data['narration'] == "Subscription"){
            $meta_data = json_decode($trial_data['meta']);
            foreach($meta_data as $subscription_detail){
                $subscription_data = [
                    'company_id' => $trial_data['company_id'],
                    'product_id' => $subscription_detail['package_id'],
                    'product' => $subscription_detail['parent'],
                    'date' => date('Y-m-d'),
                    'time' => date('h:i:s'),
                    'duration' => $subscription_detail['duration'],
                    'refx_code' => $refx_code,
                    'status' => "1"
                ];
                Subscription::create($subscription_data);
            }
        }
        return false;
    }
}
