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
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Grade;
use App\User;

class CashAdvanceController extends Controller
{


public function get_cash_advance_disbursment(){
	if (Auth::check()) {

		$profiles = User::where('company_id',Auth::user()->company_id)->get();
		return view('CorpHRM.CashAdvance.cash_advance_disbursment',compact('profiles'));

	}else{

		 return Redirect::intended('login');
	}
}

public function list_cash_advance_disbursments(){
	if (Auth::check()) {

		$disbursments = CashAdvanceDisbursment::where('company_id',Auth::user()->company_id)->get();
		$result = array();
		foreach ($disbursments as $disbursment){
            $user = User::where('id',$disbursment->employee)->first();
                $result[] = [
					'id' => $disbursment->id,
                    'disbursment_date' => $disbursment->disbursment_date,
                    'approval_code' => $disbursment->approval_code,
                    'employee' => $user['name'],
                    'application_date' => $disbursment->application_date,
                    'approved_date' => $disbursment->approved_date,
                    'approved_amount' => $disbursment->approved_amount,
                    'remarks' => $disbursment->remarks,
                    'payment_mode' => $disbursment->payment_mode,
                    'bank' => $disbursment->bank
                ];
        }
		return view('CorpHRM.CashAdvance.list_cash_advance_disbursments',['disbursments' => $result]);

	}else{

		 return Redirect::intended('login');
	}
}

public function list_my_cash_advance_disbursments(){
	if (Auth::check()) {

		$disbursments = CashAdvanceDisbursment::where(['company_id'=> Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
		$result = array();
		foreach ($disbursments as $disbursment){
            $user = User::where('id',$disbursment->employee)->first();
                $result[] = [
					'id' => $disbursment->id,
                    'disbursment_date' => $disbursment->disbursment_date,
                    'approval_code' => $disbursment->approval_code,
                    'employee' => $user['name'],
                    'application_date' => $disbursment->application_date,
                    'approved_date' => $disbursment->approved_date,
                    'approved_amount' => $disbursment->approved_amount,
                    'remarks' => $disbursment->remarks,
                    'payment_mode' => $disbursment->payment_mode,
                    'bank' => $disbursment->bank
                ];
        }
		return view('CorpHRM.CashAdvance.list_cash_advance_disbursments',['disbursments' => $result]);

	}else{

		 return Redirect::intended('login');
	}
}

public function post_cash_advance_disbursment(Request $request){

	if (Auth::check()) {
		$db = new CashAdvanceDisbursment();
		$db->disbursment_date = $request->disbursment_date;
		$db->approval_code = $request->approval_code;
		$db->application_date = date('Y-m-d H:i:s');
		$db->approved_date = $request->approved_date;
		$db->approved_amount = $request->approved_amount;
		$db->employee = $request->employee;
		$db->remarks = $request->remarks;
		$db->payment_mode = $request->payment_mode;
		$db->bank = $request->bank;
		$db->company_id = Auth::user()->company_id;
		$db->save();
		return redirect('corphrm/cashadvance/disbursment/new')->with('success', 'Action successful');
	}else{

		 return Redirect::intended('login');
	}

}

public function get_cash_advance_retirement(){
	
	if (Auth::check()) {
		$result_disbursments = array();
		$retirment_code = count(CashAdvanceRetirement::where('company_id',Auth::user()->company_id)->get()) + 1;
		$disbursments = CashAdvanceDisbursment::where(['company_id' => Auth::user()->company_id,'employee' => Auth::user()->id])->get();
		foreach($disbursments as $disbursment){
			$retirements = CashAdvanceRetirement::where(['company_id' => Auth::user()->company_id,'disbursment_id' => $disbursment->id])->get();
			$i = 0;
			foreach($retirements as $retirement){
				$i = $i + $retirement->retirement_amount;
			}
			if($disbursment->approved_amount < $i){
				$result_disbursments[] = [
					'id' => $disbursment->id,
					'name' => "".$disbursment->disbursment_date."".$disbursment->approved_amount."",
					'amount_disbured' => $disbursment->approved_amount,
					'amount_left' => $disbursment->approved_amount - $i
				];
			}
		}
		$profiles = User::where('company_id',Auth::user()->company_id)->get();
		return view('CorpHRM.CashAdvance.cash_advance_retirement',compact('profiles','retirment_code','result_disbursments'));	
	}else{

		 return Redirect::intended('login');
	}
}

public function list_cash_advance_retirements(){

	if (Auth::check()) {

		$retirements = CashAdvanceRetirement::where('company_id',Auth::user()->company_id)->get();
		
		$result = array();
			foreach ($retirements as $retirement){
			$user = User::where('id',$retirement->employee)->first();
			$disbursment = CashAdvanceDisbursment::where(['id' => $retirement->disbursment_id])->first();
                $result[] = [
					'id' => $retirement->id,
                    'transaction_date' => $retirement->transaction_date,
                    'retirement_code' => $retirement->retirement_code,
					'employee' => $user['name'],
					'disbursment' =>  "".$disbursment['disbursment_date']."".$disbursment['approved_amount']."",
                    //'approval_code' => $retirement->approval_code,
                    //'approved_amount' => $retirement->approved_amount,
                    'retirement_amount' => $retirement->retirement_amount,
                    'remarks' => $retirement->remarks,
                    //'balance' => $retirement->balance,
					'upload_doc' => $retirement->upload_doc,
					'status' => $retirement->status
                ];
        }

		return view('CorpHRM.CashAdvance.list_cash_advance_retirements',['retirements' => $result]);

	}else{

		 return Redirect::intended('login');
	}

}


public function list_my_cash_advance_retirements(){
	
		if (Auth::check()) {
	
			$retirements = CashAdvanceRetirement::where(['company_id'=> Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
			
			$result = array();
				foreach ($retirements as $retirement){
				$user = User::where('id',$retirement->employee)->first();
				$disbursment = CashAdvanceDisbursment::where(['id' => $retirement->disbursment_id])->first();
					$result[] = [
						'id' => $retirement->id,
						'transaction_date' => $retirement->transaction_date,
						'retirement_code' => $retirement->retirement_code,
						'employee' => $user['name'],
						'disbursment' =>  "".$disbursment['disbursment_date']."".$disbursment['approved_amount']."",
						//'approval_code' => $retirement->approval_code,
						//'approved_amount' => $retirement->approved_amount,
						'retirement_amount' => $retirement->retirement_amount,
						'remarks' => $retirement->remarks,
						//'balance' => $retirement->balance,
						'upload_doc' => $retirement->upload_doc,
						'status' => $retirement->status
					];
			}
	
			return view('CorpHRM.CashAdvance.list_cash_advance_retirements',['retirements' => $result]);
	
		}else{
	
			 return Redirect::intended('login');
		}
	
	}

public function post_cash_advance_retirement(){

	if (Auth::check()) {
		$db = new CashAdvanceRetirement();
		$db->retirement_code = $request->retirement_code;
		//$db->approval_code = $request->approval_code;
		$db->disbursment_id = $request->disbursment_id;
		$db->transaction_date = date('Y-m-d H:i:s');
		//$db->approved_amount = $request->approved_amount;
		$db->retirement_amount = $request->retirement_amount;
		//$db->balance = $request->balance;
		$db->remarks = $request->remarks;
		$db->employee = Auth::user()->id;
		$db->upload_doc = $request->upload_doc;
		$db->company_id = Auth::user()->company_id;
		$db->save();
		return redirect('corphrm/cashadvance/retirement/new')->with('success', 'Action successful');
	}else{

		 return Redirect::intended('login');
	}

}

public function get_cash_advance_advance(){
	if (Auth::check()) {

		$profiles = User::where('company_id',Auth::user()->company_id)->get();
		return view('CorpHRM.CashAdvance.cash_advance_advance',compact('profiles'));	
	}else{

		 return Redirect::intended('login');
	}
}

public function list_my_cash_advance_advances(){
	if (Auth::check()) {
		$advances = CashAdvanceAdvance::where(['company_id' => Auth::user()->company_id,'employee' => Auth::user()->id])->get();
		$result = array();
			foreach ($advances as $advance){
            $user = User::where('id',$advance->employee)->first();
                $result[] = [
					'id' =>$advance->id,
                    'approval_code' => $advance->approval_code,
                    'approval_date' => $advance->approval_date,
                    'employee' => $user['name'],
                    'application_code' => $advance->application_code,
                    'application' => $advance->application,
                    'requested_amount' => $advance->requested_amount,
                    'remarks' => $advance->remarks,
                    'approved_amount' => $advance->approved_amount
                ];
        }
		return view('CorpHRM.CashAdvance.list_cash_advance_advances',['advances' => $result]);

	}else{

		 return Redirect::intended('login');
	}
}

public function list_cash_advance_advances(){
	if (Auth::check()) {

		$advances = CashAdvanceAdvance::where('company_id',Auth::user()->company_id)->get();
		$result = array();
			foreach ($advances as $advance){
            $user = User::where('id',$advance->employee)->first();
                $result[] = [
					'id' =>$advance->id,
                    'approval_code' => $advance->approval_code,
                    'approval_date' => $advance->approval_date,
                    'employee' => $user['name'],
                    'application_code' => $advance->application_code,
                    'application' => $advance->application,
                    'requested_amount' => $advance->requested_amount,
                    'remarks' => $advance->remarks,
                    'approved_amount' => $advance->approved_amount
                ];
        }
		return view('CorpHRM.CashAdvance.list_cash_advance_advances',['advances' => $result]);

	}else{

		 return Redirect::intended('login');
	}
}

public function post_cash_advance_advance(){

	if (Auth::check()) {
		$db = new CashAdvanceAdvance();
		$db->retirement_code = $request->retirement_code;
		$db->approval_code = $request->approval_code;
		$db->approval_date = $request->approval_date;
		$db->application_code = $request->application_code;
		$db->employee = $request->employee;
		$db->application = $request->application;
		$db->requested_amount = $request->requested_amount;
		$db->approved_amount = $request->approved_amount;
		$db->remarks = $request->remarks;
		$db->company_id = Auth::user()->company_id;
		$db->save();
		return redirect('corphrm/cashadvance/advance/new')->with('success', 'Action successful');
	}else{

		 return Redirect::intended('login');
	}

}

public function get_cash_retirement_approval(){
	if (Auth::check()) {

		$profiles = User::where('company_id',Auth::user()->company_id)->get();
		return view('CorpHRM.CashAdvance.cash_retirement_approval',compact('profiles'));	
	}else{

		 return Redirect::intended('login');
	}
}

public function list_cash_retirement_approvals(){
	if (Auth::check()) {

		$retirements = CashRetirement::where('company_id',Auth::user()->company_id)->get();
		$result = array();
		foreach ($retirements as $retirement){
		$user = User::where('id',$retirement->employee)->first();
		$disbursment = CashAdvanceDisbursment::where(['id' => $retirement->disbursment_id])->first();
			$result[] = [
				'id' => $retirement->id,
				'transaction_date' => $retirement->transaction_date,
				'retirement_code' => $retirement->retirement_code,
				'employee' => $user['name'],
				'disbursment' =>  "".$disbursment['disbursment_date']."".$disbursment['approved_amount']."",
				//'approval_code' => $retirement->approval_code,
				//'approved_amount' => $retirement->approved_amount,
				'retirement_amount' => $retirement->retirement_amount,
				'remarks' => $retirement->remarks,
				//'balance' => $retirement->balance,
				'upload_doc' => $retirement->upload_doc,
				'status' => $retirement->status
			];
	}
		// 	$result = array();
		// 	foreach ($retirements as $retirement){
        //     $user = User::where('id',$retirement->employee)->first();
        //         $result[] = [
		// 			'id' => $retirement->id,
        //             'transaction_date' => $retirement->transaction_date,
        //             'cash_retirement_code' => $retirement->cash_retirement_code,
        //             'employee' => $user['name'],
        //             'approval_date' => $retirement->approval_date,
        //             'advanced_amount_disbursed' => $retirement->advanced_amount_disbursed,
        //             'retirement_amount' => $retirement->retirement_amount,
        //             'approved_retirement_amount' => $retirement->approved_retirement_amount,
        //             'balance' => $retirement->balance,
        //             'doc' => $retirement->doc
        //         ];
        // }
		return view('CorpHRM.CashAdvance.list_cash_retirement_approvals',['retirements' => $result]);

	}else{

		 return Redirect::intended('login');
	}
}

public function post_cash_retirement_approval(){

	if (Auth::check()) {
		$db = new CashRetirement();
		$db->cash_retirement_code = $request->cash_retirement_code;
		$db->approval_date = $request->approval_date;
		$db->transaction_date = date('Y-m-d H:i:s');
		$db->advanced_amount_disbursed = $request->advanced_amount_disbursed;
		$db->retirement_amount = $request->retirement_amount;
		$db->balance = $request->balance;
		$db->remarks = $request->remarks;
		$db->employee = Auth::user()->id;
		$db->approved_retirement_amount = $request->approved_retirement_amount;
		$db->doc = $request->doc;
		$db->company_id = Auth::user()->company_id;
		$db->save();
		return redirect('corphrm/cashadvance/retirement_approval/new')->with('success', 'Action successful');
	}else{

		 return Redirect::intended('login');
	}

}

}