<?php
namespace App\Http\Controllers\CorpHRM;

use App\Traits\SubscriptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\payroll\payroll;
use App\Models\CorpHRM\payroll\payroll_basic_settings;
use App\Models\CorpHRM\payroll\payroll_custom_settings;
use App\Models\CorpHRM\payroll\payroll_payee_settings;
use App\Models\CorpHRM\loan\LoanApplication;
use App\Models\CorpHRM\loan\LoanDisbursement;
use App\Models\CorpHRM\loan\LoanPayment;
use App\Models\CorpHRM\CashAdvance\CashAdvanceAdvance;
use App\Models\CorpHRM\CashAdvance\CashAdvanceDisbursment;
use App\Models\CorpHRM\CashAdvance\CashAdvanceRetirement;
use App\Models\CorpHRM\CashAdvance\CashRetirement;
use App\Models\User;
use App\Models\CorpHRM\StaffFees;
use App\Models\CorpHRM\Attendance;
use App\Models\CorpHRM\Allowance;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\EmployeeSalary;
use App\Models\CorpHRM\Employee;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Holiday;
use App\Models\CorpHRM\Weekoff;
use App\Models\CorpHRM\Salary;
use DB;
use PDF;
use App\SubAccount;
use App\CorpFinProduct;
use App\CorpFinService;
use App\CorpFinTranPartner;
use Carbon\Carbon;


class PayrollController extends Controller
{

	public function staffs_payroll(){

		if (Auth::check()){
			$company_id = Auth::user()->company_id;
			$grades = Grade::where('company_id', $company_id)->get();
			$departments = Department::where('company_id', $company_id)->get();
			return view('CorpHRM.Payroll.staffs_payroll',['grades' => $grades, 'departments' => $departments]);

        }else{
        
         return Redirect::intended('login');
        }

	}

	public function staff_fees(){
		
		if (Auth::check()){
			$company_id = Auth::user()->company_id;
			$result = [];
			$fees_history = StaffFees::where('company_id',$company_id)->get();
			$employees = User::where('company_id',$company_id)->get();
			foreach($fees_history as $fee_history){

				$user = User::where(['company_id' => $company_id, 'id' => $fee_history->employee_id])->first();

				if($fee_history->addition == "1"){
					$fee_type = "Addition";
				}else{
					$fee_type = "Subtraction";
				}
				$result = [
					'id' => $fee_history->id,
					'employee' => $user['name'],
					'period' => $fee_history->month."/".$fee_history->year,
					'amount' => $fee_history->amount,
					'fee_type' => $fee_type,
					'description' => $fee_history->description
				];
			}
			return view('CorpHRM.Payroll.staff_fees',['fees_history' => $result,'employees' => $employees]);
		}else{
        
         	return Redirect::intended('login');
        }				
	}

	public function post_staff_fees(Request $request){
		if (Auth::check()){
			$db = new StaffFees();
			$db->employee_id = $request->employee;
			$db->addition = $request->addition;
			$db->month = $request->month;
			$db->company_id = Auth::user()->company_id;
			$db->year = $request->year;
			$db->amount = $request->amount;
			$db->description = $request->description;
			$db->save();
			return redirect('corphrm/payroll/staff_fees')->with('success', 'Added Successfully!');
		}else{
        
         	return Redirect::intended('login');
        }
	}

	public function staff_payroll(){

		if (Auth::check()){
			$user_id = Auth::user()->id;
			$profile = EmployeeProfile::where(['user_id' => $user_id])->first();
			$salary = EmployeeSalary::where(['employee_id' => $profile['id']])->first();
			$payrolls = Payroll::where(['employee_id' => $user_id])->get();
			$paye = "0";
			$pension = "0";
			$nhf = "0";
			$nhis = "0";
			
			foreach($payrolls as $payroll){

				$paye = $paye + $payroll->PAYE;
				$pension = $pension + $payroll->pension;
				$nhf = $nhf + $payroll->NHF;
				$nhis = $nhis + $payroll->nhis;

			}
			$additions = [
                'paye' => $paye,
                'pension' => $pension,
                'nhf' => $nhf,
                'nhis' => $nhis
            ];
			return view('CorpHRM.Payroll.staff_payroll',['additions' => $additions,'uid' => $user_id,'salary' => $salary]);

        }else{
        
         return Redirect::intended('login');
        }

	}

	public function settings(){

		if (Auth::check()){

			$company_id = Auth::user()->company_id;
			$custom_settings = payroll_custom_settings::where('company_id', $company_id)->get();
			$basic_settings = payroll_basic_settings::where('company_id', $company_id)->get();
			$grades = Grade::where('company_id', $company_id)->get();
			$payee_type = payroll_payee_settings::where('company_id',Auth::user()->company_id)->first();
			$payee_type = $payee_type['name'];
			return view('CorpHRM.Payroll.settings',['custom_settings' => $custom_settings, 'basic_settings' => $basic_settings, 'grades' => $grades, 'payee_type' => $payee_type]);

        }else{
        
         return Redirect::intended('login');
        }

	}

	public function post_payee_settings(Request $request){

		$query = $request->get('query');
		$payee = payroll_payee_settings::where('company_id',Auth::user()->company_id)->get();
		if(count($payee) > 0){
			payroll_payee_settings::where('company_id',Auth::user()->company_id)->update(['name' => $query]);
		}else{
			$db = new payroll_payee_settings();
			$db->name = $query;
			$db->company_id = Auth::user()->company_id;
			$db->save();
		}
		return redirect('corphrm/payroll/settings')->with('success', 'Successfully Updated!');
	}

