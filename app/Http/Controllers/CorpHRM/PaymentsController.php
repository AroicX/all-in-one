<?php
namespace App\Http\Controllers\CorpHRM;

use App\Traits\SubscriptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\CashAdvance\CashAdvanceAdvance;
use App\Models\CorpHRM\CashAdvance\CashAdvanceDisbursment;
use App\Models\CorpHRM\CashAdvance\CashAdvanceRetirement;
use App\Models\CorpHRM\CashAdvance\CashRetirement;
use App\Models\CorpHRM\claims\ClaimMaster;
use App\Models\CorpHRM\claims\ClaimApplication;
use App\Models\CorpHRM\loan\LoanMaster;
use App\Models\CorpHRM\loan\LoanApplication;
use App\Models\CorpHRM\InternalRevenue;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\payroll\payroll;
use DB;
use App\User;

class PaymentsController extends Controller
{

	public function view_payments(){
		if (Auth::check()) {

			$company_id = Auth::user()->company_id;

			$payee = payroll::where(['company_id' => $company_id,'payee_paid' => "0"])->get();
			$nhf = payroll::where(['company_id' => $company_id,'nhf_paid' => "0"])->get();
			$nhis = payroll::where(['company_id' => $company_id,'nhis_paid' => "0"])->get();
			$pension = payroll::where(['company_id' => $company_id,'pension_paid' => "0"])->get();
			$sirbs = InternalRevenue::where(['company_id' => $company_id])->get();
        	$branches = Branch::where(['company_id' => $company_id])->get();
			return view('CorpHRM.Payments.ListPayments',['payee' => $payee, 'nhf' => $nhf, 'sirbs' => $sirbs, 'nhis' => $nhis, 'pension' => $pension, 'branches' => $branches]);
        }
        else
         {
            return Redirect::intended('login');
        }
	}

	public function make_payment($category, $id){
		if (Auth::check()) {

			if($category == "claim"){
				
			}
			if($category == "loan"){
				
			}
			return view('CorpHRM.Payments.MakePayment');
        }
        else
         {
            return Redirect::intended('login');
        }
	}

}