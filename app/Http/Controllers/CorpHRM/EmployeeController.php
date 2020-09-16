<?php
namespace App\Http\Controllers\CorpHRM;
use App\Traits\SubscriptionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\CorpHRM\Employee;
use App\Models\CorpHRM\EmployeeDependent;
use App\Models\CorpHRM\EmployeeQualification;
use App\Models\CorpHRM\EmployeeEmergency;
use App\Models\CorpHRM\EmployeeSkills;
use App\Models\CorpHRM\EmployeeExperience;
use App\Models\CorpHRM\EmployeeLanguage;
use App\Models\CorpHRM\EmployeeAssets;
use App\Models\CorpHRM\EmployeeReferences;
use App\Models\CorpHRM\EmployeeDocument;
use App\Models\CorpHRM\EmployeeSalary;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\EmployeeCategory;
use App\Models\CorpHRM\payroll\payroll;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\Bank;
use App\Models\CorpHRM\Health;
use App\Models\CorpHRM\Pension;
use App\Models\CorpHRM\InternalRevenue;
use Intervention\Image\Facades\Image;
use App\Models\CorpHRM\Access_roles;
use App\Models\CorpHRM\leave\leaveapplication;
use App\Models\CorpHRM\EmployeeTrackLog;
use PDF;
use Excel;


class EmployeeController extends Controller
{

       public function getEmployeeIndex(){

            $company_id = Auth::user()->company_id;
           $designations = Designation::where(['company_id' => $company_id])->get();
           $categories = EmployeeCategory::where(['company_id' => $company_id])->get();
           $grades = Grade::where(['company_id' => $company_id])->get();
           $departments = Department::where(['company_id' => $company_id])->get();
           $branches = Branch::where(['company_id' => $company_id])->get();
           $healths = Health::where(['company_id' => $company_id])->get();
           $pfas = Pension::where(['company_id' => $company_id])->get();
           $revenues = InternalRevenue::where(['company_id' => $company_id])->get();
           $banks = Bank::where(['company_id' => $company_id])->get();
           $user = User::where(['company_id' => $company_id])->get();
           $x = count($user) + 1;
           $employee_code = $x."/".$company_id."/".date('y');
         return view ('CorpHRM.employeepf',['designations'=> $designations,
         'categories' => $categories,
             'grades' => $grades,
             'departments' => $departments,
             'branches' => $branches,
             'healths' => $healths,
             'pfas' => $pfas,
             'revenues' => $revenues,
             'banks' => $banks,
             'employee_code' => $employee_code

         ]);
       }

       public function getEmployees() {
           if(Auth::check()){
            $company_id = Auth::user()->company_id;
            $employees = EmployeeProfile::where('company_id',$company_id)->get();
            $branches = Branch::where('company_id',$company_id)->get();
            $result = array();
            foreach($employees as $employee){

                $leave_status = "No";
                $user = User::where('id', $employee->user_id)->first();
                $grade = Grade::where(['id' => $employee->grade])->first();
                $branch = Branch::where(['id' => $employee->branch])->first();
                $department = Department::where(['id' => $employee->department])->first();
                $designation = Designation::where(['id' => $employee->designation])->first();
                $leaveapps = leaveapplication::where(['employee_id' => $employee->user_id, 'status' => "Approved", 'stage' => "2"])->get();
                $today = date('Y-m-d');
                foreach ($leaveapps as $leaveapp){
                  if($today >= $leaveapp->start_date && $today <= $leaveapp->end_date){
                    $leave_status = "Yes";
                  }
                }

                $result[] = [
                    'id' => $employee->id,
                    'user_id' => $employee->user_id,
                    'name' => $employee->title.' '.$employee->surname.' '.$employee->firstname.' '.$employee->middlename,
                    'employee_code' => $employee->employee_code,
                    'grade' => $grade['name'],
                    'branch' => $branch['name'],
                    'department' => $department['name'],
                    'designation' => $designation['name'],
                    'leave_status' => $leave_status,
                    'status' => $user['status']
                ];
            }
          return view ('CorpHRM.employees',['employees' => $result,'branches' => $branches]);
              }else{
              return Redirect::intended('login');
                  }
       }