	public function post_payee_runday(Request $request){
		
				$query = $request->post('runday');
				$payee = payroll_payee_settings::where('company_id',Auth::user()->company_id)->get();
				if(count($payee) > 0){
					payroll_payee_settings::where('company_id',Auth::user()->company_id)->update(['run_day' => $query]);
				}else{
					$db = new payroll_payee_settings();
					$db->run_day = $query;
					$db->company_id = Auth::user()->company_id;
					$db->save();
				}
				return redirect('corphrm/payroll/settings')->with('success', 'Successfully Updated!');
	}

	public function post_addition_subtraction(Request $request){
		if (Auth::check()){

			if($request->type == "Basic"){

				$check = payroll_basic_settings::where(['company_id' =>  Auth::user()->company_id, 'wages_type' => $request->wages_type, 'name' =>$request->name_b])->first();
            	if($check){
            		return redirect('corphrm/payroll/settings')->with('error', 'Custom Parameter '.$request->name_b.' Already Added For Wage Type '.$request->wages_type.' !');
            	}else{
					$this->validate($request,[
						'name_b' => 'required',
						'type' => 'required',

					]);
				    $db = new payroll_basic_settings();
	                $db->name = $request->name_b;
	            	$db->addition = $request->addition;
	            	$db->subtraction = $request->subtraction;
	        		$db->company_id = Auth::user()->company_id;
	        		$db->type = $request->type;
	        		$db->is_taxable = $request->is_taxable;
	        		$db->frequency = $request->frequency;
	        		$db->mode = $request->mode;
					$db->value = $request->value;
					$db->wages_type = $request->wages_type;
	        		$db->effective_month = $request->effective_month;
	        		$db->calculate = $request->calculate;
	        		$db->assign_to_grade = $request->assign_to_grade;
	        	//	$db->nature = $request->nature;
	            	$db->save();
            	}
            }
            if($request->type == "Custom"){
            	$check = payroll_custom_settings::where(['company_id' =>  Auth::user()->company_id, 'wages_type' => $request->wages_type, 'name' =>$request->name_c])->first();
            	if($check){
            		return redirect('corphrm/payroll/settings')->with('error', 'Custom Parameter '.$request->name_c.' Already Added For Wage Type '.$request->wages_type.' !');
            	}else{
					$this->validate($request,[
						'name_c' => 'required',
						'type' => 'required',

					]);
			    $db = new payroll_custom_settings();
                $db->name = $request->name_c;
            	$db->addition = $request->addition;
            	$db->subtraction = $request->subtraction;
        		$db->company_id = Auth::user()->company_id;
	        	$db->type = $request->type;
	        	$db->is_taxable = $request->is_taxable;
	        	$db->frequency = $request->frequency;
	        	$db->mode = $request->mode;
				$db->value = $request->value;
				$db->wages_type = $request->wages_type;
	        	$db->effective_month = $request->effective_month;
	        	$db->calculate = $request->calculate;
	        	$db->assign_to_grade = $request->assign_to_grade;
	        	//$db->nature = $request->nature;
            	$db->save();
            	}
            }			
            return redirect('corphrm/payroll/settings')->with('success', 'Added Successfully!');
		}else{
        
         return Redirect::intended('login');
        }

	}

