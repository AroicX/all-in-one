<?php

namespace App\Http\Controllers\CorpHRM;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\Attendance;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\CashAdvance\CashAdvanceAdvance;
use App\Models\CorpHRM\CashAdvance\CashAdvanceDisbursment;
use App\Models\CorpHRM\CashAdvance\CashAdvanceRetirement;
use App\Models\CorpHRM\CashAdvance\CashRetirement;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\Employee;
use App\Models\CorpHRM\EmployeeCategory;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\InterviewProcess;
use App\Models\CorpHRM\InterviewRating;
use App\Models\CorpHRM\JobApplications;
use App\Models\CorpHRM\JobProfile;
use App\Models\CorpHRM\RecruitmentApplication;
use App\Models\CorpHRM\RecruitmentPosting;
use App\Models\CorpHRM\RecruitmentProcess;
use App\Models\CorpHRM\leave\leaveallowance;
use App\Models\CorpHRM\leave\leaveapplication;
use App\Models\CorpHRM\leave\leavecredit;
use App\Models\CorpHRM\leave\leavemaster;
use App\Models\CorpHRM\loan\LoanApplication;
use App\Models\CorpHRM\loan\LoanDisbursement;
use App\Models\CorpHRM\loan\LoanMaster;
use App\Models\CorpHRM\loan\LoanPayment;
use App\Models\LogUserActions;
use App\User;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Input;
use PDF;


class CorpHRMController extends Controller
{
    //

    public function Dashboard()
    {
//        dd(23452535);
        if (Auth::check()) {

            if($this->get_subscription_status()) {
                $x = json_decode($this->get_module_status("CorpHRM"));
                if($x->status=="Active") {
                    return view('CorpHRM.panel.Dashboard');
                }else{
                    if($x->status=="Warning" && $x->days_left<="3") {
                        session()->flash('alert-danger', 'Subscription to '.$x->package.' will Expire in '.$x->days_left.' days!');
                    }
                    elseif($x->status=="Warning") {
                        session()->flash('alert-warning', 'Subscription to '.$x->package.' will Expire in '.$x->days_left.' days!');
                    }
                    else
                    {
                        return Redirect::intended('dashboard')->with('message', 'Subscription Does Not Cover '.$x->package.'')
                            ->with('status', 'warning')
                            ->withInput();
                    }
                    return view('CorpHRM.panel.Dashboard');
                }
            }
            else
            {
                return Redirect::intended('subscription');
            }
        }
        else{
            //return view('auth.login');
            return Redirect::intended('login');
        }
    }