       public function getEmployee(Request $request){

        $query = $request->get('query');
        $employee_id = $request->get('id');
        $user_id = $request->get('uid');
        $company_id = Auth::user()->company_id;
        // Edit Query
        if($query == "edit" || $query == "Edit"){

            if($employee_id){
                $employee_id = $employee_id;
            }else{
                $employee_id = Auth::user()->id;
            }
            $designations = Designation::where('company_id',$company_id)->get();
            $categories = EmployeeCategory::where('company_id',$company_id)->get();
            $grades = Grade::where('company_id',$company_id)->get();
            $departments = Department::where('company_id',$company_id)->get();
            $branches = Branch::where('company_id',$company_id)->get();
            $healths = Health::where('company_id',$company_id)->get();
            $pfas = Pension::where('company_id',$company_id)->get();
            $revenues = InternalRevenue::all();
            $profile = EmployeeProfile::where(['id' => $employee_id])->first();
            $grade = Grade::where(['id' => $profile['grade']])->first();
            $department = Department::where(['id' => $profile['department']])->first();
            $branch = Branch::where(['id' => $profile['branch']])->first();
            $designation = Designation::where(['id' => $profile['designation']])->first();
            $employee = Employee::where(['employee_id' => $employee_id])->first();
            $dependent = EmployeeDependent::where(['employee_id' => $employee_id])->first();
            $qualification = EmployeeQualification::where(['employee_id' => $employee_id])->first();
            $emergency = EmployeeEmergency::where(['employee_id' => $employee_id])->first();
            $skill = EmployeeSkills::where(['employee_id' => $employee_id])->first();
            $experience = EmployeeExperience::where(['employee_id' => $employee_id])->first();
            $language = EmployeeLanguage::where(['employee_id' => $employee_id])->first();
            $asset = EmployeeAssets::where(['employee_id' => $employee_id])->first();
            $reference = EmployeeReferences::where(['employee_id' => $employee_id])->first();
            $document =  EmployeeDocument::where(['employee_id' => $employee_id])->first();
            $category = EmployeeCategory::where(['id' => $profile['category']])->first();
            $salary = EmployeeSalary::where(['employee_id' => $employee_id])->first();
            $payrolls = Payroll::where(['employee_id' => $user_id])->get();
            $employeetracklogs = EmployeeTrackLog::where(['employee_id' => $employee_id])->orderby('created_at','desc')->get();
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
            return view('CorpHRM.view_employee', compact('profile', 'employee', 'dependent', 'qualification', 'emergency', 'skill', 'experience', 'language', 'asset', 'reference', 'document', 'salary', 'grade','additions', 'grades', 'category', 'designation','designations', 'department','categories', 'salary', 'departments', 'branch', 'branches','healths','revenues','pfas','employeetracklogs'));
        }
        // Delete Query
        if($query == "delete" || $query == "Delete"){

            if($employee_id){

            }else{

            }

        }

       }

