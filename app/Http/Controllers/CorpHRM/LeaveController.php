<?php

namespace App\Http\Controllers\CorpHRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\leave\leavemaster;
use App\Models\CorpHRM\leave\leaveapplication;
use App\Models\CorpHRM\leave\leavecredit;
use App\Models\CorpHRM\leave\leaveallowance;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Branch;
use App\User;
use DB;


class LeaveController extends Controller
{
//    use SubscriptionTrait;
    /**
     * Display the loan master page
     *
     * @return type
     */
    public function getLeaveMaster()
    {
        if (Auth::check()) {

            $grades = Grade::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.leave.leaveMaster',['grades' => $grades]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function EditLeaveMaster($id)
    {
        if (Auth::check()) {

            $grades = Grade::where('company_id',Auth::user()->company_id)->get();
            $LeavesMaster = leavemaster::where(['company_id' => Auth::user()->company_id, 'id' => $id])->first();
            return view('CorpHRM.leave.leaveMaster_edit',['grades' => $grades,'leavemaster' => $LeavesMaster]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function listLeaveMaster()
    {
        if (Auth::check()) {
            $LeavesMaster = leavemaster::where('company_id',Auth::user()->company_id)->get();
            $result = array();
            foreach($LeavesMaster as $LeaveMaster){
                $grade = Grade::where('id',$LeaveMaster->grade_id)->first();

                $result[] = [
                'id' => $LeaveMaster->id,
                'name' => $LeaveMaster->name,
                'code' => $LeaveMaster->code,
                'max_days' => $LeaveMaster->max_days,
                'paid_leave' => $LeaveMaster->paid_leave,
                'grade' => $grade['name'],
                'encashable' => $LeaveMaster->encashable,
                'carry_forward' => $LeaveMaster->carry_forward,
                'notice_period' => $LeaveMaster->notice_period
                ];
            }
            return view('CorpHRM.leave.listleaveMaster',['LeavesMaster' => $result]);
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

    public function postLeaveMaster(Request $request){
    if (Auth::check())
    {   
        // $check = leavemaster::where(['grade_id' => $request->grade_id, 'company_id' => Auth::user()->company_id])->first();
        // if($check){
        //     return redirect('corphrm/leavemaster/new')->with('error', 'Grade already registerd for leave!');
        // }else{
            $leaveMaster = new leavemaster();
            $leaveMaster->notice_period = $request->notice_period;
            $leaveMaster->carry_forward = $request->carry_forward;
            $leaveMaster->encashable = $request->encashable;
            $leaveMaster->no_of_days_after_joining = $request->no_of_days_after_joining;
            $leaveMaster->paid_leave = $request->paid_leave;
            $leaveMaster->max_days = $request->max_days;
            $leaveMaster->grade_id = $request->grade_id;
            $leaveMaster->code = $request->code;
            $leaveMaster->name = $request->name;
            $leaveMaster->company_id = Auth::user()->company_id;
            $leaveMaster->save();
            $success = true;
        //}
       // return view('CorpHRM.leave.leaveMaster',  compact('success'));
        return redirect()->back()->with('success', 'successfully submitted!');

    }
        else
        {
            return Redirect::intended('login');
        }
    }


    public function UpdateLeaveMaster(Request $request){
        if (Auth::check())
        {   
            // $check = leavemaster::where(['grade_id' => $request->grade_id, 'company_id' => Auth::user()->company_id])->first();
            // if(count($check) > 1){
            //     return redirect()->back()->with('error', 'Grade already registerd for leave!');
            // }else{
               leavemaster::where('id',$request->id)->update([
                'notice_period' => $request->notice_period,
                'carry_forward' => $request->carry_forward,
                'encashable' => $request->encashable,
                'no_of_days_after_joining' => $request->no_of_days_after_joining,
                'paid_leave' => $request->paid_leave,
                'max_days' => $request->max_days,
                'grade_id' => $request->grade_id,
                'code' => $request->code,
                'name' => $request->name,
                ]);
                $success = true;
            //}
           // return view('CorpHRM.leave.leaveMaster',  compact('success'));
            return redirect()->back()->with('success', 'successfully Updated!');
    
        }
            else
            {
                return Redirect::intended('login');
            }
        }
    
    public function getLeaveApplication()
    {
        if (Auth::check()) {

        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $users = User::where('company_id',$company_id)
                    ->where('id','!=',$user_id)->get();
        $EmployeeProfile = EmployeeProfile::where('user_id',$user_id)->first();
        $leavemaster = Leavemaster::where(['company_id' => $company_id, 'grade_id' => $EmployeeProfile['grade']])->get();
            $app_ref = $this->generatetoken("6","leaveapplication","transaction_id");
            $count = leaveapplication::where(['company_id'=>Auth::user()->company_id])->get();
            return view('CorpHRM.leave.leaveApplicaton',[
                'leavemaster' => $leavemaster,
                'app_ref' => count($count) + 1,
                'users' => $users
            ]);
        }
        else
             {
            return Redirect::intended('login');
        }
    }

    public function EditLeaveApplication($id)
    {
        if (Auth::check()) {

        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $users = User::where('company_id',$company_id)
                    ->where('id','!=',$user_id)->get();
        $EmployeeProfile = EmployeeProfile::where('user_id',$user_id)->first();
        $leavemaster = Leavemaster::where(['company_id' => $company_id, 'grade_id' => $EmployeeProfile['grade']])->get();
            $app_ref = $this->generatetoken("6","leaveapplication","transaction_id");
            $leaveapp = leaveapplication::where(['company_id'=>Auth::user()->company_id, 'id' => $id])->first();
            return view('CorpHRM.leave.leaveApplication_edit',[
                'leaveapp' => $leaveapp,
                'leavemaster' => $leavemaster,
                'app_ref' => $app_ref,
                'users' => $users
            ]);
        }
        else
             {
            return Redirect::intended('login');
        }
    }

    public function listLeaveApplication(){

        if (Auth::check()){
            $LeavesApplication = leaveapplication::where('company_id',Auth::user()->company_id)->get();
            $result = array();
            $masters = Leavemaster::where(['company_id' => Auth::user()->company_id])->get();
            foreach ($LeavesApplication as $LeaveApplication){
            $leavemaster = Leavemaster::where(['id' => $LeaveApplication->leave_master_id, 'company_id' => Auth::user()->company_id])->first();
            $branches = Branch::where('company_id',Auth::user()->company_id)->get();
            $user = User::where('id',$LeaveApplication->employee_id)->first();
                $result[] = [
                    'id' => $LeaveApplication->id,
                    'transaction_id' => $LeaveApplication->transaction_id,
                    'transaction_date' => $LeaveApplication->transaction_date,
                    'employee' => $user['name'],
                    'leave_master' => $leavemaster['name'],
                    'start_date' => $LeaveApplication->start_date,
                    'end_date' => $LeaveApplication->end_date,
                    'phone' => $LeaveApplication->phone,
                    'stage' => $LeaveApplication->stage,
                    'status' => $LeaveApplication->status
                ];
            }
            return view('CorpHRM.leave.listleaveApplication',['LeavesApplication' => $result,'branches' => $branches, 'masters' => $masters, 'type' => "All"]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }

    public function listMyLeaveApplication(){
        
                if (Auth::check()){
                    $LeavesApplication = leaveapplication::where(['employee_id' => Auth::user()->id ,'company_id'=>Auth::user()->company_id])->get();
                    $result = array();
                    foreach ($LeavesApplication as $LeaveApplication){
                    $leavemaster = Leavemaster::where(['id' => $LeaveApplication->leave_master_id, 'company_id' => Auth::user()->company_id])->first();
                    
                    $user = User::where('id',$LeaveApplication->employee_id)->first();
                        $result[] = [
                            'id' => $LeaveApplication->id,
                            'transaction_id' => $LeaveApplication->transaction_id,
                            'transaction_date' => $LeaveApplication->transaction_date,
                            'employee' => $user['name'],
                            'leave_master' => $leavemaster['name'],
                            'start_date' => $LeaveApplication->start_date,
                            'end_date' => $LeaveApplication->end_date,
                            'phone' => $LeaveApplication->phone,
                            'stage' => $LeaveApplication->stage,
                            'status' => $LeaveApplication->status
                        ];
                    }
                    return view('CorpHRM.leave.listleaveApplication',['LeavesApplication' => $result, 'type' => "My"]);
                }
                else
                 {
                    return Redirect::intended('login');
                }
    }

    public function postLeaveApplication(Request $request)
    {
        if (Auth::check()) {
                //todo: Validate
                $leaveApp = new leaveapplication();
                $leaveApp->transaction_id = $request->transaction_id;
                $leaveApp->transaction_date = date('Y-m-d H:i:s');//$request->application_date;
                $leaveApp->employee_id = Auth::user()->id;
                $leaveApp->phone = $request->phone;
                $leaveApp->start_date = $request->start_date;
                $leaveApp->end_date = $request->end_date;
                $leaveApp->leave_master_id = $request->leave_master_id;
                $leaveApp->no_of_days = $request->no_of_days;
                $leaveApp->responsibilities_employee_id = $request->responsibilities_employee_id;
                $leaveApp->reason = $request->reason;
                $leaveApp->take_leave = $request->take_leave;
                $leaveApp->company_id = Auth::user()->company_id;
                $leaveApp->save();
                $success = true;
                return redirect()->back()->with('success', 'successfully submitted!');

        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function UpdateLeaveApplication(Request $request)
    {
        if (Auth::check()) {
                //todo: Validate
                leaveapplication::where('id',$request->id)->update([
                'transaction_date' => date('Y-m-d H:i:s'),
                'phone' => $request->phone,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'no_of_days' => $request->no_of_days,
                'responsibilities_employee_id' => $request->responsibilities_employee_id,
                'reason' => $request->reason,
                'take_leave' => $request->take_leave
                ]);
                $success = true;
                return redirect()->back()->with('success', 'successfully submitted!');

        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function listLeaveCredit(){

        if (Auth::check()) {
            $result = array();
            $LeaveCredits = leavecredit::where('company_id',Auth::user()->company_id)->get();
            foreach ($LeaveCredits as $LeaveCredit){
                $user = User::where('id', $LeaveCredit['employee_id'])->first();
                $leavemaster = Leavemaster::where(['id' => $LeaveCredit->leave_type, 'company_id' => Auth::user()->company_id])->first();
               $result[] = [
               'id' => $LeaveCredit->id,
               'employee' => $user['name'],
               'leave_type' => $leavemaster['name'],
               'effective_date' => $LeaveCredit->effective_date,
               'transaction_date' => $LeaveCredit->transaction_date
               ]; 
            }
            return view('CorpHRM.leave.listleavecredit',['LeaveCredits' => $result]);
        }
        else
         {
            return Redirect::intended('login');
        }
    }


    public function listMyLeaveCredit(){
        
                if (Auth::check()) {
                    $result = array();
                    $LeaveCredits = leavecredit::where(['company_id' => Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
                    foreach ($LeaveCredits as $LeaveCredit){
                        $user = User::where('id', $LeaveCredit['employee_id'])->first();
                        $leavemaster = Leavemaster::where(['id' => $LeaveCredit->leave_type, 'company_id' => Auth::user()->company_id])->first();
                       $result[] = [
                       'id' => $LeaveCredit->id,
                       'employee' => $user['name'],
                       'leave_type' => $leavemaster['name'],
                       'effective_date' => $LeaveCredit->effective_date,
                       'transaction_date' => $LeaveCredit->transaction_date
                       ]; 
                    }
                    return view('CorpHRM.leave.listleavecredit',['LeaveCredits' => $result]);
                }
                else
                 {
                    return Redirect::intended('login');
                }
    }

    public function getLeaveCredit()
    {
        if (Auth::check()) {

            $users = User::where('company_id',Auth::user()->company_id)->get();
            $leavemaster = Leavemaster::where('company_id',Auth::user()->company_id)->get();
            return view('CorpHRM.leave.leavecredit',['profiles' => $users,'masters' => $leavemaster]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }


    public function postLeaveCredit(Request $request)
     {
         if (Auth::check()) {

        $leavecredit = new leavecredit();
        $leavecredit->transaction_date = date('Y-m-d H:i:s');
        $leavecredit->effective_date = $request->effective_date;
        $leavecredit->employee_id = $request->employee_id;
        $leavecredit->leave_type = $request->leave_type;
        $leavecredit->company_id = Auth::user()->company_id;
        $leavecredit->save();
        $success = true;
//        return view('CorpHRM.loan.loanDisbursement',compact('success'));
             return redirect()->back()->with('success', 'successfully Submitted!');
         }
         else
         {
             return Redirect::intended('login');
         }
     }


     public function EditLeaveCredit($id)
     {
         if (Auth::check()) {
 
             $users = User::where('company_id',Auth::user()->company_id)->get();
             $LeaveCredits = leavecredit::where(['company_id'=>Auth::user()->company_id, 'id' => $id])->get();
             $leavemaster = Leavemaster::where('company_id',Auth::user()->company_id)->get();
             foreach ($LeaveCredits as $LeaveCredit){
                 $user = User::where('id', $LeaveCredit['employee_id'])->first();
                $result = [
                'id' => $LeaveCredit->id,
                'employee' => $user['name'],
                'employee_id' => $user['id'],
                'leave_type' => $LeaveCredit->leave_type,
                'effective_date' => $LeaveCredit->effective_date,
                'transaction_date' => $LeaveCredit->transaction_date
                ]; 
             }
             return view('CorpHRM.leave.leavecredit_edit',['profiles' => $users, 'masters' => $leavemaster, 'leavecredit' => $result]);
         }
         else
         {
             return Redirect::intended('login');
         }
     }
 
 
     public function UpdateLeaveCredit(Request $request)
      {
          if (Auth::check()) {
 
         leavecredit::where()->update([
         'transaction_date' => date('Y-m-d H:i:s'),
         'effective_date' => $request->effective_date,
         'employee_id' => $request->employee_id,
         'leave_type' => $request->leave_type,
         'company_id' => Auth::user()->company_id,
         ]);
         $success = true;

              return redirect()->back()->with(compact('success'));
          }
          else
          {
              return Redirect::intended('login');
          }
      }
    
        public function getLeaveAllowance()
        {
            if (Auth::check()) {

                $grades = Grade::where('company_id',Auth::user()->company_id)->get();
                return view('CorpHRM.leave.leaveallowance',['grades' => $grades]);
            } else {
                return Redirect::intended('login');
            }
        }

        public function EditLeaveAllowance($id)
        {
            if (Auth::check()) {

                $grades = Grade::where('company_id',Auth::user()->company_id)->get();
                $leaveallowance = leaveallowance::where(['company_id'=>Auth::user()->company_id,'id'=>$id])->first();
                return view('CorpHRM.leave.leaveallowance_edit',['grades' => $grades,'leaveallowance' => $leaveallowance]);
            } else {
                return Redirect::intended('login');
            }
        }

        public  function ListLeaveAllowance(){

            if (Auth::check()) {
                $leaveallowances = leaveallowance::where('company_id',Auth::user()->company_id)->get();
                $result = array();
                foreach ($leaveallowances as $leaveallowance){
                  $grade = Grade::where('id',$leaveallowance->grade_id)->first(); 
                  
                  $result[] = [
                    'id' => $leaveallowance->id,
                  'name' => $leaveallowance->name,
                  'allowance_percent' => $leaveallowance->allowance_percent,
                  'grade' => $grade['name']
                  ];

                }
                
                return view('CorpHRM.leave.leaveallowances',['leaveallowances' => $result]);
            }
            else
             {
                return Redirect::intended('login');
            }
        }

        public  function ListMyLeaveAllowance(){
            
                        if (Auth::check()) {
                            $leaveallowances = leaveallowance::where(['company_id'=>Auth::user()->company_id,'employee_id' => Auth::user()->id])->get();
                            $result = array();
                            foreach ($leaveallowances as $leaveallowance){
                              $grade = Grade::where('id',$leaveallowance->grade_id)->first(); 
                              
                              $result[] = [
                                'id' => $leaveallowance->id,
                              'name' => $leaveallowance->name,
                              'allowance_percent' => $leaveallowance->allowance_percent,
                              'grade' => $grade['name']
                              ];
            
                            }
                            
                            return view('CorpHRM.leave.leaveallowances',['leaveallowances' => $result]);
                        }
                        else
                         {
                            return Redirect::intended('login');
                        }
        }
    
        public function postLeaveAllowance(Request $request)
        {
            if (Auth::check()) {
                $check = leaveallowance::where(['grade_id' => $request->grade_id, 'company_id' => Auth::user()->company_id])->first();
                if($check){
                    return redirect('corphrm/leaveallowance/new')->with('error', 'Grade already registerd for allowance!');
                }else{
                    $leaveallowance = new leaveallowance();
                    $leaveallowance->grade_id = $request->grade_id;
                    $leaveallowance->allowance_percent = $request->allowance_percent;
                    $leaveallowance->name = $request->name;
                    $leaveallowance->company_id = Auth::user()->company_id;
                    $leaveallowance->save();
                    $success = true;
                    return redirect()->back()->with('success', 'Successfully Added!');
                }
            }
            else
            {
                return Redirect::intended('login');
            }
        }

    public function UpdateLeave(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        if($status == "approve1"){
            leaveapplication::where('id',$id)->update(['status' => "Approved", 'stage' => "1"]);
        }elseif($status == "approve2"){
            leaveapplication::where('id',$id)->update(['status' => "Approved", 'stage' => "2"]);
        }elseif($status == "hold1"){
            leaveapplication::where('id',$id)->update(['status' => "Hold", 'stage' => "1"]);
        }elseif($status == "hold2"){
            leaveapplication::where('id',$id)->update(['status' => "Hold", 'stage' => "2"]);
        }elseif($status == "reject1"){
            leaveapplication::where('id',$id)->update(['status' => "Rejected", 'stage' => "1"]);
        }elseif($status == "reject2"){
            leaveapplication::where('id',$id)->update(['status' => "Rejected", 'stage' => "2"]);
        }

        return redirect('corphrm/leaveapp')->with('success', 'Action successful');

    }

    public function LeaveCalendar(){
        if (Auth::check()) {

            $events = array();
            $leaveapps = leaveapplication::where(['status' => "Approved", 'stage' => "2"])->get();
            foreach ($leaveapps as $leaveapp){
                $user = User::where('id',$leaveapp->employee_id)->first();
                $e = array();
                 $e['id'] = $leaveapp->id;
                 $e['title'] = "".$user['name']." goes on Leave (Transaction Id: ".$leaveapp->transaction_id.")";
                 $e['start'] = $leaveapp->start_date;
                 $e['end'] = $leaveapp->end_date;
                 array_push($events, $e);
            }
            $result = json_encode($events);
            return view('CorpHRM.leave.leavecalendar',['leave' => $result]);
        }
        else
        {
            return Redirect::intended('login');
        }  
    } 

    public function getParameters($parameter, $id){

        $result = "";

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