    public function getDashboard()
    {
        if (Auth::check()) {
            return view('CorpHRM.index');
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function getRecruitmentProcess()
    {
        if (Auth::check()) {
            return view('CorpHRM.Recruitment.rec_process');
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function Job_Application_form($reference_id)
    {

        // if (Auth::check()) {
        //$company_id = Auth::user()->company_id; 
        $result = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_posting where md5(id) = '$reference_id' "));
        foreach ($result as $res) {
            $company_id = $res->company_id;
        }
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        $result2 = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_posting where md5(id) = '$reference_id' "));
        if($result){
            return view('CorpHRM.Recruitment.application-form.form',
                ['results' => $result,
                    'results2' => $result2,
                    'company_details' => $company_details 
                ]
            );
        }
        else{
            return "Error 404!";
        }
        // }
        // else
        // {
        //     return Redirect::intended('login');
        // }
    }

    public function View_Job_Application_form($reference_id,$id)
    {

        // if (Auth::check()) {
        //$company_id = Auth::user()->company_id; 
        $result = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_application where md5(id) = '$reference_id' "));
        foreach ($result as $res) {
            $company_id = $res->company_id;
            $rec_app_id = $res->id;
        }
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        $result2 = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_posting where md5(rec_application_id) = '$reference_id' "));
        $app = JobApplications::where(['id'=> $id, 'rec_app_id' => $rec_app_id])->first();
        if($result){
            return view('CorpHRM.Recruitment.application-form.view-form',
                [
                    'results' => $result,
                    'app' => $app,
                    'results2' => $result2,
                    'company_details' => $company_details 
                ]
            );
        }
        else{
            return "Error 404!";
        }
        // }
        // else
        // {
        //     return Redirect::intended('login');
        // }
    }

        public function Job_Application_form_success($reference_id)
    {

        // if (Auth::check()) {
        //$company_id = Auth::user()->company_id; 
        $result = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_posting where md5(id) = '$reference_id' "));
        foreach ($result as $res) {
            $company_id = $res->company_id;
        }
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        $result2 = DB::select(DB::raw("SELECT * FROM corphrm_recruitment_posting where md5(id) = '$reference_id' "));
        if($result){
            return view('CorpHRM.Recruitment.application-form.Success',
                ['results' => $result,
                    'results2' => $result2,
                    'company_details' => $company_details 
                ]
            );
        }
        else{
            return "Error 404!";
        }
        // }
        // else
        // {
        //     return Redirect::intended('login');
        // }
    }


    public function Applicants(Request $request,$rec_id,$id = NULL){
        $company_id = Auth::user()->company_id; 
        $companies = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        if($id != NULL){
            $details = JobApplications::where(['rec_app_id'=> $rec_id,'id' => $id])->first();
            return view('CorpHRM.Recruitment.Applicant_details',
                [   
                    'companies' => $companies,
                    'details' => $details
                ]
            );
        }else{
                    if($request->get('s')){
                        $stage = $request->get('s');
            $applicants = JobApplications::where('rec_app_id',$rec_id)->where('stage',$request->get('s'))->get();
        }else{
            $stage = "1";
            $applicants = JobApplications::where('rec_app_id',$rec_id)->where('stage',"1")->get();
        }
            
            $posting = RecruitmentPosting::where('rec_application_id',$rec_id)->first();
            $interview_processes = InterviewProcess::where('rec_posting',$posting['id'])->get();
            $interview_process = InterviewProcess::where('rec_posting',$posting['id'])->first();
            return view('CorpHRM.Recruitment.Applicants',[   
                    'companies' => $companies,
                    'stage' => $stage,
                    'interview_processes' => $interview_processes,
                    'interview_process' => $interview_process,
                    'rec_app_id' => $rec_id,
                    'applicants' => $applicants
                ]
            ); 
        }
    }

    public function Applicants_pdf($rec_id, $stage){

   
        $data = JobApplications::where(['rec_app_id'=> $rec_id,'stage' => $stage])->get();
    
    $pdf = PDF::loadView('CorpHRM.Recruitment.application-form.ApplicantsPdfTemplate', ['data' => $data]);
    return $pdf->stream('applicants.pdf');
    }

    public function  Applicants_Excel($rec_id, $stage){
        $result = array();
        Excel::create('applicants', function($excel) use ($rec_id, $stage){
            // Set the title
            $excel->setTitle('SHORTLISTED CANDIDATES');
            $excel->sheet('list', function($sheet) use ($rec_id, $stage){
                $data = JobApplications::where(['rec_app_id'=> $rec_id,'stage' => $stage])->get();
                foreach ($data as $d){
                    if(empty($d->grade)){ $grade = "0"; }else{ $grade = $d->grade; }
                    $result[] = [
                    'name' => ''.$d->alias.' '.$d->name.'',
                    'email' => $d->email,
                    'phone' => $d->phone,
                    'qualification' => $d->qualification,
                    'grade' => $grade
                    ];
                }
                $sheet->fromArray($result);

            });
        })->download('csv');
    }

    public function upload_applicants_scores(Request $request){
        $file = $request->file('report')->getClientOriginalName();
        $ext =  $request->file('report')->getClientOriginalExtension();
        $rec_id = $request->rec_id;
        $Iprocess = $request->Iprocess;
        $stage = $request->stage;
        $request->file('report')->move(
            base_path() . '/public/uploads/files/applicants/', $file
        );
        Excel::load('/public/uploads/files/applicants/'.$file.'', function($reader) use ($rec_id, $Iprocess, $stage) {

            $results = $reader->get(array('email', 'phone', 'grade'));
            foreach ($results as $result){
               
               // $applicants = JobApplications::where(['email' => $result->email, 'phone' => $result->phone])->update(['grade' => $result->grade]);
               // return $applicants;
                $res[] = [
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'grade' => $result->grade
                ];
            }
            foreach($res as $r){
               $applicants = JobApplications::where(['rec_app_id' => $rec_id, 'email' => $r['email']])->update(['grade' => $r['grade']]);
                $this->check_eligibity_nextstage($rec_id,$Iprocess,$r['email'],$stage);
            }
            
        });

        return Redirect::back()->with('success', 'Successfully graded!');
    }

    public function lock_application_scores(Request $request){
        $id = $request->get('id');
        InterviewProcess::where(['id' => $id])->update(['lock_scores' => "1"]);
        return Redirect::back()->with('success', 'Successfully Locked!');
    }

    public function unlock_application_scores(Request $request){
        $id = $request->get('id');
        InterviewProcess::where(['id' => $id])->update(['lock_scores' => "0"]);
        return Redirect::back()->with('success', 'Successfully Unlocked!');
    }

    public function upload_applicants_scores_manually(Request $request){
        $applicant_id = $request->get('id');
        $score = $request->score;
        $rec_id = $request->rec_id;
        $Iprocess = $request->Iprocess;
        $stage = $request->stage;
        $array = explode(',',$applicant_id);
        foreach($array as $a_i){
            JobApplications::where(['id' => $a_i])->update(['grade' => $score]);
            $applicant = JobApplications::where(['id' => $a_i])->first();
            $this->check_eligibity_nextstage($rec_id,$Iprocess,$applicant['email'],$stage);
        }

       return Redirect::back()->with('success', 'Applicants Successfully Scored!');
    }

    private function check_eligibity_nextstage($rec_id,$Iprocess,$email,$stage){

        $company_id = Auth::user()->company_id;
        $ratings = InterviewRating::where(['company_id' => $company_id, 'interview_process' => $Iprocess])->first();
        if($ratings){
            $applicants = JobApplications::where(['rec_app_id' => $rec_id, 'email' => $email])->first();
            if($applicants['grade'] >= $ratings['minimum_rate'] && $applicants['grade'] <= $ratings['maximum_rate']){
                $apps = JobApplications::where(['rec_app_id' => $rec_id, 'email' => $email])->get();
                foreach ($apps as $app){
                    JobApplications::where(['id' => $app->id])->update(['stage' => $stage + 1]);
                }
            }
        }
        

        return true;
    }

    public function email_shortlisted_candidates($stage,$process_id,$rec_app_id){

        $company_id = Auth::user()->company_id;
        $company_names = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_names as $company_name){
            $c_name = $company_name->name;
            $c_email = $company_name->email;
        }

        $applicants = JobApplications::where(['rec_app_id' => $rec_app_id, 'stage' => $stage])->get();
        $interview_process = InterviewProcess::where('id',$process_id)->first();
        foreach ($applicants as $applicant){
            $applicant_email = $applicant->email;
            $applicant_name = $applicant->name;
            $data = [
                'stage'=>$stage,
                'company_name'=>$c_name,
                'company_email'=>$c_email,
                'name'=> $applicant->name,
                'date' => $interview_process['rec_date'],
                'recepient' => $applicant->email
            ];
            Mail::queue(

                'Mail.interview_dates', $data, function ($message) use ($applicant_email, $applicant_name) {
                    $message->to($applicant_email, $applicant_name)->subject('Notification of Job Shortlisting');
                    $message->from('noreply@corperm.com', $c_name);
                }
            );

        }
        return Redirect::back()->with('success', 'Successfully sent!');
    }

    public function  interviewer_notification_email($stage,$process_id,$rec_app_id){

        $company_id = Auth::user()->company_id;
        $company_names = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_names as $company_name){
            $c_name = $company_name->name;
            $c_email = $company_name->email;
        }
        $interview_process = InterviewProcess::where('id',$process_id)->first();
        $interviewers = $interview_process['interviewers'];
        // return $interviewers;

        $interviewer = implode(',', $interviewers);
        foreach ($interviewer as $i){
           $interviewer_details =  Employee::where('employee_id',$i)->first();
           $interviewer_profile = EmployeeProfile::where('id', $i)->first();
           $interviewer_email = $interviewer_details['official_email_address'];
           $interviewer_name = $interviewer_profile['firstname'];

            $data = [
                'stage'=>$stage,
                'company_name'=>$c_name,
                'company_email'=>$c_email,
                'name'=> $interviewer_profile['firstname'],
                'date' => $interview_process['rec_date'],
                'recepient' => $interviewer_details['official_email_address']
            ];
            Mail::queue(

                'Mail.invitation', $data, function ($message) use ($interviewer_email, $interviewer_name) {
                    $message->to($interviewer_email, $interviewer_name)->subject('Notification');
                    $message->from('noreply@corperm.com', $c_name);
                }
            );
        }
        return Redirect::back()->with('success', 'Successfully sent!');
    }

    public function InterviewProcessDetails($id){
        $rec_posting = RecruitmentPosting::where('id',$id)->first();
        $rec_process = RecruitmentProcess::where('id',$rec_posting['rec_process_id'])->first();
        $rec_application = RecruitmentApplication::where('id',$rec_posting['rec_application_id'])->first();
        $sorting_no = "".$rec_process['process_name']."/".$rec_application['job_title']."/".$rec_application['posted_date']."";
        $rec_dates = $rec_posting['interview_dates'];
        $dates = explode(',', $rec_dates);
        return $result = ['sorting_no' => $sorting_no,'rec_dates' => $dates];
        // return json_encode($sorting_no);
    }

    /*
    *Recruitment Interviewer Emails
    */
        public function invitation_email($company_name,$company_email,$recepient,$interviewer_name,$interview_date)
    {
        $data = [

            'company_name'=>$company_name,
            'company_email'=>$company_email,
            'name'=> $interviewer_name,
            'date' => $interview_date,
            'recepient' => $recepient

        ];
        Mail::queue(

            'Mail.invitation', $data, function ($message) use ($recepient, $interviewer_name) {
                $message->to($recepient, $interviewer_name)->subject('Invitation as an Interviewer');
                $message->from('noreply@corperm.com', $company_name);
            }
        );
    }


    public  function applicant_shortlisted_email($applicant_name,$applicant_email,$interview_date,$company_name,$company_email){

        $data = [

            'name'=>$applicant_name,
            'email'=>$applicant_email,
            'date'=>$interview_date,
            'company_name'=>$company_name,
            'company_email'=>$company_email

        ];
        Mail::queue(

            'Mail.applicant_stage2', $data, function ($message) use ($applicant_email, $applicant_name) {
                $message->to($applicant_email, $applicant_name)->subject(''.$company_name.' Interview');
                $message->from('noreply@corperm.com', 'CorpERM');
            }
        );
    }

    public function add_interview_dates_email($company_name,$company_email,$recepient,$interviewer_name,$interview_date){
     $data = [

            'company_name'=>$company_name,
            'company_email'=>$company_email,
            'name'=> $interviewer_name,
            'date' => $interview_date,
            'recepient' => $recepient

        ];
        Mail::queue(

            'Mail.interview_dates', $data, function ($message) use ($recepient, $interviewer_name) {
                $message->to($recepient, $interviewer_name)->subject('Interview Dates');
                $message->from('noreply@corperm.com', $company_name);
            }
        );   
    }

    public function Update_CorpHRM($sub_module,$id,$status){

        if($sub_module == "rec_posting") {
            RecruitmentPosting::where('id',$id)->update(['status' => $status]);
        }

        return Redirect::back()->with('success', 'Successfully Updated!');
    }


    public function  post_application_form(Request $request){

         $this->validate($request, [
            'phone' => 'required|unique:corphrm_job_applications',
            'email' => 'required|unique:corphrm_job_applications',
            'cv_file' => 'required|mimes:png,jpg,pdf',
            'other_file' => 'mimes:png,jpg,pdf'

        ]);
        
        $company_id = Auth::user()->company_id; 
        $company_names = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_names as $company_name){
            $c_name = $company_name->name;
        }
        $date = date('Y-m-d');
        $cv = $request->file('cv_file')->getClientOriginalName();
        $ext =  $request->file('cv_file')->getClientOriginalExtension();
        $file = ''.$cv.'.'.$ext.'';
    $request->file('cv_file')->move(
        base_path() . '/public/uploads/files/'.$c_name.'/job_app/cv/'.$date.'/', $cv
    );

    $other_file = "";
    if($request->hasFile('other_file')){
        $other_file = $request->file('other_file')->getClientOriginalName();
        $ext = $request->file('other_file')->getClientOriginalExtension();
        $file = ''.$other_file.'.'.$ext.'';
        $request->file('other_file')->move(
            base_path() . '/public/uploads/files/'.$c_name.'/job_app/other/'.$date.'/', $other_file
        );  
    } 
       $db = new JobApplications(); 
       $db->rec_app_id  = $request->app_id;
       $db->alias = $request->alias;
       $db->name = ''.$request->fname.' '.$request->lname.'';
       $db->marital_status = $request->marital_status;
       $db->age = $request->age;
       $db->address = $request->address;
       $db->qualification = $request->qualification;
       $db->city = $request->city;
       $db->state = $request->state;
       $db->country = $request->country;
       $db->cv_file = $cv;
       $db->other_file = $other_file;
       $db->email = $request->email;
       $db->phone = $request->phone;
       $db->comment = $request->comment;
       $db->last_employer = $request->last_employer;
       $db->nature_of_employment = $request->nature_of_employment;
       $db->last_salary = $request->last_salary;
       $db->save(); 
    return $this->Job_Application_form_success(md5($request->app_id));
    }

    public function ShortlistApplicant($id){
        $applicant_details = DB::select(DB::raw("SELECT * FROM corphrm_job_applications where md5(id) = '$id' "));
        $company_id = Auth::user()->company_id; 
        $companies = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($applicant_details as $applicant_detail){
        foreach ($companies as $company){
            $current_level = $applicant_detail->grade;
            if(empty($current_level) || $current_level == NULL){
                JobApplications::where('id',$applicant_detail->id)->update(['grade' => 1]);
                $this->applicant_shortlisted_email($applicant_detail->name,$applicant_detail->email,$interview_date,$company->name,$company->email);
            }else{
                $new = $applicant_detail->grade + 1;
                JobApplications::where('id',$applicant_detail->id)->update(['grade' => $new]);
                $this->applicant_shortlisted_email($applicant_detail->name,$applicant_detail->email,$interview_date,$company->name,$company->email);
            }
        }
        }
        return redirect()->back()->with(['success' => ''.$applicant_detail->name.' Successfully shortlisted']);
    }

    public function addRecruitmentProcess(Request $request)
    {
        if (Auth::check())
        {   
            $interview_process = implode(',',$request->interview_process);
            $db = new RecruitmentProcess();
            $db->process_name = $request->process_name;
            $db->process_description = $request->process_desc;
            $db->interview_processes = $interview_process;
            $db->company_id = Auth::user()->company_id;
            $db->save();
            $success = "success";
            return view('CorpHRM.Recruitment.rec_process', compact('success'));
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function ViewRecruitmentProcess(Request $request)
    {
        if (Auth::check())
        {   
            $company_id = Auth::user()->company_id;
            $rec_processes = RecruitmentProcess::where(['company_id' => $company_id])->get();
            return view('CorpHRM.Recruitment.rec_process_view', ['rec_processes' => $rec_processes]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function UpdateRecruitmentProcess(Request $request)
    {
        if (Auth::check())
        {   
            $interview_process = implode(',',$request->interview_process);
            RecruitmentProcess::where('id', $request->id)->update([
            'process_name' => $request->process_name,
            'process_description' => $request->process_desc,
            'interview_processes' => $interview_process,
            ]);
            $success = "success";
            return redirect()->back()->with(compact("success"));
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function EditRecruitmentProcess($id)
    {
        if (Auth::check())
        {   
            $company_id = Auth::user()->company_id;
            $rec_process = RecruitmentProcess::where(['company_id' => $company_id, 'id' => $id])->first();
            return view('CorpHRM.Recruitment.rec_process_edit', ['rec_process' => $rec_process]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function getJobProfile()
    {
        if (Auth::check()) {
            return view('CorpHRM.Recruitment.job_profile');
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function listJobProfile(){
        if (Auth::check()) {

            $company_id = Auth::user()->company_id;
            $jobprofiles = JobProfile::where(['company_id' => $company_id])->get();
            return view('CorpHRM.Recruitment.list_job_profile',['jobprofiles' => $jobprofiles]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function EditJobProfile($id){
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $jobprofile = JobProfile::where(['company_id' => $company_id, 'id' => $id])->first();
            return view('CorpHRM.Recruitment.edit_job_profile',['jobprofile' => $jobprofile]);
        }
        else
        {
            return Redirect::intended('login');
        }   
    }

    public function edit_JobProfile(Request $request){
        if (Auth::check()) {
            JobProfile::where('id',$request->id)->update([
            'job_title' => $request->job_title,
            'job_description' => $request->job_description,
            'qualification_details' => $request->qualification_details,
            'experience_details' => $request->experience_details,
            'skill_details' => $request->skill_details,
            'company_id' => Auth::user()->company_id,
            ]);

            $success = "success";
            return redirect()->back()->with(compact('success'));
        }
        else
        {
            return Redirect::intended('login');
        } 
    }

    public function addJobProfile(Request $request)
    {
        if (Auth::check()) {
            $db = new JobProfile();
            $db->job_title = $request->job_title;
            $db->job_description = $request->job_description;
            $db->qualification_details = $request->qualification_details;
            $db->experience_details = $request->experience_details;
            $db->skill_details = $request->skill_details;
            $db->company_id = Auth::user()->company_id;
            $db->save();

            $success = "success";
            return view('CorpHRM.Recruitment.job_profile', compact('success'));
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function getRecruitmentApplication($id = NULL)
    {

        if (Auth::check()) {

            if(!empty($id)) {
                $company_id = Auth::user()->company_id; 
                $rec_applications = RecruitmentApplication::where(['id' => $id, 'company_id' => $company_id])->first();
                if(!empty($rec_applications)) {
                    return view('CorpHRM.Recruitment.rec_application_view', [
                    'rec_applications' => $rec_applications,
                    ]);
                }

            }
            $company_id = Auth::user()->company_id; 
            $job_profiles = JobProfile::where(['company_id' => $company_id])->get();
            $categories = EmployeeCategory::where(['company_id' => $company_id])->get();
            $branches =  Branch::where(['company_id' => $company_id])->get();
            $designations = Designation::where(['company_id' => $company_id])->get();
            $departments = Department::where(['company_id' => $company_id])->get();
            return view('CorpHRM.Recruitment.rec_application', [
                 'job_profiles' => $job_profiles,
                 'branches' => $branches,
                  'categories' => $categories,
                'departments' => $departments,
                'designations' => $designations
                ]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function ApproveRecruitmentApplication($id)
    {
        $company_id = Auth::user()->company_id; 
        RecruitmentApplication::where(['id' => $id, 'company_id' =>$company_id])->update(['status' => "Approved"]);
        return redirect()->back()->with(['success' => 'Successfully Approved']);

    }

    public function CancelRecruitmentApplication($id)
    {
        $company_id = Auth::user()->company_id; 
        RecruitmentApplication::where(['id' => $id, 'company_id' =>$company_id])->update(['status' => "Cancelled"]);
        return redirect()->back()->with(['success' => 'Successfully Cancelled']);

    }

    public function getRecruitmentApplications()
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id; 
            $rec_applications = RecruitmentApplication::where('company_id',$company_id)->get();
            return view('CorpHRM.Recruitment.rec_applications', [
                 'rec_applications' => $rec_applications,
                ]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function addRecruitmentApplication(Request $request)
    {
        if (Auth::check()) {
            //todo :validate
            $db = new RecruitmentApplication();
            $db->job_title = $request->job_title;
            $db->employee_name = $request->employee_name;
            $db->posted_date = $request->posted_date;
            $db->branch = $request->branch;
            $db->designation = $request->designation;
            $db->department = $request->department;
            $db->category = $request->category;
            $db->job_description = $request->job_description;
            $db->qualification_details = $request->qualification_details;
            $db->experience_details = $request->experience_details;
            $db->skill_details = $request->skill_details;
            $db->no_of_vacancies = $request->no_of_vacancies;
            $db->company_id = Auth::user()->company_id;
            $db->status = "Pending";
            $db->save();

            return redirect()->back()->with(['success' => 'Successfully Created']);
        }
        else
        {
            return Redirect::intended('login');


        }
    }

    public function getRecruitmentPosting()
    {
        if(Auth::check()) {
            $company_id = Auth::user()->company_id;
            $job_profiles = JobProfile::all();
            $result_rec_apps = array();
            $rec_apps = RecruitmentApplication::where(['company_id' => $company_id, 'status' => "Approved"])->get();
            $rec_postings = RecruitmentPosting::where(['company_id' => $company_id])->get();
            $rec_processes = RecruitmentProcess::all();
            foreach ($rec_apps as $rec_app) {
                foreach ($rec_postings as $rec_posting) {
                    if($rec_app->id == $rec_posting->rec_application_id) {
                      
                    } else {
                          $result_rec_apps[] = $rec_app;
                    }
                }
            }
            $job_code = rand(1, 1000000);

            return view('CorpHRM.Recruitment.rec_posting',[
                'job_profiles' => $job_profiles,
                'rec_apps' => $rec_apps,
                'rec_processes' => $rec_processes,
                'job_code' => $job_code,
            ]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

        public function viewRecruitmentPostings()
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id; 
            $result = array();
            $rec_postings = RecruitmentPosting::where('company_id',$company_id)->get();
            foreach ($rec_postings as $rec_posting){
                $rec_app = RecruitmentApplication::where(['id' => $rec_posting->rec_application_id])->first();
                $rec_process = RecruitmentProcess::where(['id' => $rec_posting->rec_process_id])->first();
                $result[] = [
                'id' => $rec_posting->id,
                'rec_process' => $rec_process['process_name'],
                'job_code' => $rec_posting->job_code,
                'app_title' => $rec_app['job_title'],
                'start_date' => $rec_posting->start_date,
                'end_date' => $rec_posting->end_date,
                'no_vacancy' => $rec_posting->no_of_vacancies,
                'interview_dates' => $rec_posting->interview_dates,
                'status' => $rec_posting->status
                ];
            }
            return view('CorpHRM.Recruitment.rec_posting_table', [
                 'rec_postings' => $result,
                ]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function addRecruitmentPosting(Request $request)
    {


        if(Auth::check()) {

            $db = new RecruitmentPosting();
            // $db->job_title = $request->job_title;
            $db->job_code = $request->job_code;
            $interview_dates = implode(',',  $request['interview_dates']);
            // $db->job_description = $request->job_description;
            $db->rec_process_id = $request->rec_process_id;
            $db->rec_application_id = $request->rec_application_id;
            $db->posted_date = $request->posted_date;
            $db->start_date = $request->start_date;
            $db->end_date = $request->end_date;
            $db->location = $request->location;
            $db->no_of_vacancies = $request->no_of_vacancies;
            $db->years_of_experience = $request->years_of_experience;
            $db->qualification_details = $request->qualification_details;
            $db->experience_details = $request->experience_details;
            $db->other_details = $request->other_details;
            $db->email = $request->email_id;
            $db->status = "Pending";
            $db->company_id = Auth::user()->company_id;
            $db->link = str_slug($request->job_title);
            $db->interview_dates = $interview_dates;
            $db->save();
            return redirect()->back()->with(['success' => 'Successfully Created']);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function EditRecruitmentPosting($id)
    {
        if(Auth::check()) {
            $company_id = Auth::user()->company_id;
            $result_rec_apps = array();
            $rec_apps = RecruitmentApplication::where(['company_id' => $company_id, 'status' => "Approved"])->get();
            $rec_postings = RecruitmentPosting::where(['company_id' => $company_id])->get();
            $rec_posting = RecruitmentPosting::where(['company_id' => $company_id,'id' => $id])->first();
            $rec_processes = RecruitmentProcess::all();
            foreach ($rec_apps as $rec_app) {
                foreach ($rec_postings as $rec_posting) {
                    if($rec_app->id == $rec_posting->rec_application_id) {
                      
                    } else {
                          $result_rec_apps[] = $rec_app;
                    }
                }
            }

            return view('CorpHRM.Recruitment.rec_posting_edit',[
                'rec_posting' => $rec_posting,
                'rec_apps' => $rec_apps,
                'rec_processes' => $rec_processes,

            ]);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function UpdateRecruitmentPosting(Request $request)
    {


        if(Auth::check()) {

            $interview_dates = implode(',',  $request['interview_dates']);
            RecruitmentPosting::where('id',$request->id)->update([
            'rec_process_id' => $request->rec_process_id,
            'rec_application_id' => $request->rec_application_id,
            'posted_date' => $request->posted_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'no_of_vacancies' => $request->no_of_vacancies,
            'years_of_experience' => $request->years_of_experience,
            'qualification_details' => $request->qualification_details,
            'experience_details' => $request->experience_details,
            'other_details' => $request->other_details,
            'email' => $request->email_id,
            'status' => "Pending",
            'interview_dates' => $interview_dates,
            ]);
            return redirect()->back()->with(['success' => 'Successfully Updated']);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function getJobApplication()
    {
        if(Auth::check()) {
            return view('CorpHRM.external.job');
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function viewInterviewProcess(){

        $company_id = Auth::user()->company_id;
        $processes = InterviewProcess::where('company_id',$company_id)->get();
        $result = array();
        foreach ($processes as $process){
            $e = array();
           $posting =  RecruitmentPosting::where('id',$process->rec_posting)->first();
           $application = RecruitmentApplication::where('id', $posting['rec_application_id'])->first();
           $a = explode(',',$process->interviewers);
           foreach($a as $b){
           $interviewers = EmployeeProfile::where('id',$b)->first();
           $e[] = ["".$interviewers['title']." ".$interviewers['surname']." ".$interviewers['firstname'].""];
           }
           $result[]= [
                        'id' =>$process->id,
                        'process_name' => $process->process_name,
                        'job_title' => $application['job_title'],
                        'rec_date' => $process->rec_date,
                        'from_time' => $process->from_time,
                        'to_time' => $process->to_time,
                        'interviewers' => $e
           ];
        }
        return view('CorpHRM.Recruitment.interview_process_table',[
            'interview_processes' => $result,
        ]);

    }

    public function getInterviewProcess(){
        $company_id = Auth::user()->company_id;
        $employees = EmployeeProfile::where('company_id',$company_id)->get();
        $rec_postings = RecruitmentPosting::where(['company_id' => $company_id, 'status' => "Approved"])->get();
        foreach ($rec_postings as $rec_posting){
            $rec_app = RecruitmentApplication::where('id',$rec_posting->rec_application_id)->first();
            $result_rec_postings[] = ['id' => $rec_posting->id, 'job_title' => $rec_app['job_title'], 'start_date' => $rec_posting->start_date, 'end_date' => $rec_posting->end_date];
        }
        return view('CorpHRM.Recruitment.interview_process',[
            'employees' => $employees,
            'rec_postings' => $result_rec_postings
        ]);
    }

    public function addInterviewProcess(Request $request){
        $this->validate($request,[
           'rec_posting' => 'required',
            'rec_date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'sorting_no' => 'required',
        ]);
        $interviewers = implode(',',  $request['interviewers']);
        $i = 0;
        foreach ($request['interviewers'] as $interviewer){
           $i = $i + 1;
           
            $tmp = array_count_values($request['interviewers']);
            $cnt = $tmp[$interviewer];
                if($cnt > 1){
                    return redirect()->back()->with(['success'=>'Select Different Interviewer for interviewer '.$i.'']);
                }
            
        }
        $check = InterviewProcess::where(['rec_posting' => $request['rec_posting'], 'rec_date' => $request['rec_date'] ])->first();
        if($check){
            return redirect()->back()->with(['success'=>'Interview processes already done for '.$request['rec_date'].'']);
        }
        $interview_process = new InterviewProcess();
        // No company id here
        $interview_process->company_id = Auth::user()->company_id;
        $interview_process->process_name = $request['process_name'];
        $interview_process->rec_posting = $request['rec_posting'];
        $interview_process->rec_date = $request['rec_date'];
        $interview_process->from_time = $request['from_time'];
        $interview_process->to_time= $request['to_time'];
        $interview_process->interviewers = $interviewers;
        $interview_process->sorting_no = $request['sorting_no'];
        $interview_process->save();

        $company_id = Auth::user()->company_id;
        $employees = array();
        $employees_profile = array();
        $companies = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($request['interviewers'] as $interviewer){
        $employees = DB::select(DB::raw("SELECT * FROM employees where employee_id = '$interviewer' "));
        $employees_profile = DB::select(DB::raw("SELECT * FROM employee_profiles where id = '$interviewer' "));
        foreach ($companies as $company){
        foreach ($employees as $employee){
        foreach ($employees_profile as $employee_profile){
            $this->invitation_email($company->name,$company->email,$employee->official_email_address,$employee_profile->firstname,$request['from_date']);
            }
        }
        }
        }
        return redirect()->back()->with(['success'=>'Successfully Created']);

    }

    public function EditInterviewProcess($id){
        $company_id = Auth::user()->company_id;
        $employees = EmployeeProfile::where('company_id',$company_id)->get();
        $rec_postings = RecruitmentPosting::where(['company_id' => $company_id, 'status' => "Approved"])->get();
        foreach ($rec_postings as $rec_posting){
            $rec_app = RecruitmentApplication::where('id',$rec_posting->rec_application_id)->first();
            $result_rec_postings[] = ['id' => $rec_posting->id, 'job_title' => $rec_app['job_title'], 'start_date' => $rec_posting->start_date, 'end_date' => $rec_posting->end_date];
        }
        $InterviewProcess = InterviewProcess::where(['id' => $id, 'company_id' => $company_id])->first();
        return view('CorpHRM.Recruitment.interview_process_edit',[
            'employees' => $employees,
            'InterviewProcess' => $InterviewProcess,
            'rec_postings' => $result_rec_postings
        ]);
    }

    public function UpdateInterviewProcess(Request $request){
        $this->validate($request,[
           'rec_posting' => 'required',
            'rec_date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'sorting_no' => 'required',
        ]);
        $interviewers = implode(',',  $request['interviewers']);
        $i = 0;
        foreach ($request['interviewers'] as $interviewer){
           $i = $i + 1;
           
            $tmp = array_count_values($request['interviewers']);
            $cnt = $tmp[$interviewer];
                if($cnt > 1){
                    return redirect()->back()->with(['success'=>'Select Different Interviewer for interviewer '.$i.'']);
                }
            
        }
        $check = InterviewProcess::where(['rec_posting' => $request['rec_posting'], 'rec_date' => $request['rec_date'] ])->first();
        if($check){
            return redirect()->back()->with(['success'=>'Interview processes already done for '.$request['rec_date'].'']);
        }
         InterviewProcess::where('id',$id)->update([
        'process_name' => $request['process_name'],
        'rec_posting' => $request['rec_posting'],
        'rec_date' => $request['rec_date'],
        'from_time' => $request['from_time'],
        'to_time' => $request['to_time'],
        'interviewers' => $interviewers,
        'sorting_no' => $request['sorting_no'],
        ]);

        $company_id = Auth::user()->company_id;
        $employees = array();
        $employees_profile = array();
        $companies = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($request['interviewers'] as $interviewer){
        $employees = DB::select(DB::raw("SELECT * FROM employees where employee_id = '$interviewer' "));
        $employees_profile = DB::select(DB::raw("SELECT * FROM employee_profiles where id = '$interviewer' "));
        foreach ($companies as $company){
        foreach ($employees as $employee){
        foreach ($employees_profile as $employee_profile){
            $this->invitation_email($company->name,$company->email,$employee->official_email_address,$employee_profile->firstname,$request['from_date']);
            }
        }
        }
        }
        return redirect()->back()->with(['success'=>'Successfully Created']);

    }

    public function mark_attendance(){

        if(date('D') == 'Sat' || date('D') == 'Sun') { 
            return redirect()->back()->with(['success'=>'Today is not a work day!']);
        } else {
            $date = date('d');
            $company_id = Auth::user()->company_id;
            $user_id = Auth::user()->id;
            $month = date('m');
            $year = date('y');
            $check = Attendance::where(['user_id' => $user_id, 'month' => $month, 'year' => $year, 'company_id' => $company_id])->first();
           // return print_r();
            if($check){
                $parts = explode(',',$check->datee);
                if(array_search($date, $parts) == false){
                    $result = $this->addtostring($check['datee'],$date);
                    Attendance::where(['user_id' => $user_id, 'month' => $month, 'year' => $year, 'company_id' => $company_id])->update(['datee' => $result]);
                }
            }else{
                  //  $date = array($date);
                     $Attendance = new Attendance();
                     $Attendance->user_id = Auth::user()->id;
                     $Attendance->datee = $date;
                     $Attendance->month = $month; 
                     $Attendance->year = $year;
                     $Attendance->company_id = Auth::user()->company_id;
                     $Attendance->save();  
            }
                    return redirect()->back()->with(['success'=>'Attendance Successfully Taken']);
        }
    }

    /*
    *Add a value to an array
    */
    private function addtostring($existArr, $new_item)
    {
        if(empty($existArr)) {
            $result = $new_item;
        } else{

            $parts = explode(',',$existArr);
            $parts[] = $new_item;
            $result = implode(',', $parts);
        }

    return $result;
    }

    /*
    *remove a value from array imploded values
    */
    private function RemoveRromString($array, $item)
    {
    $parts = explode(',',$array);
    while(($i = array_search($item, $parts)) !== false)
    {
    unset($parts[$i]);
    }
    return implode(',',$parts);
    }

             public function getInterviewRating()
             {
                $company_id = Auth::user()->company_id;
                 $processes = InterviewProcess::where('company_id',$company_id)->get();
                 return view('CorpHRM.Recruitment.interview_rating', [
                     'interview_processes' => $processes
                 ]);
             }

            public function viewInterviewRating()
             {  
                $company_id = Auth::user()->company_id;
                 $interview_ratings = InterviewRating::where('company_id',$company_id)->get();
                 return view('CorpHRM.Recruitment.interview_rating_table', [
                     
                     'interview_ratings' => $interview_ratings
                 ]);
             }

                 public function addInterviewRating(Request $request){
                     $this->validate($request,[
                         'process_name' => 'required',
                         'minimum_rate' => 'required',
                         'maximum_rate' => 'required',
                     ]);
                     $interview_rating = new InterviewRating();
                     $interview_rating->interview_process = $request['process_name'];
                     $interview_rating->minimum_rate = $request['minimum_rate'];
                     $interview_rating->maximum_rate = $request['maximum_rate'];
                     $interview_rating->company_id = Auth::user()->company_id;
                     $interview_rating->save();
                     return redirect()->back()->with(['success'=>'Successfully Created']);
                 }

                 public function EditInterviewRating($id)
                 {  
                    $company_id = Auth::user()->company_id;
                     $interview_rating = InterviewRating::where(['company_id'=>$company_id,'id' => $id])->first();
                     $processes = InterviewProcess::where('company_id',$company_id)->get();
                     return view('CorpHRM.Recruitment.interview_rating_edit', [
                         'interview_rating' => $interview_rating,
                         'interview_processes' => $processes
                     ]);
                 }
    
                     public function UdpateInterviewRating(Request $request){
                         $this->validate($request,[
                             'process_name' => 'required',
                             'minimum_rate' => 'required',
                             'maximum_rate' => 'required',
                         ]);
                         InterviewRating::where('id',$request['id'])->update([
                         'interview_process' => $request['process_name'],
                         'minimum_rate' => $request['minimum_rate'],
                         'maximum_rate' => $request['maximum_rate'],
                         ]);
                         return redirect()->back()->with(['success'=>'Successfully Updated']);
                     }


    public function DeleteFunction($action,$id){
        $company_id = Auth::user()->company_id;
        if($action == "loanmaster"){

            $count = LoanApplication::where(['company_id' => $company_id, 'loanmaster_id' => $id])->get();
            if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! Master is currently used by some Applications']);
            }else{
                LoanMaster::where('id',$id)->delete();
            }
        }
        if($action == "job_profile"){
            JobProfile::where('id',$id)->delete();
        }
        if($action == "loanapp"){

           // $count = LoanApplication::where()->get();
           // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            //     LoanApplication::where('id',$id)->delete();
            // }
        }
        if($action == "cashadvance_retirement_update_approve"){
            CashAdvanceRetirement::where('id',$id)->update(['status' => "Approved"]);
        }
        if($action == "cashadvance_retirement_update_cancel"){
            CashAdvanceRetirement::where('id',$id)->update(['status' => "Cancelled"]);
        }
        if($action == "cashadvance_retirement"){
            CashAdvanceRetirement::where('id',$id)->delete();
        }
        if($action == "loanpayment"){

           // $count = LoanApplication::where()->get();
           // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            //     LoanPayment::where('id',$id)->delete();
            // }
        }
        if($action == "loandisbursment"){
           // $count = LoanApplication::where()->get();
            //if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            //}else{
               // LoanDisbursement::where('id',$id)->delete();
           // }
        }
        if($action == "interview_rating"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // InterviewRating::where('id',$id)->delete();
            // }
        }
        if($action == "interview_process"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            //     InterviewProcess::where('id',$id)->delete();
            //}
        }
        if($action == "rec_process"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete!  currently used by some Applications']);
            // }else{
            // RecruitmentProcess::where('id',$id)->delete();
            //}
        }
        if($action == "rec_posting"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // RecruitmentPosting::where('id',$id)->delete();
            // }
        }
        if($action == "rec_application"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // RecruitmentApplication::where('id',$id)->delete();
            //}
        }

        if($action == "leavemaster"){
            $count = LeaveApplication::where(['company_id' => $company_id, 'leave_master_id' => $id])->get();
            if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! Master is currently used by some Applications']);
            }else{
                LeaveMaster::where(['company_id' => $company_id,'id' => $id])->delete();
            }
        }
        if($action == "leavecredit"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                 return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            //LeaveCredit::where('id',$id)->delete();
            //}
        }
        if($action == "leaveapp"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
           // LeaveApplication::where('id',$id)->delete();
            //}
        }
        if($action == "leaveallowance"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // LeaveAllowance::where('id',$id)->delete();
            //}
        }
        if($action == "cashadvance_disbursment"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // CashAdvanceDisbursment::where('id',$id)->delete();
            // }
        }
        if($action == "cashadvance_advance"){
            // $count = LoanApplication::where()->get();
            // if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! currently used by some Applications']);
            // }else{
            // CashAdvanceAdvance::where('id',$id)->delete();
            // }
        }
        if($action == "cashadvance_retirement"){
            CashAdvanceRetirement::where('id',$id)->delete();
        }
        if($action == "cashadvance_retirement_approvals"){
            CashRetirement::where('id',$id)->delete();
        }
        
        
        
        return redirect()->back()->with(compact("success"));
    }


    public function user_actions(){
        $company_id = Auth::user()->company_id;
      $all_actions =  LogUserActions::where(['company_id' => $company_id, 'module' => "CorpHRM"])->get();
      foreach($all_actions as $all_action){
        $user = User::where(['id' => $all_action->user_id])->first();
        $result[] = [
            'staff_name' => $user['name'],
            'action' => $all_action->action,
            'date' => $all_action->created_at
        ];
      }
      //return $result;
      return view('CorpHRM.logged_user_actions', ['all_actions'=>$result]);
    }

}