      public function postProfile(Request $request){
          if(Auth::check()){
            //   return $request->all();
              $this->validate($request,[
                  'title' => 'required',
                  'surname' => 'required',
                  'middlename' => 'required',
                  'firstname' => 'required',
                  'employee_code' => 'required',
                  'designation' => 'required',
                  'grade' => 'required',
                  'department' => 'required',
                  'category' => 'required',
                  'branch' => 'required',
                  'join_date' => 'required',
                //   'sbirs' => 'required',
                //   'residential_address' => 'required',
                //   'permanent_address' => 'required',
                //   'religion' => 'required',
                //   'telephone_number' => 'required',
                //   'mobile_number' => 'required',
                //   'personal_email_address' => 'required',
                //   'official_email_address' => 'required',
                //   'national_id_no' => 'required',
                //   'driver_license_no' => 'required',
                //   'state_of_origin' => 'required',
                //   'local_govt_area' => 'required',
                //   'blood_group' => 'required',
                //   'genotype' => 'required',
                //   'hmo' => 'required',
                //   'postal_address' => 'required',
                //   'pension_fund_administrator' => 'required',
                //   'pension_pin_no' => 'required',
                //   'no_of_children' => 'required',
                //   'name_of_spouse' => 'required',
                //   'gender' => 'required',
                //   'date_of_birth' => 'required',
                //   'phone_no_spouse' => 'required',
                //   'marital_status' => 'required',
                //   'nationality' => 'required',
                //   'city' => 'required',
                //   'country_address' => 'required',
                //   'dependent_firstname' => 'required',
                //   'dependent_lastname' => 'required',
                //   'dependent_relationship' => 'required',
                //   'dependent_date_of_birth' => 'required',
                //   'dependent_gender' => 'required',
                //   'qualification' => 'required',
                //   'specialization' => 'required',
                //   'completion' => 'required',
                //   'start_date' => 'required',
                //   'end_date' => 'required',
                //   'comments' => 'required',
                //   'emergency_firstname' => 'required',
                //   'emergency_lastname' => 'required',
                //   'emergency_relationship' => 'required',
                //   'emergency_mobile_number' => 'required',
                //   'emergency_phone_number' => 'required',
                //   'skill_name' => 'required',
                //   'experience' => 'required',
                //   'comments' => 'required',
                //   'employer' => 'required',
                //   //'experience_designation' => 'required',
                //   'job_description' => 'required',
                //   'period' => 'required',
                //   'language' => 'required',
                //   'fluency' => 'required',
                //   'ability' => 'required',
                //   'asset_name' => 'required',
                //   'model_number' => 'required',
                //   'issue_date' => 'required',
                //   'return_date' => 'required',
                //   'reference_firstname' => 'required',
                //   'reference_lastname' => 'required',
                //   'reference_address' => 'required',
                //   'reference_phone_number' => 'required',
                //   'reference_mobile_number' => 'required',
                //   'reference_email' => 'required',
                //   'reference_organisation' => 'required',
                //   'document_name' => 'required',
                //   'comment' => 'required',
                // //   'basic_salary' => 'required',
                // //   'allowances' => 'required',
                  'currency_type' => 'required',
                  'wages_type' => 'required',
                  'payment_mode' => 'required',
                  'bank_name' => 'required',
                  'bank_acc_no' => 'required',
                //   'file' => 'required|mimes:jpeg,bmp,png,pdf,doc,ppt,xls,docx,pptx,xlsx,rar,zip',
              ]);

              $company_id = Auth::user()->company_id;
              $user = User::where(['company_id' => $company_id])->get();
              $x = count($user) + 1;
              $employee_code = $x."/".$company_id."/".date('y');

              $profile = new EmployeeProfile();
              $profile->title = $request['title'];
              $profile->surname = $request['surname'];
              $profile->middlename = $request['middlename'];
              $profile->firstname = $request['firstname'];
              $profile->employee_code = $employee_code;
              $profile->designation = $request['designation'];
              $profile->grade = $request['grade'];
              $profile->branch = $request['branch'];
              $profile->department = $request['department'];
              $profile->category = $request['category'];
              $profile->branch = $request['branch'];
              $profile->join_date = $request['join_date'];
              $profile->company_id = Auth::user()->company_id;
              if($request->hasFile('file')){
                  $image = $request->file('file');
                  $filename = time().'.'.$image->getClientOriginalExtension();
                  $location = public_path('img/'.$filename);
                  Image::make($image)->resize(800,400)->save($location);
                  $profile->file = $filename;
              }
               $profile->save();
              $employee_id = $profile->id;
              $this->postPersonal($request, $employee_id);
              $this->postDependent($request, $employee_id);
              $this->postQualification($request, $employee_id);
              $this->postEmergency($request, $employee_id);
              $this->postSkills($request, $employee_id);
              $this->postExperience($request, $employee_id);
              $this->postLanguage($request, $employee_id);
              $this->postAssetAssigned($request, $employee_id);
              $this->postReferences($request, $employee_id);
              $this->postDocuments($request, $employee_id);
              $this->postSalary($request, $employee_id);
              $this->postUsers($request);
              return redirect()->back()->with(['success' => 'Successfully Created']);
                  }else{
              return Redirect::intended('login');
                  }
              }

      public function postUsers($request){

          $user = new User();
          $user->name  = "".$request['firstname']." ".$request['surname']."";
          $user->email = $request['official_email_address'];
          $user->phone = $request['telephone_number'];
          $user->password = Hash::make($request['middlename']);
          $user->company_id = Auth::user()->company_id;
          $user->pic = "resources/uploads/user.jpg";
          $user->address = $request['residential_address'];
          $user->level = "";
          $user->activated = 1;
          $user->corpfin_menutype = "";
          $user->save();
          $user_id = $user->id;
          $this->assign_role($user_id);
      }

