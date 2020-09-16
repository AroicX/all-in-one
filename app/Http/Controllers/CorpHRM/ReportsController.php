<?php
namespace App\Http\Controllers\CorpHRM;

use App\Traits\SubscriptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Employee;
use App\Models\User;
use DB;
use PDF;
use Excel;
use App\Company;
use App\Models\CorpHRM\claims\ClaimMaster;
use App\Models\CorpHRM\claims\ClaimApplication;
use App\Models\CorpHRM\loan\LoanMaster;
use App\Models\CorpHRM\loan\LoanApplication;
use App\Models\CorpHRM\loan\LoanDisbursement;
use App\Models\CorpHRM\loan\LoanPayment;
use App\Models\CorpHRM\leave\leavemaster;
use App\Models\CorpHRM\leave\leaveapplication;
use App\Models\CorpHRM\CashAdvance\CashAdvanceAdvance;
use App\Models\CorpHRM\CashAdvance\CashAdvanceDisbursment;
use App\Models\CorpHRM\CashAdvance\CashAdvanceRetirement;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\InternalRevenue;
use App\Models\CorpHRM\payroll\payroll;

class ReportsController extends Controller
{


    public function claims(Request $request){
        $branch = $request->get('branch');
        $month = $request->get('month');
        $year = $request->get('year');
        $format = $request->get('format');
        if($format == "PDF"){
            $this->Claims_pdf($branch, $month, $year);
        }else{
            $this->Claims_Excel($branch, $month, $year);
        }
    }
    /**
    *Claims Excel
    */
    public function  Claims_Excel($branch, $month, $year){
        
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('claims-report ('+$month+' '+$year+')', function($excel) use ($month, $year,$branch,$company_id,$result){
            // Set the title
            $excel->setTitle('Claims Report From '+$month+', '+$year+'');
            $excel->sheet('list', function($sheet) use ($month, $year,$branch,$company_id,$result){
                $data = ClaimApplication::where(['company_id'=> $company_id,'status' => "2"])
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)->get();
                $sn = 0;
                foreach ($data as $d){
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
                    if($checkbranch['branch'] == $branch){
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Transcation Code' => $d->transaction_id,
                        'Employee Name' => $user['name'],
                        'Transaction Date' => $d->transaction_date,
                        'Expense Name' => $d->expense_type,
                        'Amount' => $d->amount,
                        'Purpose' => $d->purpose,
                        'Disubursment Date' => $d->updated_at
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }
    
    /**
    *Claims PDF
    */
    public function Claims_pdf($branch, $month, $year){
        
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $data = ClaimApplication::where(['company_id'=> $company_id,'status' => "2"])
        ->whereMonth('created_at', '=', $month)
        ->whereYear('created_at', '=', $year)
        ->get();
        $sn = 0;
        foreach ($data as $d){
            $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
            if($checkbranch['branch'] == $branch){
                $user = User::where('id',$d->employee_id)->first();
                $sn = $sn + 1;
                $result[] = [
                'SN' => $sn,
                'Transcation_Code' => $d->transaction_id,
                'Employee_Name' => $user['name'],
                'Transaction_Date' => $d->transaction_date,
                'Expense_Name' => $d->expense_type,
                'Amount' => $d->amount,
                'Purpose' => $d->purpose,
                'Disubursment_Date' => $d->updated_at
                ];
            }
        }
        $pdf = PDF::loadView('CorpHRM.reports.pdf.claims', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'month' => $month, 'year' => $year], [], ['format' => 'A4-L']);
        return $pdf->stream('claims-report ('+$month+' '+$year+').pdf');
    }


    public function loans(Request $request){
        $branch = $request->get('branch');
        $month = $request->get('month');
        $year = $request->get('year');
        $format = $request->get('format');
        if($format == "PDF"){
            $this->loans_pdf($branch, $month, $year);
        }else{
            $this->loans_excel($branch, $month, $year);
        }
    }

    /**
    *Loans Excel
    */

    public function loans_excel($branch,$month,$year){
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('claims-report ('+$month+' '+$year+')', function($excel) use ($month, $year,$branch,$company_id,$result){
            // Set the title
            $excel->setTitle('Claims Report From '+$month+', '+$year+'');
            $excel->sheet('list', function($sheet) use ($month, $year,$branch,$company_id,$result){
                $loanapps = LoanApplication::where(['company_id'=> $company_id,'status' => "Disbursed"])
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)->get();
                $sn = 0;
                foreach ($loanapps as $d){
                    $loan_disbursment = LoanDisbursement::where('loanapp_id',$d->id)->first();
                    $loan_payments = LoanPayment::where('loanapp_id',$d->id)->get();
                    $loanmaster = LoanMaster::where('id',$d->loanmaster_id)->first();
                    $amount_paid = 0;
                    foreach($loan_payments as $loan_payment){
                        $amount_paid = $amount_paid + $loan_payment->amount_paid;
                    }

                    if($amount_paid >= $loan_disbursment['disbursed_amount']){
                        $pay_back_status = "Complete";
                        $pay_back = "0";
                    }else{
                        $pay_back_status = "Incomplete";
                        $pay_back = $amount_paid;
                    }
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
                    if($checkbranch['branch'] == $branch){
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Transcation Code' => $d->application_ref,
                        'Employee Name' => $user['name'],
                        'Loan Type' => $loanmaster['name'],
                        'Application Date' => $d->created_at,
                        'Approved Date' => $d->updated_at,
                        'Approved Amount' => $d->loan_amount,
                        'Disbursed Amount' => $loan_disbursment['disbursed_amount'],
                        'Disbursed Date' => $loan_disbursment['created_at']
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }

    /**
    *Loans PDF
    */

    public function loans_pdf($branch,$month,$year){
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $loanapps = LoanApplication::where(['company_id'=> $company_id,'status' => "Disbursed"])
        ->whereMonth('created_at', '=', $month)
        ->whereYear('created_at', '=', $year)->get();
        $sn = 0;
        foreach ($loanapps as $d){
            $loan_disbursment = LoanDisbursement::where('loanapp_id',$d->id)->first();
            $loan_payments = LoanPayment::where('loanapp_id',$d->id)->get();
            $loanmaster = LoanMaster::where('id',$d->loanmaster_id)->first();
            $amount_paid = 0;
            foreach($loan_payments as $loan_payment){
                $amount_paid = $amount_paid + $loan_payment->amount_paid;
            }
            if($amount_paid >= $loan_disbursment['disbursed_amount']){
                $pay_back_status = "Complete";
                $pay_back = "0";
            }else{
                $pay_back_status = "Incomplete";
                $pay_back = $amount_paid;
            }
            $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
            if($checkbranch['branch'] == $branch){
                $user = User::where('id',$d->employee_id)->first();
                $user_approved = User::where('id',$d->approved_by)->first();
                $sn = $sn + 1;
                $result[] = [
                    'S/N' => $sn,
                    'Transcation_Code' => $d->application_ref,
                    'Employee_Name' => $user['name'],
                    'Loan_Type' => $loanmaster['name'],
                    'Application_Date' => $d->created_at,
                    'Approved_Date' => $d->updated_at,
                    'Approved_Amount' => $d->loan_amount,
                    'Approved_By' => $user_approved['name'],
                    'Disbursed_Amount' => $loan_disbursment['disbursed_amount'],
                    'Disbursed_Date' => $loan_disbursment['created_at']
                ];
            }
        }
        $pdf = PDF::loadView('CorpHRM.reports.pdf.loans', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'month' => $month, 'year' => $year], [], ['format' => 'A4-L']);
        return $pdf->stream('loans-report ('+$month+' '+$year+').pdf');
    }


    public function leaves(Request $request){
        $branch = $request->get('branch');
        $month = $request->get('month');
        $year = $request->get('year');
        $format = $request->get('format');
        $leave_type = $request->get('type');
        if($format == "PDF"){
            $this->leaves_pdf($branch, $month, $year,$leave_type);
        }else{
            $this->leaves_excel($branch, $month, $year,$leave_type);
        }
    }

    /**
    *Leave Excel
    */

    public function leaves_excel($branch,$month,$year,$leave_type){
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $leave_master = leavemaster::where('id',$leave_type)->first();
        Excel::create('Leave-report ('+$month+' '+$year+')', function($excel) use ($month, $year,$branch,$company_id,$leave_type,$result){
            // Set the title
            $excel->setTitle('Leaves Report '+$month+', '+$year+'');
            $excel->sheet('list', function($sheet) use ($month, $year,$branch,$company_id,$leave_type,$result){
                $data = leaveapplication::where(['company_id'=> $company_id,'leave_master_id' => $leave_type, 'status' => "Approved"])
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)->get();
                $sn = 0;
                foreach ($data as $d){
                    $start_date= $d->start_date;
                    $end_date = $d->end_date;
                    $today = date('Y-m-d');
                    $days_used = $diff=date_diff($start_date,$today);
                    $days_used = $days_used->format("%R%a days");
                    $days_left = $diff=date_diff($today,$end_date);
                    $days_left = $days_left->format("%R%a days");
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
                    if($checkbranch['branch'] == $branch){
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Employee Code' => $checkbranch['employee_code'],
                        'Employee Name' => $user['name'],
                        'Leave Days' => $d->no_of_days,
                        'Days Used' => $days_used,
                        'Days Remaining' => $days_left,
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }

    /**
    *Leaves PDF
    */

    public function leaves_pdf($branch,$month,$year,$leave_type){
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $leave_master = leavemaster::where('id',$leave_type)->first();
        $data = leaveapplication::where(['company_id'=> $company_id,'leave_master_id' => $leave_type, 'status' => "Approved"])
        ->whereMonth('created_at', '=', $month)
        ->whereYear('created_at', '=', $year)->get();

        

        // if(count($data) <= 0){
        //     return redirect()->back();
            
        // }



        $sn = 0;
        foreach ($data as $d){
            $start_date= $d->start_date;
            $end_date = $d->end_date;
            $today = date('Y-m-d');
            $days_used = $diff=date_diff($start_date,$today);
            $days_used = $days_used->format("%R%a days");
            $days_left = $diff=date_diff($today,$end_date);
            $days_left = $days_left->format("%R%a days");
            $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
            if($checkbranch['branch'] == $branch){
                $user = User::where('id',$d->employee_id)->first();
                $sn = $sn + 1;
                $result[] = [
                'S/N' => $sn,
                'Employee_Code' => $checkbranch['employee_code'],
                'Employee_Name' => $user['name'],
                'Leave_Days' => $d->no_of_days,
                'Days_Used' => $days_used,
                'Days_Remaining' => $days_left,
                ];
            }
        }
        $pdf = PDF::loadView('CorpHRM.reports.pdf.leaves', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'leave_type' => $leave_master['name'],'month' => $month, 'year' => $year], [], ['format' => 'A4-L']);
        return $pdf->stream('leaves-report ('+$month+' '+$year+').pdf');
    }


    public function CashAdvance(Request $request){
        $branch = $request->get('branch');
        $month = $request->get('month');
        $year = $request->get('year');
        $format = $request->get('format');
        if($format == "PDF"){
            $this->CashAdvance_pdf($branch, $month, $year);
        }else{
            $this->CashAdvance_excel($branch, $month, $year);
        }
    }

    /**
    *Cash Advance Excel
    */

    public function CashAdvance_excel($branch,$month,$year){
        $result = array();
        // CashAdvanceRetirement
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('CashAdvance-report ('+$month+' '+$year+')', function($excel) use ($month, $year,$branch,$company_id,$result){
            // Set the title
            $excel->setTitle('CashAdvance Report From '+$month+', '+$year+'');
            $excel->sheet('list', function($sheet) use ($month, $year,$branch,$company_id,$result){
                $data = CashAdvanceAdvance::where(['company_id'=> $company_id, 'status' => "Approved"])
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)->get();
                $sn = 0;
                foreach ($data as $d){
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
                    if($checkbranch['branch'] == $branch){
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Transaction Code' => $checkbranch['employee_code'],
                        'Employee Name' => $user['name'],
                        'Advance Amount' => $d->no_of_days,
                        'Aplication Date' => $d->expense_type,
                        'Purpose' => $d->amount,
                        'Amount Retired' => $d->amount,
                        'Date Retired' => $d->amount,
                        'Outstanding' => $d->amount,
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }

    /**
    *Cash Advance Pdf
    */

    public function CashAdvance_pdf($branch,$month,$year){

    }


    public function ActiveEmployees(Request $request){
        $branch = $request->get('branch');
        $format = $request->get('format');

        // return response()->json($format);
        if($format == "PDF"){
            $this->ActiveEmployee_pdf($branch);
        }else{
            $this->ActiveEmployee_excel($branch);
        }
    }


    /**
    *Active Employee Excel
    */

    public function ActiveEmployee_excel($branch){

        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('Active Employees', function($excel) use ($branch,$company_id,$result){
            // Set the title
            $excel->setTitle('Active Employees');
            $excel->sheet('list', function($sheet) use ($branch,$company_id,$result){
                $data = User::where(['company_id'=> $company_id, 'status' => "Active"])->get();
                $sn = 0;
                foreach ($data as $d){
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->id])->first();
                    if($checkbranch['branch'] == $branch){
                        $user = User::where('id',$d->id)->first();
                        $department = Department::where('id',$checkbranch['department'])->first();
                        $designation = Designation::where('id',$checkbranch['designation'])->first();
                        $grade = Grade::where('id',$checkbranch['grade'])->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Employee Code' => $checkbranch['employee_code'],
                        'Employee Name' => $user['name'],
                        'Department' => $department['name'],
                        'Designation' => $designation['name'],
                        'Grade' => $grade['name'],
                        'Branch' => $branch['name'],
                        'Reporting manager' => "",
                        'Date of Joining' => $checkbranch['join_date'],
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }

    /**
    *Active Employee Pdf
    */

    public function ActiveEmployee_pdf($branch){
        // return response()->json($branch);
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $data = User::where(['company_id'=> $company_id, 'status' => "Active"])->get();
        $sn = 0;
        foreach ($data as $d){
            $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->id])->first();
            if($checkbranch['branch'] == $branch){
                $user = User::where('id',$d->id)->first();
                $department = Department::where('id',$checkbranch['department'])->first();
                $designation = Designation::where('id',$checkbranch['designation'])->first();
                $grade = Grade::where('id',$checkbranch['grade'])->first();
                $sn = $sn + 1;
                $result[] = [
                'S/N' => $sn,
                'Employee_Code' => $checkbranch['employee_code'],
                'Employee_Name' => $user['name'],
                'Department' => $department['name'],
                'Designation' => $designation['name'],
                'Grade' => $grade['name'],
                'Branch' => $branch['name'],
                'Reporting_Manager' => "",
                'Date_of_Joining' => date_format('Y-m-d', $checkbranch['join_date']),
                ];
            }
        }
        $month = date('m');
        $year = date('Y');
        $pdf = PDF::loadView('CorpHRM.reports.pdf.ActiveEmployees', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'month' => $month, 'year' => $year], [], ['format' => 'A4-L']);
        return $pdf->stream('Active Employees.pdf');
    }

    public function PAYE(Request $request){
        $branch = $request->get('branch');
        $month = $request->get('month');
        $year = $request->get('year');
        $sirb = $request->get('sirb');
        $format = $request->get('format');
        if($format == "PDF"){
           return $this->paye_pdf($branch,$month,$year,$sirb);
        }else{
            $this->paye_excel($branch,$month,$year,$sirb);
        }
    }
    /**
    *Paye Excel
    */

    public function paye_excel($branch,$month,$year,$sirb){
        $result = array();
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('PAYE Report', function($excel) use ($month, $year, $branch, $sirb,$company_id,$result){
            // Set the title
            $excel->setTitle('Paye Report for');
            $excel->sheet('list', function($sheet) use ($month, $year, $branch, $sirb,$company_id,$result){
                $data = payroll::where(['company_id'=> $company_id, 'month' => $month, 'year' => $year])->get();
                $sirb_details = InternalRevenue::where('id',$sirb)->first();
                $sn = 0;
                foreach ($data as $d){
                    $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
                    $employee = Employee::where('employee_id',$checkbranch['id'])->first();
                    if($checkbranch['branch'] == $branch && $employee['sbirs'] == $sirb){
                        $grade = json_decode($d->grade,true);
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'SN' => $sn,
                        'Employee Name' => $user['name'],
                        'Gross Salary' => $grade['basic_salary'],
                        'PAYE Amount' => $d->PAYE,
                        ];
                    }
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');
    }

    /**
    *Paye Pdf
    */

    public function paye_pdf($branch,$month,$year,$sirb){

        // return $branch;
        
        
        $result = [];
        $company_id = Auth::user()->company_id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        $data = payroll::where(['company_id'=> $company_id, 'month' => $month, 'year' => $year])->get();
        // return dd($data);
        $sirb_details = InternalRevenue::where('id',$sirb)->first();
        $sn = 0;
        foreach ($data as $d){
            $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $d->employee_id])->first();
             $employee = Employee::where('employee_id',$checkbranch['id'])->first();
            if(intval($checkbranch['branch']) == intval($branch->id) && intval($employee['sbirs']) == intval($sirb)){
            //    return '123';
                $grade = json_decode($d->grade,true);
                
                $user = User::where('id',$d->employee_id)->first();
                $sn = $sn + 1;
                $rs = [
                    'SN' => $sn,
                    'Employee_Name' => $user['name'],
                    'Gross_Salary' => $grade['basic_salary'],
                    'PAYE_Amount' => $d->PAYE,
                ];

                array_push($result,$rs);
            }
        }

       
        
        // return $result;

        return view('CorpHRM.reports.pdf.Paye', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'SIRB' => $sirb_details['name'], 'month' => $month, 'year' => $year]);
        // $pdf = PDF::loadView('CorpHRM.reports.pdf.Paye', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'SIRB' => $sirb_details['name'], 'month' => $month, 'year' => $year]);
        // return $pdf->stream('Active-Employees.pdf');
    }

    /**
    *Loan Repayment Excel
    */

    public function LoanRepayment_excel($loan_id){

        $result = array();
        $company_id = Auth::user()->company_id;
        $user_id =  Auth::user()->id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first();
        Excel::create('LoanRepayment Report.', function($excel) use ($loan_id,$company_id,$result){
            // Set the title
            $excel->setTitle('LoanRepayment Report.');
            $excel->sheet('list', function($sheet) use ($loan_id,$company_id,$result){
                $loan_app = LoanApplication::where(['company_id'=> $company_id, 'id' => $loan_id])->get();
                $loan_payment = LoanPayment::where(['company_id'=> $company_id, 'loanapp_id' => $loan_id])->get();
                $loan_disbursment = LoanDisbursement::where(['company_id'=> $company_id, 'loanapp_id' => $loan_id])->get();
                $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $loan_app['employee_id']])->first();
                $branch = Branch::where('id',$checkbranch['branch'])->first();
                $sn = 0;
                foreach ($loan_payment as $d){
                        $user = User::where('id',$d->employee_id)->first();
                        $sn = $sn + 1;
                        $result[] = [
                        'S/N' => $sn,
                        'Installment' => $loan_app['no_of_installments'],
                        'Balance' => $d->outstanding_balance,
                        'Payment' => $d->amount_paid
                        ];
                }
                $sheet->fromArray($result);

            });
        })->download('xlsx');

    }

    /**
    *Loan Repayment Pdf
    */

    public function LoanRepayment_pdf(){
        $result = array();
        $company_id = Auth::user()->company_id;
        $user_id =  Auth::user()->id;
        $branch = Branch::where('id',$branch)->first();
        $company = Company::where('id',$company_id)->first(); 
        $loan_app = LoanApplication::where(['company_id'=> $company_id, 'id' => $loan_id])->first();
        $loanmaster = LoanMaster::where('id',$loan_app['loanmaster_id'])->first();
        $loan_payment = LoanPayment::where(['company_id'=> $company_id, 'loanapp_id' => $loan_id])->get();
        $loan_disbursment = LoanDisbursement::where(['company_id'=> $company_id, 'loanapp_id' => $loan_id])->get();
        $checkbranch = EmployeeProfile::where(['company_id' => $company_id,'user_id' => $loan_app['employee_id']])->first();
        $branch = Branch::where('id',$checkbranch['branch'])->first();
        $sn = 0;
        foreach ($loan_payment as $d){
                $user = User::where('id',$d->employee_id)->first();
                $sn = $sn + 1;
                $result[] = [
                'Installment' => $sn,
                'Balance' => $d->outstanding_balance,
                'Payment' => $d->amount_paid
                ];
        }
        $pdf = PDF::loadView('CorpHRM.reports.pdf.LoanRepayment', ['result' => $result,'branch' => $branch['name'],'company' => $company['name'],'loan_type' => $loanmaster['name'],'Installment' => $loan_app['no_of_installments']]);
        return $pdf->stream('Loan-Repayment.pdf');
    }

}
