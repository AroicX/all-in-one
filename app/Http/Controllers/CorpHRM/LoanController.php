<?php

namespace App\Http\Controllers\CorpHRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\loan\LoanMaster;
use App\Models\CorpHRM\loan\LoanApplication;
use App\Models\CorpHRM\loan\LoanDisbursement;
use App\Models\CorpHRM\loan\LoanPayment;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Branch;
use App\User;
use DB;


class LoanController extends Controller
{
//    use SubscriptionTrait;
    /**
     * Display the loan master page
     *
     * @return type
     */
    public function getLoanMaster()
    {
        if (Auth::check()) {
            $grades = Grade::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.loan.loanMaster',['grades' => $grades]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function EditLoanMaster($id)
    {
        if (Auth::check()) {
            $grades = Grade::where('company_id',Auth::user()->company_id)->get();
            $LoanMaster = LoanMaster::where(['company_id'=>Auth::user()->company_id,'id'=>$id])->first();
            return view('CorpHRM.loan.loanMaster_edit',['grades' => $grades,'loanmaster' => $LoanMaster]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function listLoanMaster()
    {
        if (Auth::check()) {
            $LoansMaster = LoanMaster::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.loan.listloanMaster',['LoansMaster' => $LoansMaster]);
        }
        else
         {
            return Redirect::intended('login');
        }
    } 
    
    /**
     * Process the form of the loan master page
     *
     * @param Request $request
     */

    public function postLoanMaster(Request $request){
    if (Auth::check())
    {   
        $check = LoanMaster::where(['loan_name' => $request->loan_name, 'company_id' => Auth::user()->company_id])->get();
        if($check){
            return redirect('corphrm/loanmaster/new')->with('error', 'loan master already registerd!');
        }else{
            $loanMaster = new LoanMaster();
            $loanMaster->loan_name = $request->loan_name;
            $loanMaster->loan_maximum_limit = $request->loan_maximum_limit;
            $loanMaster->loan_limit_annual_gross = $request->loan_annual_gross;
            $loanMaster->multiple_loan = $request->allow_multiple_loan;
            $loanMaster->grade_id = $request->grade;
            $loanMaster->company_id = Auth::user()->company_id;
            $loanMaster->save();
            $success = true;
        }
        return view('CorpHRM.loan.loanMaster',  compact('success'));
    }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function UpdateLoanMaster(Request $request){
        if (Auth::check())
        {   
            $check = LoanMaster::where(['loan_name' => $request->loan_name, 'company_id' => Auth::user()->company_id])->get();
            if(count($check) > 1){
                return redirect('corphrm/loanmaster/new')->with('error', 'loan master already registerd!');
            }else{
                LoanMaster::where('id',$request->id)->update([
                'loan_name' => $request->loan_name,
                'loan_maximum_limit' => $request->loan_maximum_limit,
                'loan_limit_annual_gross' => $request->loan_annual_gross,
                'multiple_loan' => $request->allow_multiple_loan,
                'grade_id' => $request->grade,
                ]);
                $success = true;
            }
            return redirect()->back()->with(compact("success"));
        }
            else
            {
                return Redirect::intended('login');
            }
        }
    
    public function getLoanApplication()
    {
        if (Auth::check()) {

            $loanDetails = LoanMaster::get();
            $profiles = EmployeeProfile::all();
                    $user_id = Auth::user()->id;
        $EmployeeProfile = EmployeeProfile::where('user_id',$user_id)->first();
        $company_id = Auth::user()->company_id;
        $loanmaster = LoanMaster::where(['company_id' => $company_id, 'grade_id' => $EmployeeProfile['grade']])->get();
            $app_ref = $this->generatetoken("6","hrm_loan_application","application_ref");
            $count = LoanApplication::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.loan.loanApplicaton',[
                'loanDetails' => $loanDetails,
                'loanmasters' => $loanmaster,
                'app_ref' => count($count) + 1,
                'profiles' => $profiles
            ]);
        }
        else
             {
            return Redirect::intended('login');
        }
    }

    public function listLoanApplication(){

        if (Auth::check()) {
            $LoansApplication = LoanApplication::where('company_id',Auth::user()->company_id)->get();
            $branches = Branch::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.loan.listloanApplication',['branches' => $branches, 'LoansApplication' => $LoansApplication, 'type' => "All"]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function listMyLoanApplication(){
        
                if (Auth::check()) {
                    $LoansApplication = LoanApplication::where(['company_id'=> Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
                    return view('CorpHRM.loan.listLoanApplication',['LoansApplication' => $LoansApplication, 'type' => "My"]);
                }
                else
                 {
                    return Redirect::intended('login');
                }
    }

    public function postLoanApplication(Request $request)
    {
        if (Auth::check()) {
            $check = LoanMaster::where(['id' => $request->loanmaster_id])->first();
            if($request->loan_amount > $check['loan_maximum_limit']){
                return redirect('corphrm/loanapp/new')->with('error', 'loan limit exceeded!');
            }
            if($check['multiple_loan'] = "0"){
                $loanapps = LoanApplication::where(['employee_id' => Auth::user()->id, 'stage' => "2", 'status' => "Disbursed"])->get();
                foreach ($loanapps as $loanapp){
                   $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp->id])->get();
                   $disbursed_amount = 0;
                   foreach($disbursements as $disbursement){
                    $disbursed_amount = $disbursed_amount + $disbursement->disbursed_amount;
                        $payments = LoanPayment::where(['loanapp_id' => $loanapp->id])->get();

                        $payed_amount = 0;
                        foreach ($payments as $payment){
                            $payed_amount = $payed_amount + $payment->amount_payed;
                        }
                   }
                   if($disbursed_amount > $payed_amount){
                        return redirect('corphrm/loanapp/new')->with('error', 'Liquidate all pending loans to proceed');
                   }
                }
            }
                //todo: Validate
                $loanApp = new LoanApplication();
                $loanApp->application_ref = $request->application_ref;
                $loanApp->application_date = date('Y-m-d H:i:s');//$request->application_date;
                $loanApp->employee_id = Auth::user()->id;
                $loanApp->contact_no = $request->contact_number;
               // $loanApp->loan_id = $request->loan_id;
                $loanApp->loanmaster_id = $request->loanmaster_id;
                $loanApp->loan_amount = $request->loan_amount;
                $loanApp->no_of_installments = $request->no_of_installments;
                //$loanApp->installment_amount = $request->installment_amount;
                $loanApp->remarks = $request->remarks;
                //$loanApp->loan_doc_name = 'adsdf'; //$request->loan_name;
                $loanApp->loan_doc_file = $request->loan_doc_file;
                $loanApp->company_id = Auth::user()->company_id;
                $loanApp->save();
                $success = true;
                return redirect()->back()->with('success', 'successfully submitted!');

        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function listLoanDisbursement(){

        if (Auth::check()) {
            $LoansDisbursments = LoanDisbursement::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.loan.listloansDisbursment',['LoansDisbursments' => $LoansDisbursments]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function listMyLoanDisbursement(){
        
                if (Auth::check()) {
                    $LoansDisbursments = LoanDisbursement::where(['company_id'=> Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
                    return view('CorpHRM.loan.listloansDisbursment',['LoansDisbursments' => $LoansDisbursments]);
                }
                else
                 {
                    return Redirect::intended('login');
                }
            }

    public function getLoanDisbursement()
    {
        if (Auth::check()) {
        $loanDetails = array();
        $profiles = User::where('company_id',Auth::user()->company_id)->get();

        $loanapps = LoanApplication::where(['company_id' => Auth::user()->company_id, 'stage' => "2", 'status' => "Disbursed"])->get();
        foreach ($loanapps as $loanapp){
            $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp->id])->count();
                if($disbursements = 0){
                    $loanDetails[] = [
                        'name' => "".$loanapp->application_ref."/".$loanapp->application_date."",
                        'id' => $loanapp->id  
                    ]; 
                }
            }
            $transaction_id = count(LoanDisbursement::where('company_id', Auth::user()->company_id)->get()) + 1;
            //$this->generatetoken("7","hrm_loan_disbursement","trasaction_id");
            return view('CorpHRM.loan.loanDisbursement',compact('loanDetails','profiles','transaction_id'));
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    public function postLoanDisbursement(Request $request)
     {
         if (Auth::check()) {
        $loanDisbursement = new LoanDisbursement();
        $loanDisbursement->transaction_date = date('Y-m-d H:i:s');
        $loanDisbursement->trasaction_id = $request->trasaction_id;
        $loanDisbursement->employee_id = $request->employee_id;
        $loanDisbursement->loanapp_id = $request->loan_id;
        $loanDisbursement->disbursed_amount = $request->disbursement_amount;
        $loanDisbursement->mode_of_disbursement = $request->mode_of_disbursement;
        $loanDisbursement->company_id = Auth::user()->company_id;
        $loanDisbursement->disbursed_by = Auth::user()->id;
        $loanDisbursement->status = "Approved";
        $loanDisbursement->save();
        $success = true;
//        return view('CorpHRM.loan.loanDisbursement',compact('success'));
             return redirect()->back()->with(compact('success'));
         }
         else
         {
             return Redirect::intended('login');
         }
     }
    
        public function getLoanPayment()
        {
            if (Auth::check()) {
                $loanDetails = array();
                $loanapps = LoanApplication::where(['employee_id' => Auth::user()->id, 'stage' => "2", 'status' => "Disbursed"])->get();
                foreach ($loanapps as $loanapp){
                   $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp->id])->get();
                   $disbursed_amount = 0;
                   foreach($disbursements as $disbursement){
                    $disbursed_amount = $disbursed_amount + $disbursement->disbursed_amount;
                        $payments = LoanPayment::where(['loanapp_id' => $loanapp->id])->get();

                        $payed_amount = 0;
                        foreach ($payments as $payment){
                            $payed_amount = $payed_amount + $payment->amount_paid;
                        }
                   }
                   if($disbursed_amount > $payed_amount){
                        $loanDetails[] = [
                          'name' => "".$loanapp->application_ref."/".$loanapp->application_date."",
                          'id' => $loanapp->id  
                        ];
                   }
                }
                $profiles = EmployeeProfile::all();
                $transaction_id =  count(LoanPayment::where('company_id', Auth::user()->company_id)->get()) + 1;
                //$this->generatetoken("7","hrm_loan_payment","transaction_id");
                return view('CorpHRM.loan.loanPayment', compact('loanDetails', 'profiles', 'transaction_id'));
            } else {
                return Redirect::intended('login');
            }
        }

        public  function ListLoanPayment(){

            if (Auth::check()) {
                $loanpayments = LoanPayment::where('company_id',Auth::user()->company_id)->get();
                return view('CorpHRM.loan.loanPayments',['loanpayments' => $loanpayments]);
            }
            else
             {
                return Redirect::intended('login');
            }
        }

        public  function ListMyLoanPayment(){
            
                        if (Auth::check()) {
                            $loanpayments = LoanPayment::where(['employee_id' => Auth::user()->id,'company_id'=>Auth::user()->company_id])->get();
                            return view('CorpHRM.loan.loanPayments',['loanpayments' => $loanpayments]);
                        }
                        else
                         {
                            return Redirect::intended('login');
                        }
        }
    
        public function postLoanPayment(Request $request)
        {
            if (Auth::check()) {
                 //todo: Validate
            $loanPayment = new LoanPayment();
            $loanPayment->transaction_date = date('Y-m-d H:i:s');//$request->transaction_date;
            $loanPayment->transaction_id = $request->transaction_id;
            $loanPayment->employee_id = Auth::user()->id;
            $loanPayment->loanapp_id = $request->loan_id;
            $loanPayment->outstanding_balance = $request->outstanding_balance;
            $loanPayment->payment_mode = $request->payment_mode;
            $loanPayment->payment_type = $request->payment_type;
            $loanPayment->amount_paid = $request->amount_paid;
            $loanPayment->company_id = Auth::user()->company_id;
            $loanPayment->save();
            $success = true;
    //        return view('CorpHRM.loan.loanDisbursement',compact('success'));
            return redirect()->back()->with(compact('success'));

            }
            else
            {
                return Redirect::intended('login');
            }
        }

    public function UpdateLoan(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        if($status == "approve1"){
            LoanApplication::where('id',$id)->update(['status' => "Approved", 'stage' => "1",'approved_by' => Auth::user()->id]);
        }elseif($status == "approve2"){
            LoanApplication::where('id',$id)->update(['status' => "Disbursed", 'stage' => "2",'approved_by' => Auth::user()->id]);
        }else{
            LoanApplication::where('id',$id)->update(['status' => $status,'approved_by' => Auth::user()->id]);
        }

        return redirect('corphrm/loanapp')->with('success', 'Action successful');

    }

    public function getParameters($parameter, $id){

        $result = "";
        if($parameter == "outstanding_balance"){
                       $loanapp = LoanApplication::where(['id' => $id])->first();
                   $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp['id']])->get();
                   $disbursed_amount = 0;
                   foreach($disbursements as $disbursement){
                    $disbursed_amount = $disbursed_amount + $disbursement->disbursed_amount;
                        $payments = LoanPayment::where(['loanapp_id' => $loanapp->id])->get();
                        $payed_amount = 0;
                        foreach ($payments as $payment){
                            $payed_amount = $payed_amount + $payment->amount_paid;
                        }
                   }
                   $result = $disbursed_amount - $payed_amount;
        }
        if($parameter == "amount_to_be_paid"){
            //$payment = LoanPayment::where('id',$id)->first();
            $loanapp = LoanApplication::where(['id' => $id])->first();
                   $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp['id']])->get();
                   $disbursed_amount = 0;
                   foreach($disbursements as $disbursement){
                    $disbursed_amount = $disbursed_amount + $disbursement->disbursed_amount;
                        $payments = LoanPayment::where(['loanapp_id' => $loanapp->id])->get();
                        $payed_amount = 0;
                        foreach ($payments as $payment){
                            $payed_amount = $payed_amount + $payment->amount_paid;
                        }
                   }
                   $pending_payment = $disbursed_amount - $payed_amount;
                   $initial_borrowed = $loanapp['loan_amount'];
                   $installments = $loanapp['no_of_installments'];
                   if($pending_payment >= $initial_borrowed/$installments){
                    $result = round($initial_borrowed/$installments);
                   }else{
                    $result = round($pending_payment);
                   }

        }
        if($parameter == "get_loan"){
        $result = array();
        $loanapps = LoanApplication::where(['company_id' => Auth::user()->company_id, 'employee_id' => $id, 'stage' => "2", 'status' => "Disbursed"])->get();
        foreach ($loanapps as $loanapp){
            $disbursements = LoanDisbursement::where(['loanapp_id' => $loanapp->id])->count();
                if($disbursements == 0){
                    $result[] = [
                        'text' => "".$loanapp->application_ref."/".$loanapp->application_date."",
                        'value' => $loanapp->id  
                    ]; 
                }
            }
            return $result;
        }
        if($parameter == "disbursement_amount"){

            $loanapp = LoanApplication::where(['id' => $id])->first();
            $result = $loanapp['loan_amount'];
            return $result;
        }
        return json_encode($result);
    }

                /**
        *Generate Token
        */      
    public function generatetoken($length,$table,$row) 
    {
        $code = 0;
        $check = true;
    while($check)
    {
        $code = $this->generate_new_token($length);
        $check = $this->check_token($table,$row,$code);
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
        $p_exist = DB::select( DB::raw("SELECT * FROM $table WHERE $row = '$code' "));
    if (!empty($p_exist)) {
        $result = true;
    }
    else
    {
        $result = false;
    }     
        return $result;
    }

}