      public function assign_role($user_id){
        $company_id = Auth::user()->company_id;
        $access_role = Access_roles::where(['company_id' => $company_id, 'role' => "Staff"])->first();
        if($access_role){
          $result = $this->add_to_string($access_role['users_id'],$user_id);
          Access_roles::where(['company_id' => $company_id, 'role' => "Staff"])->update(['users_id' => $result]);
        }else{
          $access_role = new Access_roles();
          $access_role->company_id = $company_id;
          $access_role->users_id = $user_id;
          $access_role->module = "CorpHRM";
          $access_role->role = "Staff";
          $access_role->save();
        }
      }

      public function  add_to_string($array,$new_item){
        $parts = explode(',',$array);
        if(array_search($item, $parts)){
          $parts[] = $new_item;
          $result = implode(',', $parts);
          return $result;
        }
      }

      public function postPersonal($request,$employee_id){
          // if (Auth::check()){
              $employee = new Employee();
              $employee->employee_id = $employee_id;
              $employee->company_id = Auth::user()->company_id;
             // $employee->sbirs = $request['sbirs'];
              $employee->residential_address =$request['residential_address'];
              $employee->permanent_address = $request['permanent_address'];
              $employee->religion = $request['religion'];
              $employee->telephone_no = $request['telephone_number'];
              $employee->mobile_no = $request['mobile_number'];
              $employee->official_email_address = $request['official_email_address'];
              $employee->national_id_no = $request['national_id_no'];
              $employee->driver_license_no = $request['driver_license_no'];
              $employee->state_of_origin = $request['state_of_origin'];
              $employee->local_govt_area = $request['local_govt_area'];
              $employee->personal_email_address =$request['personal_email_address'];
              $employee->blood_group = $request['blood_group'];
              $employee->genotype = $request['genotype'];
              $employee->hmo = $request['hmo'];
              $employee->postal_address = $request['postal_address'];
              $employee->pension_fund_administrator = $request['pension_fund_administrator'];
              $employee->pension_pin_no = $request['pension_pin_no'];
              $employee->no_of_children = $request['no_of_children'];
              $employee->name_of_spouse = $request['name_of_spouse'];
              $employee->gender = $request['gender'];
              $employee->date_of_birth = $request['date_of_birth'];
              $employee->phone_no_spouse = $request['phone_no_spouse'];
              $employee->marital_status = $request['marital_status'];
              $employee->nationality = $request['nationality'];
              $employee->city = $request['city'];
              $employee->country_address = $request['country_address'];
              //saving Image
              $employee->save();
              //return redirect()->back()->with(['success' => 'Successfully Created']);
                  // }
                  // else
                  // {
                  //     return Redirect::intended('login');
                  // }

                 }

    //Employee Dependent

          public function postDependent($request,$employee_id){
          // if (Auth::check()){
                  $dependent = new EmployeeDependent();
                  $dependent->firstname = serialize($request->input('dependent_firstname.*'));
                  $dependent->lastname = serialize($request->input('dependent_lastname.*'));
                  $dependent->relationship = serialize($request->input('dependent_relationship.*'));
                  $dependent->date_of_birth = serialize($request->input('dependent_date_of_birth.*'));
                  $dependent->gender = serialize($request->input('dependent_gender.*'));
                  $dependent->employee_id = $employee_id;
                  $dependent->company_id = Auth::user()->company_id;
                  $dependent->save();
              // return redirect()->back()->with(['success' => 'Successfully Created']);
              //   }
              //     else
              //     {
              //         return Redirect::intended('login');
              //     }
          }


         //Employee Qualification
            public function postQualification($request, $employee_id)
            {
                // if (Auth::check()) {
                  $qualification = new EmployeeQualification();
                  $qualification->employee_id = $employee_id;
                  $qualification->company_id = Auth::user()->company_id;
                  $qualification->qualification = serialize($request->input('qualification.*'));
                  $qualification->specialization = serialize($request->input('specialization.*'));
                  $qualification->year_of_completion = serialize($request->input('completion.*'));
                  $qualification->start_date = serialize($request->input('start_date.*'));
                  $qualification->end_date = serialize($request->input('end_date.*'));
                  $qualification->comments = serialize($request->input('comments.*'));
                  $qualification->save();
                  return redirect()->back()->with(['success' => 'Succesfully Created']);
                  // } else {
                  //     return Redirect::intended('login');
                  // }
          }