	public function GeneratePayroll(Request $request, $user_id = null){
		$day = $request->get('day');
		$month = $request->get('month');
		$year = $request->get('year');
		$get_grade = $request->get('grade');
		$get_department = $request->get('department');
		$current_day = date('d');
		$current_month = date('m');
		$current_year = date('Y');
		$payee_type = payroll_payee_settings::where('company_id',Auth::user()->company_id)->first();
		$payee_type = $payee_type['name'];
		if($user_id){
			$profile = EmployeeProfile::where('user_id', $user_id)->first();
			$salary = EmployeeSalary::where('employee_id', $profile['id'])->first();
			
			$wages_type = $salary['wages_type'];
			if($wages_type == "weekly" || $wages_type == "Weekly" || $wages_type == "w" || $wages_type == "W"){
				$check = payroll::where(['month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
				if($month != $current_month || $year != $current_year || $month != $current_month && $year != $current_year){
					
					if(count($check) == "0"){
						$pdf = PDF::loadView('CorpHRM.Payroll.payroll_unavaliable',[], [], ['format' => 'A4-L']);
						return $pdf->stream('payroll.pdf');
						return view('CorpHRM.Payroll.payroll_unavaliable');
					}
				}

			}elseif($wages_type == "daily" || $wages_type == "Daily" || $wages_type == "d" || $wages_type == "D"){
				$check = payroll::where(['day' => $day, 'month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
				if($day != null || $day != "" || empty($day)){	
					$check = payroll::where(['day' => $day, 'month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
					if($day != $current_day || $month != $current_month || $year != $current_year || $day != $current_day && $month != $current_month && $year != $current_year){
						
						if(count($check) =="0"){
							// $pdf = PDF::loadView('CorpHRM.Payroll.payroll_unavaliable',[], [], ['format' => 'A4-L']);
							// return $pdf->stream('payroll.pdf');
							return view('CorpHRM.Payroll.payroll_unavaliable');
						}
					}
					
				}else{
					// $pdf = PDF::loadView('CorpHRM.Payroll.payroll_unavaliable',[], [], ['format' => 'A4-L']);
					// return $pdf->stream('payroll.pdf');
				}
				
			}else{
				$check = payroll::where(['month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();

				// return $check;
				if($month != $current_month || $year != $current_year || $month != $current_month && $year != $current_year){
					
					if(count($check) === 0){
						// $pdf = PDF::loadView('CorpHRM.Payroll.payroll_unavaliable',[], [], ['format' => 'A4-L']);
						// return $pdf->stream('payroll.pdf');
						return view('CorpHRM.Payroll.payroll_unavaliable');
					}
				}
			}
			
			if(count($check) > 0){

				$detail = $check;

				foreach($detail as $details){

					$company_id = $details['company_id'];
					$employee_id =  $details['user_id'];
					$user_details = json_decode($details['user_details']);
					$profile = json_decode($details['profile']);
					$department = json_decode($details['department']);
					$designation = json_decode($details['designation']);
					$branch = json_decode($details['branch']);
					$grade = json_decode($details['grade']);
					$employee = json_decode($details['employee']);
					$salary = json_decode($details['salary']);
					$present_days = json_decode($details['present_day']);
					$absent_day = $details['absent_day'];
					$salary_day = $details['salary_day'];
					$paid_leave = $details['paid_leave'];
					$out_day = $details['out_day'];
					$week_off = $details['week_off'];
					$hols = $details['hols'];
					$loan_amount_left = $details['loan_amount_left'];
					$value_custom_subtractions = json_decode($details['value_custom_subtractions']);
					$value_custom_additions = json_decode($details['value_custom_additions']);
					$total_income_tax = $details['PAYE'];
					$NHF = $details['NHF'];
					$pension = $details['pension'];
					$day = $details['day'];
					$month = $details['month'];
					$year = $details['year'];
					$staff_fees = json_decode($details['staff_fees']);

				}
				

			} else {
				
				$detail = $this->generate_user_payroll($wages_type, $user_id);

				foreach($detail as $details){
					$company_id = $details['company_id'];
					$employee_id =  $details['user_id'];
					$user_details = json_decode($details['user_details']);
					$profile = json_decode($details['profile']);
					$department = json_decode($details['department']);
					$designation = json_decode($details['designation']);
					$branch = json_decode($details['branch']);
					$grade = json_decode($details['grade']);
					$employee = json_decode($details['employee']);
					$salary = json_decode($details['salary']);
					$present_days = json_decode($details['present_day']);
					$absent_day = $details['absent_day'];
					$salary_day = $details['salary_day'];
					$paid_leave = $details['paid_leave'];
					$out_day = $details['out_day'];
					$week_off = $details['week_off'];
					$hols = $details['hols'];
					$loan_amount_left = $details['loan_amount_left'];
					$value_custom_subtractions = json_decode($details['value_custom_subtractions']);
					$value_custom_additions = json_decode($details['value_custom_additions']);
					$total_income_tax = $details['PAYE'];
					$NHF = $details['NHF'];
					$pension = $details['pension'];
					$month = $details['month'];
					$year = $details['year'];
					$staff_fees = json_decode($details['staff_fees']);
				}
		}
    		$data = [
    			'user_details' => $user_details,
    			'profile' => $profile,
    			'grade' => $grade,
    			'department' => $department,
    			'branch' => $branch,
    			'designation' => $designation,
    			'employee' => $employee,
    			'salary' => $salary,
    			'present_days' => $present_days,
    			'holiday' => $hols,
				'absent_day' => $absent_day,
				'salary_day' => $salary_day,
				'paid_leave' => $paid_leave,
				'out_day' => $out_day,
				'week_off' => $week_off,
				'value_custom_subtractions' => $value_custom_subtractions,
				'value_custom_additions' => $value_custom_additions,
				'loan_amount_left' => $loan_amount_left,
				'PAYE' => $total_income_tax,
				'NHF' => $NHF,
				'pension' => $pension,
				'staff_fees' => $staff_fees
			];
			//  print_r($employee);

			 if($request->get('type') == "payslip"){

				return view('CorpHRM.Payroll.staff_payslip',$data);
				
			 }else{
				//  return $data;
				return view('CorpHRM.Payroll.staff_payroll_template',$data);

			 }
		
		}else{

			$result = array();
			$users_details = User::where(['company_id' =>  Auth::user()->company_id,'status' => "Active"])->get();
			foreach($users_details as $user_detail){
				$user_id = $user_detail->id;
				if($get_grade != "0" && $get_department == "0" ){
				$check = EmployeeProfile::where(['user_id' => $user_id, 'grade' => $get_grade])->get();
				}elseif($get_department != "0" && $get_grade == "0"){
					$check = EmployeeProfile::where(['user_id' => $user_id, 'department' => $get_department])->get();
				}elseif($get_grade != "0" && $get_department != "0"){
					$check = EmployeeProfile::where(['user_id' => $user_id, 'grade' => $get_grade, 'department' => $get_department])->get();
					}
				else{
					$check = EmployeeProfile::where(['user_id' => $user_id])->get();
				}
				//$check = EmployeeProfile::where(['user_id' => $user_id])->get();
				if(count($check) > 0){
				$user_id = $user_detail->id;
				$profile = EmployeeProfile::where(['user_id' => $user_id])->first();
				$salary = EmployeeSalary::where('employee_id', $profile['id'])->first();
				$wages_type = $salary['wages_type'];
				$check = payroll::where(['month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
				if(count($check) > 0){
					$detail = payroll::where(['month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
					foreach($detail as $details){
						$basic_salary = json_decode($details['grade']);
						$result[] = [
							'name' => $user_detail->name,
							'salary' => $basic_salary->basic_salary,
							'value_custom_subtractions' => json_decode($details['value_custom_subtractions']),
							'value_custom_additions' => json_decode($details['value_custom_additions']),
							'loan_amount_left' => $details['loan_amount_left'],
							'PAYE' => $details['PAYE'],
							'NHF' => $details['NHF'],
							'pension' => $details['pension'],
							'staff_fees' => json_decode($details['staff_fees'])
						];
					}
					
				}elseif($month != $current_month || $year != $current_year || $month != $current_month && $year != $current_year){

				$detail = $this->generate_user_payroll($wages_type, $user_detail->id);
				foreach($detail as $details){
					$basic_salary = json_decode($details['grade']);
					$result[] = [
						'name' => $user_detail->name,
						'salary' => $basic_salary->basic_salary,
						'value_custom_subtractions' => json_decode($details['value_custom_subtractions']),
						'value_custom_additions' => json_decode($details['value_custom_additions']),
						'loan_amount_left' => $details['loan_amount_left'],
						'PAYE' => $details['PAYE'],
						'NHF' => $details['NHF'],
						'pension' => $details['pension'],
						'staff_fees' => json_decode($details['staff_fees'])
					];
				}
			}
			}
			}
			$data = [
				'month' => $month,
				'year' => $year,
				'users' => $result
			];
			if(empty($result)){
				return view('CorpHRM.Payroll.payroll_unavaliable');
				// $pdf = PDF::loadView('CorpHRM.Payroll.payroll_unavaliable',[], [], ['format' => 'A4-L']);
				// return $pdf->stream('payroll.pdf');
			}else{
				// return $data;
				$pdf = PDF::loadView('CorpHRM.Payroll.staffs_payroll_template', $data, [], ['format' => 'A4-L']);
				return $pdf->stream('payroll.pdf');
			}
		}
	}


	private function taxable_income($total_annual_gross_income,$taxable_income){
		$Bal0 = "0";
		$BalA = "0";
		$BalB = "0";
		$BalC = "0";
		$BalD = "0";
		$BalE = "0";
		$BalF = "0";
		if($taxable_income < 300000){
			$Bal0 = (1/100) * $total_annual_gross_income;
		}
		if($taxable_income > 300000){
			$BalA = $taxable_income - 300000;
		}
		if($taxable_income > 600000){
			$BalB = $taxable_income - 600000;
		}
		if($taxable_income > 1100000){
			$BalC = $taxable_income - 1100000;
		}
		if($taxable_income > 1600000){
			$BalD = $taxable_income - 1100000;
		}
		if($taxable_income > 2200000){
			$BalE = $taxable_income - 1100000;
		}
		if($taxable_income > 5400000){
			$BalF = $taxable_income - 5400000;
		}
		$total_income_tax = $Bal0 + $BalA + $BalB + $BalC + $BalD + $BalE + $BalF;
		return $total_income_tax;
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


		
		public function generate_user_payroll($wages_type, $user_id){
			$day = date('d');
			$month = date('m');
            $year = date('y');
			$payee_type = payroll_payee_settings::where('company_id',Auth::user()->company_id)->first();
			$payee_type = $payee_type['name'];
			$staff_fees = StaffFees::where(['employee_id' => $user_id, 'month' => $month, 'year' => $year])->get();
			$user_details = User::where('id',$user_id)->first();
			$profile = EmployeeProfile::where('user_id', $user_id)->first();
			$branch = Branch::where('id',$profile['branch'])->first();
			$department = Department::where('id', $profile['department'])->first();
			$grade = Grade::where('id', $profile['grade'])->first();
			$designation = Designation::where('id', $profile['designation'])->first();
			$employee = Employee::where('employee_id', $profile['id'])->first();
			$salary = EmployeeSalary::where('employee_id', $profile['id'])->first();
			$attendances = Attendance::where(['user_id'=> $user_id, 'month' => $month, 'year' => $year])->first();
			$holidays = Holiday::where('company_id',Auth::user()->company_id)->get();
			$basic_salary = $grade['basic_salary'];
			//$allowances = Allowance::where(['company_id' => Auth::user()->company_id, 'assign_to_grade' => $grade['id']])->get();

			//$current_month = date('m');
			//$current_year = date('Y');
			$hols = 0;
			foreach($holidays as $holiday){
				$frm_time=strtotime($holiday->date_from);
				$frm_month=date("m",$time);
				$frm_year = date("Y", $time);
				$to_time=strtotime($holiday->date_to);
				$to_month=date("m",$time);
				$to_year = date("Y", $time);
				if($frm_year == $year || $to_year == $year){
					if($frm_month == $month || $to_month == $month){
						$hols = $hols + 1;
					}
				}
			}
			//return $attendances['dates'];
			$attendance_counts = explode(',', $attendances['datee']);
			$present_days = 0;
			foreach($attendance_counts as $attendance_count){
				// $time=strtotime($attendance_count);
				// $month=date("m",$time);
				// $year = date("Y", $time);
				// if($month == $month && $year == $year){
					$present_days = $present_days + 1;
				//}

			}
			$check = Weekoff::where('company_id',Auth::user()->company_id)->get();
			$total_days_in_current_month = date('t');
			$month = date('n'); // Month ID, 1 through to 12.
			$year = date('Y'); // Year in 4 digit 2009 format.
			$day = 0;
			if(count($check) > 0){
				$days_off = Weekoff::where('company_id',Auth::user()->company_id)->first();	
				$days = json_decode($days_off['days']);
				$check_saturday = array_search("Saturday", $days);
				$check_sunday = array_search("Sunday", $days);
				if($check_sunday == "1" && $check_saturday == "1"){

				//loop through all days
				for ($i = 1; $i <= $total_days_in_current_month; $i++) {
					
					$date = $year.'/'.$month.'/'.$i; //format date
					$get_name = date('l', strtotime($date)); //get week day
				// $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

					//if not a weekend add day to array
					if($get_name != 'Sunday' && $get_name != 'Saturday'){
						$day = $day + 1;
					}
				}
				
				}elseif($check_sunday == "1"){

					//loop through all days
					for ($i = 1; $i <= $total_days_in_current_month; $i++) {
						
						$date = $year.'/'.$month.'/'.$i; //format date
						$get_name = date('l', strtotime($date)); //get week day
					// $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

						//if not a weekend add day to array
						if($get_name != 'Sunday'){
							$day = $day + 1;
						}
					}

				}elseif($check_saturday == "1"){

					//loop through all days
					for ($i = 1; $i <= $total_days_in_current_month; $i++) {
						
						$date = $year.'/'.$month.'/'.$i; //format date
						$get_name = date('l', strtotime($date)); //get week day
					// $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

						//if not a weekend add day to array
						if($get_name != 'Saturday'){
							$day = $day + 1;
						}
					}
				}
				$total_working_days = $day;
			}else{

				//loop through all days
				for ($i = 1; $i <= $total_days_in_current_month; $i++) {
					
					$date = $year.'/'.$month.'/'.$i; //format date
					$get_name = date('l', strtotime($date)); //get week day
				// $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

					//if not a weekend add day to array
					if($get_name != 'Sunday' && $get_name != 'Saturday'){
						$day = $day + 1;
					}
				}
				$total_working_days = $day;
			}

			$absent_days = $total_working_days - $present_days;
			$paid_leave = "0";
			$out_day = "0";
			$week_off = "0";
			$salary_days = $present_days + $out_day + $week_off;

			
			$profile = EmployeeProfile::where('user_id', $user_id)->first();
			$grade = Grade::where('id', $profile['grade'])->first();
			$value_custom_additions = array();
			$value_custom_subtractions = array();
			$value_basic_additions = array();
			$value_basic_subtractions = array();
			$payee_custom_additions = 0;
			$payee_basic_additions = 0;
			$loan_amount_left = 0; 
			$payroll_custom_settings = payroll_custom_settings::where(['company_id' =>  Auth::user()->company_id, 'assign_to_grade' => $profile['grade']])->get();
			foreach($payroll_custom_settings as $payroll_custom_setting){
				$effective_month = $payroll_custom_setting->effective_month;
				if($payroll_custom_setting->addition == "1" && $payroll_custom_setting->wages_type == $wages_type || $payroll_custom_setting->wages_type == "" || $payroll_custom_setting->wages_type == null){
					if($payroll_custom_setting->frequency == "monthly"){
						if($month >= $effective_month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_additions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
					if($payroll_custom_setting->frequency == "halfyearly"){
						if($effective_month == $month || $effective_month + 5 == $month || $effective_month + 11 == $month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_additions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
					if($payroll_custom_setting->frequency == "quarterly"){
						if($effective_month == $month || $effective_month + 2 == $month || $effective_month + 5 == $month || $effective_month + 8 == $month || $effective_month + 11 == $month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_additions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
				}
				if($payroll_custom_setting->addition == "1" && $payroll_custom_setting->is_taxable == "1"){
					$percentage = $payroll_custom_setting->value;
					$value = ($percentage / 100) * $basic_salary;
					}else{
						$value = $payroll_custom_setting->value;
					}
					$payee_custom_additions = $payee_custom_additions + $value;


				}
				if($payroll_custom_setting->subtraction == "1" && $payroll_custom_setting->wages_type == $wages_type || $payroll_custom_setting->wages_type == "" || $payroll_custom_setting->wages_type == null){
					if($payroll_custom_setting->frequency == "monthly"){
						if($month >= $effective_month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_subtractions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
					if($payroll_custom_setting->frequency == "halfyearly"){
						if($effective_month == $month || $effective_month + 5 == $month || $effective_month + 11 == $month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_subtractions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
					if($payroll_custom_setting->frequency == "quarterly"){
						if($effective_month == $month || $effective_month + 2 == $month || $effective_month + 5 == $month || $effective_month + 8 == $month || $effective_month + 11 == $month){
							if($payroll_custom_setting->mode == "Percent"){
								$percentage = $payroll_custom_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_custom_setting->value;
								}
								$value_custom_subtractions[] = ['name' => $payroll_custom_setting->name, 'value' => $value, 'is_taxable' => $payroll_custom_setting->is_taxable];
						}
					}
				}

			

			//$salary = EmployeeSalary::where('id', $profile->id)->first();
			$pension = 0;
			$NHF = 0;
			$NHIS = 0;
			$CRA = 0;
			$PGI = 0;
			$tax_exempt = 0;
			$statutory_deductions = 0;
			$payee_basic_additions = 0;
			$basic_salary = $grade['basic_salary'];
			$payroll_basic_settings = payroll_basic_settings::
			where(['company_id' =>  Auth::user()->company_id, 'assign_to_grade' => NULL])
			->orwhere(['company_id' =>  Auth::user()->company_id, 'assign_to_grade' => ""])

			->get();
			foreach($payroll_basic_settings as $payroll_basic_setting){
				if($payroll_basic_setting->name == "Loan"){
					$loan_apps = LoanApplication::where('employee_id', $user_details['id'])->get();
					foreach($loan_apps as $loan_app){
						$loan_disbursment = LoanDisbursement::where(['loanapp_id' => $loan_app->id,'status' => "Approved"])->first();
						$loan_payments = LoanPayment::where(['loanapp_id' => $loan_app->id,'status' => "Approved"])->get();
						$payments_made  = 0;
						foreach($loan_payments as $loan_payment){

							$payments_made = $payments_made + $loan_payment->amount_paid;

						}
						$remainder = $loan_disbursment['disbursed_amount'] - $payments_made;
						if($remainder != "0"){

							$installment = $loan_disbursment['disbursed_amount'] / $loan_app->no_of_installments;

							if($remainder >= $installment){

								$loan_amount_left = $installment;

							}else{

								$loan_amount_left = $remainder;

							}
						}

						$outstanding = $loan_app->loan_amount - $loan_amount_left;
						$db = new LoanPayment();
						$db->company_id = Auth::user()->company_id;
						$db->transaction_id =  $this->generatetoken("6","hrm_loan_application","application_ref");
						$db->transaction_date = date('Y-m-d H:i:s');
						$db->employee_id = Auth::user()->id;
						$db->loanapp_id = $loan_app->id;
						$db->payment_mode = "Custom";
						$db->payment_type = "Salary";
						$db->amount_paid = $loan_amount_left;
						$db->outstanding_balance = $outstanding;
						$db->status = "Approved";
						//$db->nature = $request->nature;
						$db->save();
					}
				}
				if($payroll_basic_setting->name == "Cash Advance"){

					$cash_advances = CashAdvanceDisbursment::where('employee', $user_details->id)->get();
					foreach($cash_advances as $cash_advance){

					}
				}
				if($payroll_basic_setting->name == "Pension"){
					
					$pension = (8 / 100) * $basic_salary;
					
				}
				if($payroll_basic_setting->name == "NHF"){
										
					$NHF = (2.5 / 100) * $basic_salary;

				}
				if($payroll_basic_setting->name == "NHF"){
					
					$NHIS = ($payroll_basic_setting->value / 100) * $basic_salary;

				}
					
				$statutory_deductions = $pension + $NHF + $NHIS;
				$effective_month = $payroll_basic_setting->effective_month;
				if($payroll_basic_setting->addition == "1"){

					if($payroll_basic_setting->frequency == "monthly"){
						if($month >= $effective_month){
							if($payroll_basic_setting->mode == "Percent"){
								$percentage = $payroll_basic_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_basic_setting->value;
								}
								$value_basic_additions[] = ['name' => $payroll_basic_setting->name, 'value' => $value, 'is_taxable' => $payroll_basic_setting->is_taxable];
						}
					}
					if($payroll_basic_setting->frequency == "halfyearly"){
						if($effective_month == $month || $effective_month + 5 == $month || $effective_month + 11 == $month){
							if($payroll_basic_setting->mode == "Percent"){
								$percentage = $payroll_basic_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_basic_setting->value;
								}
								$value_basic_additions[] = ['name' => $payroll_basic_setting->name, 'value' => $value, 'is_taxable' => $payroll_basic_setting->is_taxable];
						}
					}
					if($payroll_basic_setting->frequency == "quarterly"){
						if($effective_month == $month || $effective_month + 2 == $month || $effective_month + 5 == $month || $effective_month + 8 == $month || $effective_month + 11 == $month){
							if($payroll_basic_setting->mode == "Percent"){
							$percentage = $payroll_basic_setting->value;
							$value = ($percentage / 100) * $basic_salary;
							}else{
								$value = $payroll_basic_setting->value;
							}
							$value_basic_additions[] = ['name' => $payroll_basic_setting->name, 'value' => $value, 'is_taxable' => $payroll_basic_setting->is_taxable];
						}
					}
				}

				if($payroll_basic_setting->addition == "1" && $payroll_basic_setting->is_taxable == "1" && $payroll_basic_setting->wages_type == $wages_type || $payroll_basic_setting->wages_type == "" || $payroll_basic_setting->wages_type == null){
					
					if($payroll_basic_setting->frequency == "monthly"){
						if($month >= $effective_month){
							if($payroll_basic_setting->mode == "Percent"){
								$percentage = $payroll_basic_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_basic_setting->value;
								}
								$payee_basic_additions = $payee_basic_additions + $payroll_basic_setting->value;
						}
					}elseif($payroll_basic_setting->frequency == "halfyearly"){
						if($effective_month == $month || $effective_month + 5 == $month || $effective_month + 11 == $month){
							if($payroll_basic_setting->mode == "Percent"){
								$percentage = $payroll_basic_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_basic_setting->value;
								}
								$payee_basic_additions = $payee_basic_additions + $payroll_basic_setting->value;
						}
					}elseif($payroll_basic_setting->frequency == "quarterly"){
						if($effective_month == $month || $effective_month + 2 == $month || $effective_month + 5 == $month || $effective_month + 8 == $month || $effective_month + 11 == $month){
							if($payroll_basic_setting->mode == "Percent"){
								$percentage = $payroll_basic_setting->value;
								$value = ($percentage / 100) * $basic_salary;
								}else{
									$value = $payroll_basic_setting->value;
								}
								$payee_basic_additions = $payee_basic_additions + $payroll_basic_setting->value;
						}
					}else{
						if($payroll_basic_setting->mode == "Percent"){
							$percentage = $payroll_basic_setting->value;
							$value = ($percentage / 100) * $basic_salary;
							}else{
								$value = $payroll_basic_setting->value;
							}
							$payee_basic_additions = $payee_basic_additions + $payroll_basic_setting->value;
					}
				}

			}
					
				// FOR YTD
					if($payee_type == "YTD"){

						// Calculating Gross
						$payroll_history = payroll::where(['year' => $year, 'employee_id' => $user_id])->get();
						$total_previous_allowance = 0;
						$total_previous_salary = 0;
						$total_previous_NHF = 0;
						$total_previous_NHIS = 0;
						$total_previous_pension = 0;
						$payee_deducted_sofar = 0;
						$payee_liable = 0;
						$year_count = 0;

						foreach($payroll_history as $p_h){
							$salary_history = json_decode($p_h->grade);
							$value_custom_additions = json_decode($p_h->value_custom_additions);
							$value_basic_additions = json_decode($p_h->value_basic_additions);
							$year_count = $year_count + 1;

							//foreach($salary_history as $salary_historyy){
								$total_previous_salary = $total_previous_salary + $salary_history->basic_salary;
							//}

							$total_previous_NHF = $total_previous_NHF + $p_h->NHF;

							$total_previous_NHIS = $total_previous_NHIS + $p_h->NHIS;

							$total_previous_pension = $total_previous_pension + $p_h->pension;

							$payee_deducted_sofar = $payee_deducted_sofar + $p_h->PAYE;

							foreach($value_custom_additions as $value_custom_addition){
								if($value_custom_addition->is_taxable == "1"){
									$total_previous_allowance = $total_previous_allowance + $value_custom_addition->value;
								}
							}
							$total_previous_basic_allowance = 0;
							foreach($value_basic_additions as $value_basic_addition){
								if($value_basic_addition->is_taxable == "1"){
									$total_previous_basic_allowance = $total_previous_basic_allowance + $value_basic_addition->value;
								}
							}

							$total_previous_allowance = $total_previous_allowance + $total_previous_basic_allowance;

						}
						if($year_count == "0"){
							$year_count = "1";
						}
						$yearly_gross = ($total_previous_salary / $year_count) * 12;
						$yearly_total_pension = ($total_previous_pension / $year_count) * 12;
						$payee_allowance = ($total_previous_allowance / $year_count) * 12;
						$yearly_total_NHF = ($total_previous_NHF / $year_count) * 12;
						$yearly_total_NHIS = ($total_previous_NHIS / $year_count) * 12;
						if($yearly_gross >= (20000+($yearly_gross*(20/100)))){
							$CRA = 20000+($yearly_gross*(20/100));
						}else{
								$CRA = $yearly_gross;
						}
						$total_relief = $yearly_total_pension + $yearly_total_NHF + $CRA + $yearly_total_NHIS;
						$total_annual_gross_income = $yearly_gross + $payee_allowance;
						$payee_gross_income = $yearly_gross + $payee_allowance;
						$taxable_income = $payee_gross_income - $total_relief;
						$minimum_tax = $yearly_gross*(1/100);
						$total_taxable_income = $this->taxable_income($total_annual_gross_income,$taxable_income);
						if($total_taxable_income > $minimum_tax){
							$payee_liable = $total_taxable_income;
						}else{
							$payee_liable = $minimum_tax;
						}

						$pro_paye_liable = $payee_liable / (12 * $year_count);

						$total_income_tax = $pro_paye_liable - $payee_deducted_sofar;
					}else{

						// ANNUALIZED
							if((1/100)* $basic_salary > 200000){
								$CRA = (1/100)* $basic_salary;
							}else{
								$CRA = "200000";
							}
							$allowances = 0;

							$allowances = $payee_custom_additions + $payee_basic_additions;
							$total_annual_gross_income = ($basic_salary + $allowances) * 12;	
							$PGI = (20/100) * $basic_salary;
							$total_reliefs = $CRA + $PGI;
							$total_consolidated_relief = $total_reliefs + $statutory_deductions;
							$taxable_income = $total_annual_gross_income - $total_consolidated_relief;

							$total_income_tax = $this->taxable_income($total_annual_gross_income,$taxable_income);
						}
			//$pdf = PDF::loadView('CorpHRM.Payroll.staff_payroll_template', [], [], ['format' => 'A4-L']);
			//return $pdf->stream('payroll.pdf');
			$user_detailss = [
				'id' => $user_details['id'],
				'name' => $user_details['name'],
				'email' => $user_details['email'],
				'phone' => $user_details['phone'],
				'pic' => $user_details['pic'],
				'address' => $user_details['address']
			];

			$profiles = [
				'id' => $profile['id'],
				'surname' => $profile['surname'],
				'middlename' => $profile['middlename'],
				'firstname' => $profile['firstname'],
				'title' => $profile['title'],
				'employee_code' => $profile['employee_code'],
				'join_date' => $profile['join_date']
			];

			$employees = [
				'residential_address' => $employee['residential_address'],
				'permanent_address' => $employee['permanent_address'],
				'telephone_no' => $employee['telephone_no'],
				'mobile_no' => $employee['mobile_no'],
				'personal_email_address' => $employee['personal_email_address'],
				'date_of_birth' => $employee['date_of_birth'],
				'official_email_address' => $employee['official_email_address'],
				'nationality' => $employee['nationality'],
				'city' => $employee['city'],
				'country_address' => $employee['country_address']
			];
			if($wages_type == "daily" || $wages_type == "Daily" || $wages_type == "d" || $wages_type == "D"){
 
				$total_income_tax = "0";
				$NHF = "0";
				$pension = "0";
				$NHIS = "0";
			}
			
			$this->save_payroll($user_details['id'], $user_detailss, $profiles, $grade, $department, $designation, $branch, $employees, $present_days, $absent_days, $salary_days, $paid_leave, $out_day, $week_off, $salary, $hols, $value_custom_subtractions, $value_custom_additions,$value_basic_subtractions, $value_basic_additions, $loan_amount_left, $total_income_tax, $NHF, $pension, $NHIS, $month, $year, $staff_fees);
		
		
			$detail = payroll::where(['month' => $month, 'year' => $year, 'employee_id' => $user_id])->get();
			return $detail;
		}
		public function save_payroll($user_id, $user_details, $profile, $grade, $department, $designation, $branch, $employee, $present_day, $absent_day, $salary_day, $paid_leave, $out_day, $week_off, $salary, $hols, $value_custom_subtractions, $value_custom_additions,$value_basic_subtractions, $value_basic_additions, $loan_amount_left, $total_income_tax, $NHF, $pension, $NHIS, $month, $year, $staff_fees)
		{
			$company_id = Auth::user()->company_id;

			$db = new payroll();
			$db->company_id = $company_id;
			$db->employee_id =  $user_id;
			$db->user_details = json_encode($user_details);
			$db->profile = json_encode($profile);
			$db->department = json_encode($department);
			$db->designation = json_encode($designation);
			$db->branch = json_encode($branch);
			$db->grade = json_encode($grade);
			$db->employee = json_encode($employee);
			$db->salary = json_encode($salary);
			$db->present_day = json_encode($present_day);
			$db->hols = $hols;
			$db->absent_day = $absent_day;
			$db->salary_day = $salary_day;
			$db->paid_leave = $paid_leave;
			$db->out_day = $out_day;
			$db->week_off = $week_off;
			$db->loan_amount_left = $loan_amount_left;
			$db->value_custom_subtractions = json_encode($value_custom_subtractions);
			$db->value_custom_additions = json_encode($value_custom_additions);
			$db->value_basic_subtractions = json_encode($value_basic_subtractions);
			$db->value_basic_additions = json_encode($value_basic_additions);
			$db->staff_fees = json_encode($staff_fees);
			$db->PAYE = $total_income_tax;
			$db->NHF = $NHF;
			$db->pension = $pension;
			$db->NHIS = $NHIS;
			$db->day = date('d');
			$db->month = $month;
			$db->year = $year;
			$db->save();
		}












	public function showSalary()
	{
		$salaries = null;
			return view('CorpHRM.Payroll.payroll_salary',compact('salaries'));
	}


	public function findSalary(Request $req,$month = null,$year = null)
	{



   //get compnay id 
   $company_id = Auth::user()->company_id;
   //   return $company_id;
	 // get employees
	 $employees = Employee::where('company_id',$company_id)->get();
	 // set var result to hold array
	 $result = [];
	 //loop thru emmployee
	 foreach ($employees as $key => $employee) {
		 $found = [$employee->employee_id,];
		 //push found to var=result 
		 array_push($result, $found);
	 }
	 
 
	 //return $result;
 
	 // find staffs based on the results of employeee
	 $data = StaffFees::where('company_id',$company_id)
						 ->where('month',$req->month)
						 ->where('year',$req->year)
					   //   ->with('employee','employee.profile')
						 ->find($result);


	if(!$data){
		return redirect()->back()->with('success', 'No entry found!');
	}


   // return $data;

   $salary = [];

   foreach($result as $key){

	   $data1 = StaffFees::where('company_id',$company_id)
						 ->where('employee_id',$key[0])
						 ->where('month',$req->month)
						 ->with('employee','employee.profile')
						 ->where('year',$req->year)
						 ->get();
   
						 

	   $add = [];
	   $sub = [];
	   $id = [];
	   
	   
	   foreach($data1 as $value){
		   
		array_push($id,$value->employee_id);
		   if($value->addition == 1){
			   array_push($add,$value->amount);
			}else{
				array_push($sub,$value->amount);
			}
			
		   $netpay = array_sum($add) - array_sum($sub);
		   $bank = EmployeeSalary::where('employee_id',$value->employee->employee_id)->first();

		   $bankName = null;
		   $bankAcc = null;

		   if($bank){
			   $bankName = $bank->bank_name;
			   $bankAcc = $bank->bank_acc_no;
		   
		   }

		//    if($value->addition == 1){
		// 	$fields = [
		// 		'company_id' => $company_id,
		// 		'employee_id' => $value->employee_id,
		// 		'bank_name' => $bankName,
		// 		'bank_acc' => $bankAcc,
		// 		'addition' => $value->addition,
		// 		'gross_pay' => array_sum($add),
		// 		'sub_pay' => array_sum($sub),
		// 		'net_pay' => $netpay,
		// 	];
		// 	array_push($salary,array_unique($fields));
		//    }
			 

	   
		   

	   


	   }


	//    print_r($id);
	   if (count($id) > 1) {
		$fields = array(
			'staff_id' => $value->id,
			'company_id' => $company_id,
			'employee_id' => $value->employee_id,
			'bank_name' => $bankName,
			'bank_acc' => $bankAcc,
			'addition' => $value->addition,
			'gross_pay' => array_sum($add),
			'sub_pay' => array_sum($sub),
			'net_pay' => $netpay,
		);
		
		array_push($salary,$fields);
	   }

	   
	   
	   
	   
	   
   }

	//    return $salary;
   

   $salaries = [];

   foreach($salary  as  $s){
		//    return $s['company_id'];

	   $sal = new Salary;
	   $sal->staff_id = $s['staff_id'];
	   $sal->company_id = $s['company_id'];
	   $sal->employee_id = $s['employee_id'];
	   $sal->gross_pay = $s['gross_pay'];
	   $sal->net_pay = $s['net_pay'];
	   $sal->bank_name = $s['bank_name'];
	   $sal->bank_acc = $s['bank_acc'];
	//    $sal->save();


	   array_push($salaries,$sal);

   }
   
//    return $salaries;





   return view('CorpHRM.Payroll.payroll_salary',compact('salaries'));



	}


	public function saveSalary(Request $request)
	{
		
		

		// return $request->data;
		$salary = $request->data;
		$date = Carbon::now();

		 
		foreach($salary  as  $s){

	
		
		   $sal = new Salary;
		   $sal->company_id = $s['company_id'];
		   $sal->employee_id = $s['employee_id'];
		   $sal->gross_pay = $s['gross_pay'];
		   $sal->net_pay = $s['net_pay'];
		   $sal->bank_name = $s['bank_name'];
		   $sal->bank_acc = $s['bank_acc'];
		   $sal->save();
	
		   $trans = [
			title => 'salary_'.$s['net_pay'],
			transaction_category_id => 42,
			transaction_type_id => 93,
			transaction_date => $date,
			transaction_partner_id =>  $s['employee_id'],
			amount => $s['net_pay']
		   ];

		   $this->add_entry($trans);
	
	   }
	   




	   return 'succesfully';
	}
	


	public function add_entry(Request $request)
    {
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
               
                self::save_entry($data);
            }
        }else{
            return self::save_entry($data);
        }
    }
		


}