        //Emergency Details
    public function postEmergency($request, $employee_id)
    {
        // if (Auth::check()) {

                          $emergency = new EmployeeEmergency();
                          $emergency->firstname = serialize($request->input('emergency_firstname.*'));
                          $emergency->lastname = serialize($request->input('emergency_lastname.*'));
                          $emergency->relationship = serialize($request->input('emergency_relationship.*'));
                          $emergency->mobile_number = serialize($request->input('emergency_mobile_number.*'));
                          $emergency->phone_number = serialize($request->input('emergency_phone_number.*'));
                          $emergency->employee_id = $employee_id;
                          $emergency->company_id = Auth::user()->company_id;
                          $emergency->save();
                          return redirect()->back()->with(['success' => 'Successfully Created']);
                 // }
                 //     else
                 //     {
                 //         return Redirect::intended('login');
                 //     }

            }


         // Skills Details
            public function postSkills($request, $employee_id)
            {
                // if (Auth::check()) {
                    $skills = new EmployeeSkills();
                    $skills->skill_name = serialize($request->input('skill_name.*'));
                    $skills->year_of_experience = serialize($request->input('experience.*'));
                    $skills->comments = serialize($request->input('comments.*'));
                    $skills->employee_id = $employee_id;
                    $skills->company_id = Auth::user()->company_id;
                    $skills->save();
                    // return redirect()->back()->with(['success' => 'Succesfully Created']);
                    // } else {
                    //     return Redirect::intended('login');
                    // }
            }





    //Experience Details
    public function postExperience($request,$employee_id)
    {
                // if (Auth::check()) {
              $experience = new EmployeeExperience();
              $experience->employer = serialize($request->input('employer.*'));
              $experience->designation = serialize($request->input('experience_designation.*'));
              $experience->job_description = serialize($request->input('job_description.*'));
              $experience->period = serialize($request->input('period.*'));
              $experience->employee_id = $employee_id;
              $experience->company_id = Auth::user()->company_id;
              $experience->save();
          //     return redirect()->back()->with(['success'=>'Succesfully Created']);
          // }
          //     else
          //     {
          //         return Redirect::intended('login');
          //     }
          }

    //Languages
        public function postLanguage($request,$employee_id)
        {
            // if (Auth::check()) {
                $language = new EmployeeLanguage();
                $language->language = serialize($request->input('language.*'));
                $language->fluency = serialize($request->input('fluency.*'));
                $language->ability = serialize($request->input('ability.*'));
                $language->employee_id = $employee_id;
                $language->company_id = Auth::user()->company_id;
                $language->save();
                // return redirect()->back()->with(['success' => 'Succesfully Created']);

            // } else {
            //     return Redirect::intended('login');
            // }
        }
     //Asset Assigned
            public function  postAssetAssigned($request,$employee_id){
             // if (Auth::check()){
                $assets = new EmployeeAssets();
                $assets->asset_name = serialize($request->input('asset_name.*'));
                $assets->model_no = serialize($request->input('model_number.*'));
                $assets->issue_date = serialize($request->input('issue_date.*'));
                $assets->return_date = serialize($request->input('return_date.*'));
                 $assets->company_id = Auth::user()->company_id;
                $assets->employee_id = $employee_id;
                $assets->save();
             //    return redirect()->back()->with(['success'=>'Succesfully Created']);
             // }
             //     else
             //     {
             //         return Redirect::intended('login');
             //     }
            }
    //Refernces
            public function postReferences($request,$employee_id){
             // if (Auth::check()){

                $refrences = new EmployeeReferences();
                $refrences->firstname = serialize($request->input('reference_firstname.*'));
                $refrences->lastname = serialize($request->input('reference_lastname.*'));
                $refrences->address = serialize($request->input('reference_address.*'));
                $refrences->phone_number = serialize($request->input('reference_phone_number.*'));
                $refrences->mobile_no = serialize($request->input('reference_mobile_number.*'));
                $refrences->email_address = serialize($request->input('reference_email.*'));
                $refrences->organization = serialize($request->input('reference_organisation.*'));
                $refrences->employee_id = $employee_id;
                 $refrences->company_id = Auth::user()->company_id;
                $refrences->save();
                // return redirect()->back()->with(['success'=>'Succesfully Created']);
                //  }
                //  else
                //  {
                //      return Redirect::intended('login');
                //  }

                }


    //Document
            public function postDocuments($request,$employee_id){
             // if (Auth::check()) {

                 $document = new EmployeeDocument();
                 $filename = array();
                 $document->document_name = serialize($request->input('document_name.*'));
                     if ($request->hasFile('picture')) {
                         $images = $request->file('picture');
                         foreach($images as $image){
                         $filename = time() . '.' . $image->getClientOriginalExtension();
                         $location = public_path('uploads/doc/' . $filename);
                         $image->move($location, $filename);
                         $filename[] = array($filename);
                         }
                  }
                $document->file = $filename;
                $document->comments = serialize($request->input('comment.*'));
                 $document->company_id = Auth::user()->company_id;
                 $document->employee_id = $employee_id;
                $document->save();
                // return redirect()->back()->with(['success'=>'Successfully Created']);
                //  }
                //  else
                //  {
                //      return Redirect::intended('login');
                //  }

            }

    //Document
    public function postSalary($request,$employee_id){
        // if (Auth::check()) {

            $salary = new EmployeeSalary();
           $salary->currency_type = $request->input('currency_type');
           $salary->wages_type = $request->input('wages_type');
           $salary->payment_mode = $request->input('payment_mode');
           $salary->bank_name = $request->input('bank_name');
           $salary->bank_acc_no = $request->input('bank_acc_no');
            $salary->company_id = Auth::user()->company_id;
            $salary->employee_id = $employee_id;
           $salary->save();

       }

       public function bulk_staff_upload(Request $request){

        $company_id = Auth::user()->company_id;
        $user = User::where(['company_id' => $company_id])->get();
        $x = count($user) + 1;
        $employee_code = $x."/".$company_id."/".date('y');
        $file = $request->file('file')->getClientOriginalName();
        $ext =  $request->file('file')->getClientOriginalExtension();
        $request->file('file')->move(
            base_path() . '/public/uploads/files/staff_uploads/'.$company_id.'-'.date('Y-m-d').'/', $file
        );
        Excel::load('/public/uploads/files//staff_uploads/'.$company_id.'-'.date('Y-m-d').'/'.$file.'', function($reader) use ($rec_id, $Iprocess, $stage) {

            $results = $reader->get(array('title', 'surname', 'middlename','firstname','email','phone','join_date','account_no'));
            foreach ($results as $result){
                $res[] = [
                    'title' => $result->title,
                    'surname' => $result->surname,
                    'middlename' => $result->middlename,
                    'firstname' => $result->firstname,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'join_date' => $result->join_date,
                    'account_no' => $result->account_no,
                ];
            }
            foreach($res as $r){
               $profile = new EmployeeProfile();
               $profile->title = $r['title'];
               $profile->surname = $r['surname'];
               $profile->middlename = $r['middlename'];
               $profile->firstname = $r['firstname'];
               $profile->employee_code = $employee_code;
               $profile->designation = "";
               $profile->grade = "";
               $profile->branch = "";
               $profile->department = "";
               $profile->category = "";
               $profile->branch = "";
               $profile->join_date = $r['join_date'];
               $profile->company_id = $company_id;
                $profile->save();
               $employee_id = $profile->id;
               
               $employee = new Employee();
               $employee->employee_id = $employee_id;
               $employee->company_id = Auth::user()->company_id;
               $employee->save();


               $dependent = new EmployeeDependent();
               $dependent->employee_id = $employee_id;
               $dependent->company_id = Auth::user()->company_id;
               $dependent->save();

               
               $qualification = new EmployeeQualification();
               $qualification->employee_id = $employee_id;
               $qualification->company_id = Auth::user()->company_id;
                $qualification->save();


                $emergency = new EmployeeEmergency();
                $emergency->employee_id = $employee_id;
                $emergency->company_id = Auth::user()->company_id;
                $emergency->save();


                $skills = new EmployeeSkills();
                $skills->employee_id = $employee_id;
                $skills->company_id = Auth::user()->company_id;
                $skills->save();
                
                $experience = new EmployeeExperience();
                $experience->employee_id = $employee_id;
                $experience->company_id = Auth::user()->company_id;
                $experience->save();
                
                $language = new EmployeeLanguage();
                $language->employee_id = $employee_id;
                $language->company_id = Auth::user()->company_id;
                $language->save();

                $assets = new EmployeeAssets();
                $assets->company_id = Auth::user()->company_id;
               $assets->employee_id = $employee_id;
               $assets->save();

               $refrences = new EmployeeReferences();
               $refrences->employee_id = $employee_id;
                $refrences->company_id = Auth::user()->company_id;
               $refrences->save();

               $document = new EmployeeDocument();
               $document->company_id = Auth::user()->company_id;
               $document->employee_id = $employee_id;
              $document->save();

              $salary = new EmployeeSalary();
              $salary->bank_acc_no = $r['account_no'];;
               $salary->company_id = Auth::user()->company_id;
               $salary->employee_id = $employee_id;
              $salary->save();


              $user = new User();
              $user->name  = "".$r['firstname']." ".$r['surname']."";
              $user->email = $r['email'];
              $user->phone = $r['phone'];
              $user->password = Hash::make($r['middlename']);
              $user->company_id = Auth::user()->company_id;
              $user->pic = "resources/uploads/user.jpg";
              $user->address = "...";
              $user->level = "";
              $user->activated = 1;
              $user->corpfin_menutype = "";
              $user->save();
              $user_id = $user->id;
              $this->assign_role($user_id);
              

               return redirect()->back()->with(['success' => 'Successfully Created']);
            }
            
        });
       }

                public function update_employee($query,Request $request){
                     
                        $id = $request->input('id');
    
                    if($query == "profile"){
                        $file = NULL;
                        if($request->hasFile('file')){
                            $image = $request->file('file');
                            $filename = time().'.'.$image->getClientOriginalExtension();
                            $location = public_path('img/'.$filename);
                            Image::make($image)->resize(800,400)->save($location);
                            $file = $filename;
                        }

                        $employee_profile = EmployeeProfile::where('id',$id)->first();

                        EmployeeProfile::where('id', $id)->update([
                            "title" => $request['title'],
                            "surname" => $request['surname'],
                            "middlename" => $request['middlename'],
                            "firstname" => $request['firstname'],
                            "designation" => $request['designation'],
                            "grade" => $request['grade'],
                            "branch" => $request['branch'],
                            "department" => $request['department'],
                            "category" => $request['category'],
                            "join_date" => $request['join_date'],
                            "file" => $file

                        ]);


                        if($employee_profile['grade'] != $request['grade']){
                            $this->employee_track_log($id,"Grade",$employee_profile['grade']);
                            $grade = Grade::where('id',$employee_profile['grade'])->first();
                            $this->employee_track_log($id,"Salary",$grade['basic_salary']);
                        }
                        if($employee_profile['branch'] != $request['branch']){
                            $this->employee_track_log($id,"Branch",$employee_profile['branch']);
                        }                        
                        if($employee_profile['department'] != $request['department']){
                            $this->employee_track_log($id,"Department",$employee_profile['department']);
                        } 
                        if($employee_profile['designation'] != $request['designation']){
                            $this->employee_track_log($id,"Designation",$employee_profile['designation']);
                        } 
                        if($employee_profile['category'] != $request['category']){
                            $this->employee_track_log($id,"Category",$employee_profile['category']);
                        } 


                    }elseif ($query == "personal") {
                     Employee::where('id',$id)->update([
                        'residential_address' => $request['residential_address'],
                        'permanent_address' => $request['permanent_address'],
                        'religion' => $request['religion'],
                        'telephone_no' => $request['telephone_number'],
                        'mobile_no' => $request['mobile_number'],
                        'official_email_address' => $request['official_email_address'],
                        'national_id_no' => $request['national_id_no'],
                        'driver_license_no' => $request['driver_license_no'],
                        'state_of_origin' => $request['state_of_origin'],
                        'local_govt_area' => $request['local_govt_area'],
                        'personal_email_address' =>$request['personal_email_address'],
                        'blood_group' => $request['blood_group'],
                        'genotype' => $request['genotype'],
                        'hmo' => $request['hmo'],
                        'postal_address' => $request['postal_address'],
                        'pension_fund_administrator' => $request['pension_fund_administrator'],
                        'pension_pin_no' => $request['pension_pin_no'],
                        'no_of_children' => $request['no_of_children'],
                        'name_of_spouse' => $request['name_of_spouse'],
                        'gender' => $request['gender'],
                        'date_of_birth' => $request['date_of_birth'],
                        'phone_no_spouse' => $request['phone_no_spouse'],
                        'marital_status' => $request['marital_status'],
                        'nationality' => $request['nationality'],
                        'city' => $request['city'],
                        'country_address' => $request['country_address']
                     ]);
                    }elseif($query == "dependent"){
                        EmployeeDependent::where('id',$id)->update([
                        'firstname' => serialize($request->input('dependent_firstname.*')),
                        'lastname' => serialize($request->input('dependent_lastname.*')),
                        'relationship' => serialize($request->input('dependent_relationship.*')),
                        'date_of_birth' => serialize($request->input('dependent_date_of_birth.*')),
                        'gender' => serialize($request->input('dependent_gender.*'))
                        ]);
                    }elseif($query == "qualifications"){
                        
                        EmployeeQualification::where('id',$id)->update([
                        'qualification' => serialize($request->input('qualification.*')),
                        'specialization' => serialize($request->input('specialization.*')),
                        'year_of_completion' => serialize($request->input('completion.*')),
                        'start_date' => serialize($request->input('start_date.*')),
                        'end_date' => serialize($request->input('end_date.*')),
                        'comments' => serialize($request->input('comments.*')),
                        ]);
                    }elseif($query == "emergency"){
                        EmployeeEmergency::where('id',$id)->update([
                        'firstname' => serialize($request->input('emergency_firstname.*')),
                        'lastname' => serialize($request->input('emergency_lastname.*')),
                        'relationship' => serialize($request->input('emergency_relationship.*')),
                        'mobile_number' => serialize($request->input('emergency_mobile_number.*')),
                        'phone_number' => serialize($request->input('emergency_phone_number.*'))
                        ]);
                    }elseif($query == "skills"){
                       EmployeeSkills::where('id',$id)->update([
                        'skill_name' => serialize($request->input('skill_name.*')),
                        'year_of_experience' => serialize($request->input('experience.*')),
                        'comments' => serialize($request->input('comments.*'))
                       ]);
                    }elseif($query == "experience"){
                        EmployeeExperience::where('id',$id)->update([
                        'employer' => serialize($request->input('employer.*')),
                        'designation' => serialize($request->input('experience_designation.*')),
                        'job_description' => serialize($request->input('job_description.*')),
                        'period' => serialize($request->input('period.*')),
                        ]);
                    }elseif($query == "language"){
                        EmployeeLanguage::where('id',$id)->update([
                        'language' => serialize($request->input('language.*')),
                        'fluency' => serialize($request->input('fluency.*')),
                        'ability' => serialize($request->input('ability.*')),
                        ]);
                    }elseif($query == "assets"){
                        EmployeeAssets::where('id',$id)->update([
                        'asset_name' => serialize($request->input('asset_name.*')),
                        'model_no' => serialize($request->input('model_number.*')),
                        'issue_date' => serialize($request->input('issue_date.*')),
                        'return_date' => serialize($request->input('return_date.*'))
                        ]);
                    }elseif($query == "reference"){
                        
                        EmployeeReferences::where('id',$id)->update([
                        'firstname' => serialize($request->input('reference_firstname.*')),
                        'lastname' => serialize($request->input('reference_lastname.*')),
                        'address' => serialize($request->input('reference_address.*')),
                        'phone_number' => serialize($request->input('reference_phone_number.*')),
                        'mobile_no' => serialize($request->input('reference_mobile_number.*')),
                        'email_address' => serialize($request->input('reference_email.*')),
                        'organization' => serialize($request->input('reference_organisation.*'))
                        ]);
                    }elseif($query == "document"){

                        $filename = array();
                        $document->document_name = serialize($request->input('document_name.*'));
                            if ($request->hasFile('picture')) {
                                $images = $request->file('picture');
                                foreach($images as $image){
                                $filename = time() . '.' . $image->getClientOriginalExtension();
                                $location = public_path('uploads/doc/' . $filename);
                                $image->move($location, $filename);
                                $filename[] = array($filename);
                                }
                         }
                    EmployeeDocument::where('id',$id)->update([
                       'file' => $filename,
                       'comments' => serialize($request->input('comment.*')),
                        ]);
                    }
                    return redirect()->back()->with(['success'=>'Successfully Updated']);
                }

                private function employee_track_log($employee_id,$type,$previous){
 
                    $db = new EmployeeTrackLog();
                    $db->employee_id = $employee_id;
                    $db->company_id = Auth::user()->company_id;
                    $db->type = $type;
                    $db->previous = $previous;
                    $db->save();

                }

            }

