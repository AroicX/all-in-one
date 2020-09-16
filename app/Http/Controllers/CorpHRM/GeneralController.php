<?php
namespace App\Http\Controllers\CorpHRM;
use Illuminate\Http\Request;
use App\Traits\SubscriptionTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\Qualification;
use App\Models\CorpHRM\Allowance;
use App\Models\CorpHRM\Health;
use App\Models\CorpHRM\Pension;
use App\Models\CorpHRM\InternalRevenue;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Currency;
use App\Models\CorpHRM\Document;
use App\Models\CorpHRM\Weekoff;
use App\Models\CorpHRM\EmployeeCategory;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\Bank;
use App\Models\CorpHRM\Access_roles;
use App\Models\CorpHRM\Holiday;
use App\Models\CorpHRM\corphrm_email_templates;
use App\Models\CorpHRM\payroll\payroll;
use App\Models\CorpHRM\payroll\payroll_basic_settings;
use App\Models\CorpHRM\payroll\payroll_custom_settings;
use App\Models\CorpHRM\payroll\payroll_payee_settings;
use App\User;

class GeneralController extends Controller {
    use SubscriptionTrait;
    //    This is the General Controller
    //   Controller for Allowances and Deduction Settings

    public function ViewSettings()
    {
        if (Auth::check()) {

            $access_roles = Access_roles::all();
            $company_id = Auth::user()->company_id;
            $holidays = Holiday::where('company_id',$company_id)->orwhere('company_id',NULL)->get();
            $custom_settings = payroll_custom_settings::where('company_id', $company_id)->get();
			$basic_settings = payroll_basic_settings::where('company_id', $company_id)->get();
			$grades = Grade::where('company_id', $company_id)->get();
			$payee_type = payroll_payee_settings::where('company_id',Auth::user()->company_id)->first();
			$payee_type = $payee_type['name'];
            $branches = Branch::where('company_id',$company_id)->get();
            $grades = Grade::where('company_id', $company_id)->get();
            $banks = Bank::where('company_id', $company_id)->get();
            $pfas = Pension::where('company_id', $company_id)->get();
            $departments = Department::where('company_id', $company_id)->get();
            $currencies = Currency::where('company_id', $company_id)->get();
            $healths = Health::where('company_id', $company_id)->get();
            $internalrevenues = InternalRevenue::where('company_id', $company_id)->get();
            $weekends = Weekoff::where('company_id', $company_id)->first();
            $designations = Designation::where('company_id', $company_id)->get();
            $documents = Document::where('company_id', $company_id)->get();
            $qualifications = Qualification::where('company_id', $company_id)->get();
            $corphrm_email_templates = corphrm_email_templates::where('company_id',$company_id)->get();
            $query =  view('CorpHRM.settings',[
                'access_roles' => $access_roles, 
                'holidays' => $holidays, 
                'branches' => $branches, 
                'grades' => $grades,
                'weekends' => $weekends,
                'custom_settings' => $custom_settings,
                'basic_settings' => $basic_settings, 
                'grades' => $grades, 
                'payee_type' => $payee_type,
                'banks' => $banks,
                'pfas' => $pfas,
                'documents' =>$documents,
                'healths' => $healths,
                'departments' => $departments,
                'currencies' => $currencies,
                'internalrevenues' => $internalrevenues,
                'designations' => $designations,
                'corphrm_email_templates' => $corphrm_email_templates,
                'qualifications' => $qualifications
                ]); 
            return $this->is_corphrm_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }
           public function postAllowances(Request $request){
           if (Auth::check()){
               $this->validate($request,[
                   'name' => 'required',
                   'type' => 'required',
                   'is_taxable' => 'required',
                   'mode' => 'required',
                   'value' => 'required',
                   'effective_month' => 'required',
                   'calculate' => 'required',
                   'assign_to_grade' => 'required',
                   'nature' => 'required'
               ]);
               $allowance = new Allowance();
               $allowance->name = $request['name'];
               $allowance->type = $request['type'];
               $allowance->is_taxable = $request['is_taxable'];
               $allowance->mode = $request['mode'];
               $allowance->frequency = $request['frequency'];
               $allowance->value = $request['value'];
               $allowance->effective_month = $request['effective_month'];
               $allowance->calculate = $request['calculate'];
               $allowance->assign_to_grade = $request['assign_to_grade'];
               $allowance->nature = $request['nature'];
               $allowance->company_id = Auth::user()->company_id;
               $allowance->save();
               return redirect()->back()->with(['success' => 'Successfully Created']);
           }
                else
                {
                return Redirect::intended('login');
                }
           }



        public function postHealth(Request $request){
                if (Auth::check()){
                    $this->validate($request,[
                        'name' => 'required',
                        'address' => 'required',
                        'phone' => 'required'
                    ]);
                     $health = new Health();
                     $health->name = $request['name'];
                     $health->address = $request['address'];
                     $health->phone = $request['phone'];
                     $health->company_id = Auth::user()->company_id;
                     $health->save();
                    return redirect()->back()->with(['success' => 'Successfully Created']);
                        }
                        else
                            {
                                return Redirect::intended('login');
                            }
                }

        public function postBranches(Request $request){
                    if (Auth::check()){
                        $this->validate($request,[
                          'name' => 'required',
                            'code' => 'required',
                            'city' => 'required',
                            'state' => 'required'
                        ]);

                        $branch = new Branch();
                        $branch->name = $request['name'];
                        $branch->code = $request['code'];
                        $branch->city = $request['city'];
                        $branch->state = $request['state'];
                        $branch->company_id = Auth::user()->company_id;
                        $branch->save();
                        return redirect()->back()->with(['success' => 'Successfully Created']);
                         }
                            else
                                {
                                    return Redirect::intended('login');
                                }
                     }

        public function postDepartments(Request $request){
                    if (Auth::check()){
                        $this->validate($request,[
                            'name' => 'required',
                            'code' => 'required',
                            'description' => 'required'
                        ]);
                        $department = new Department();
                        $department->name = $request['name'];
                        $department->code = $request['code'];
                        $department->description = $request['description'];
                        $department->company_id = Auth::user()->company_id;
                        $department->save();
                        return redirect()->back()->with(['success' => 'Successfully Created']);
                            }
                        else
                            {
                                return Redirect::intended('login');
                            }
                            }

                            
        public function postAccess_roles(Request $request){
            if(Auth::check()){
                $company_id = Auth::user()->company_id;
                    $access_roles = Access_roles::where(['role' => $request['role'], 'company_id' => $company_id])->count();
                    if($access_roles > 1){
                        return redirect()->back()->with(['error' => 'Role already Created!']);
                    } 
                    $permission = $request['permission'];
                    $permissions = implode(',',$permission);
                    $access_roles = new Access_roles();
                    $access_roles->role = $request['role'];
                    $access_roles->role_description = $request['description'];
                    $access_roles->module = "CorpHRM";
                    $access_roles->permissions = $permissions;
                    $access_roles->company_id = Auth::user()->company_id;
                    $access_roles->save();
                    return redirect()->back()->with(['success' => 'Successfully Created']);

            }
            else
            {
                return Redirect::intended('login');
            }
        }
                    public function postCurrencies(Request $request){
                    if (Auth::check()){
                        $this->validate($request,[
                            'name' => 'required',
                            'symbol' => 'required',
                            'sub_name' => 'required'
                        ]);
                        $currency = new Currency();
                        $currency->name = $request['name'];
                        $currency->symbol = $request['symbol'];
                        $currency->sub_name = $request['sub_name'];
                        $currency->company_id = Auth::user()->company_id;
                        $currency->save();
                        return redirect()->back()->with(['success' => 'Successfully Created']);
                            }
                            else
                                {
                                    return Redirect::intended('login');
                                }
                            }

                    public function postQualification(Request $request){
                    if (Auth::check()){
                        $this->validate($request,[
                            'name' => 'required',
                            'description' => 'required'
                        ]);
                        $qualification = new Qualification();
                        $qualification->name = $request['name'];
                        $qualification->description = $request['description'];
                        $qualification->company_id = Auth::user()->company_id;
                        $qualification->save();
                        return redirect()->back()->with(['success' => 'Successfully Created']);
                        }
                        else
                            {
                                return Redirect::intended('login');
                            }
                        }

                            public function postDocument(Request $request){
                            if (Auth::check()){
                                $this->validate($request,[
                                    'name' => 'required',
                                    'comment' => 'required'
                                ]);
                                $document = new Document();
                                $document->name = $request['name'];
                                $document->comment = $request['comment'];
                                $document->company_id = Auth::user()->company_id;
                                $document->save();
                                return redirect()->back()->with(['success' => 'Successfully Created']);
                                }
                                else
                                    {
                                        return Redirect::intended('login');
                                    }
                                }

                        public function postWeekoff(Request $request){
                        if (Auth::check()){
                            $this->validate($request,[
                                'days' => 'required'
                            ]);
                            $check = Weekoff::where('company_id',Auth::user()->company_id)->get();
                            if(count($check) > 0){
                                $days = array();
                                $check = Weekoff::where('company_id',Auth::user()->company_id)->first();
                                foreach($request['days'] as $day){
                                    $search = array_search($day, json_decode($check['days']));
                                    if(!$search){
                                        $days[] = $day;
                                    }

                                }
                                $day = json_encode($days);
                                Weekoff::where('company_id',Auth::user()->company_id)->update([
                                    'days' => $day
                                ]);
                            }else{

                                $weekoff = new Weekoff();
                                $weekoff->days = json_encode($request['days']);
                                $weekoff->company_id = Auth::user()->company_id;
                                $weekoff->save();

                            }
                            return redirect()->back()->with(['success' => 'Successfully Created']);
                        }
                                else
                                    {
                                        return Redirect::intended('login');
                                    }
                                }

                            public function postCategory(Request $request){
                            if (Auth::check()){
                                $this->validate($request,[
                                    'name' => 'required',
                                    'description' => 'required'
                                ]);
                                $category = new EmployeeCategory();
                                $category->name = $request['name'];
                                $category->description = $request['description'];
                                $category->company_id = Auth::user()->company_id;
                                $category->save();
                                return redirect()->back()->with(['success' => 'Successfully Created']);

                                }
                                else
                                    {
                                        return Redirect::intended('login');
                                    }
                                }
                                public function postGrades(Request $request){
                                if (Auth::check()){
                                    $this->validate($request,[
                                        'name' => 'required',
                                        'basic_salary' => 'required',
                                        'description' => 'required'
                                    ]);
                                    $grade  = new Grade();
                                    $grade->name = $request['name'];
                                    $grade->basic_salary = $request['basic_salary'];
                                    $grade->description = $request['description'];
                                    $grade->company_id = Auth::user()->company_id;
                                    $grade->save();
                                    return redirect()->back()->with(['success' => 'Successfully Created']);
                                        }
                                        else
                                            {
                                                return Redirect::intended('login');
                                            }
                                        }

                                public function postDesignation(Request $request){
                                if (Auth::check()){
                                    $this->validate($request,[
                                        'name' => 'required',
                                        'parent' => 'required',
                                        'is_managerial' => 'required',
                                        'is_main' => 'required'
                                    ]);
                                    $designation = new Designation();
                                    $designation->name = $request['name'];
                                    $designation->parent = $request['parent'];
                                    $designation->is_mangerial_post = $request['is_managerial'];
                                    $designation->is_main_designation = $request['is_main'];
                                    $designation->company_id = Auth::user()->company_id;
                                    $designation->save();
                                    return redirect()->back()->with(['success' => 'Successfully Created']);
                                    }
                                    else
                                        {
                                            return Redirect::intended('login');
                                        }
                                    }

                            public function postBanks(Request $request){
                            if (Auth::check()){
                                $this->validate($request,[
                                    'name' => 'required',
                                    'code' => 'required',
                                    'branch' => 'required',
                                    'sort_code' => 'required',
                                ]);
                                $bank = new Bank();
                                $bank->name = $request['name'];
                                $bank->code = $request['code'];
                                $bank->branch = $request['branch'];
                                $bank->sort_code =  $request['sort_code'];
                                $bank->company_id = Auth::user()->company_id;
                                return redirect()->back()->with(['success' => 'Successfully Created']);
                                }
                                else
                                    {
                                        return Redirect::intended('login');
                                    }
                                }

                            public function postHolidays(Request $request){
                            if (Auth::check()){
                                $this->validate($request,[
                                    'holiday_name' => 'required',
                                    'branch' => 'required',
                                    'date_from' => 'required',
                                    'category' => 'required',
                                    'date_to' => 'required',
                                    'message' => 'required',
                                    'repeat_annually' => 'required'
                                ]);
                                $holiday = new Holiday();
                                $holiday->holiday_name = $request['holiday_name'];
                                $holiday->branch = $request['branch'];
                                $holiday->date_from = $request['date_from'];
                                $holiday->category = $request['category'];
                                $holiday->message = $request['message'];
                                $holiday->date_to = $request['repeat_annually'];
                                $holiday->company_id = Auth::user()->company_id;
                                $holiday->save();
                                return redirect()->back()->with(['success' => 'Successfully Created']);
                                }
                                else
                                    {
                                        return Redirect::intended('login');
                                    }
                                }



                                public function postInternal(Request $request){
                                if (Auth::check()){
                                    $this->validate($request,[
                                        'name' => 'required',
                                        'address' => 'required',
                                        'state' => 'required'
                                    ]);
                                    $internal = new InternalRevenue();
                                    $internal->name = $request['name'];
                                    $internal->address = $request['address'];
                                    $internal->state = $request['state'];
                                    $internal->company_id = Auth::user()->company_id;
                                    $internal->save();
                                    return redirect()->back()->with(['success' => 'Successfully Created']);
                                    }
                                    else
                                        {
                                            return Redirect::intended('login');
                                        }
                                }
                                public function post_email_template(Request $request){
                                    if (Auth::check()){
                                        $this->validate($request,[
                                            'category' => 'required',
                                            'title' => 'required',
                                            'body' => 'required',
                                        ]);

                                        if(count(post_email_template::where(['company_id' => Auth::user()->company_id,'category' => $request['category']])->get()) > 0){
                                            corphrm_email_templates::where(['company_id' => Auth::user()->company_id,'category' => $request['category']])->update(['body' => $request['body'],'category' => $request['category'],'title' => $request['title']]);
                                        }else{
                                            $email_templates = new corphrm_email_templates();
                                            $email_templates->title = $request['title'];
                                            $email_templates->category = $request['category'];
                                            $email_templates->body = $request['body'];
                                            $email_templates->company_id = Auth::user()->company_id;
                                            $email_templates->save();
                                        }
                                        return redirect()->back()->with(['success' => 'Successfully Added*']);
                                    }else{
                                        return Redirect::intended('login');
                                    }                                    
                                }
                                public function postPension(Request $request){
                                if (Auth::check()){
                                    $this->validate($request,[
                                        'name' => 'required',
                                        'address' => 'required',
                                        'phone' => 'required',
                                        'reporting_bank' => 'required',
                                        'account_no' => 'required'
                                    ]);
                                    $pension = new Pension();
                                    $pension->name = $request['name'];
                                    $pension->address = $request['address'];
                                    $pension->phone = $request['phone'];
                                    $pension->reporting_bank = $request['reporting_bank'];
                                    $pension->account_no = $request['account_no'];
                                    $pension->company_id = Auth::user()->company_id;
                                    $pension->save();
                                    return redirect()->back()->with(['success' => 'Successfully Created']);
                                        }
                                        else
                                            {
                                                return Redirect::intended('login');
                                            }
                                        }

                                    public  function  Delete(Request $request){

                                        $company_id = Auth::user()->company_id;
                                        $type =$request->get('type');
                                        $id = $request->get('id');

                                        if($type == 'role' || $type == 'Role'){

                                            Access_roles::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }
                                        if($type == 'grade' || $type == 'Grade'){
                                            
                                            Grade::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }
                                        if($type == 'pfa' || $type == 'Pfa'){
                                            Pension::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }
                                        if($type == 'Health' || $type == 'health'){
                                            Health::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }
                                        if($type == 'Internal_revenue' || $type == 'internal_revenue'){
                                            InternalRevenue::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        } 
                                        if($type == 'Branch' || $type == 'branch'){
                                            Branch::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        } 
                                        if($type == 'Department' || $type == 'department'){
                                            Department::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Currency' || $type == 'currency'){
                                            Currency::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Qualification' || $type == 'qualification'){
                                            Qualification::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Document' || $type == 'document'){
                                            Document::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Category' || $type == 'category'){
                                            EmployeeCategory::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Designation' || $type == 'designation'){
                                            Designation::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                        if($type == 'Bank' || $type == 'bank'){
                                            Bank::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        } 
                                        if($type == 'Holiday' || $type == 'holiday'){
                                            Holiday::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }
                                        if($type == 'Email_template' || $type == 'email_template'){
                                            corphrm_email_templates::where(['id' => $id, 'company_id' => $company_id])->delete();
                                        }  
                                                                           

                                        return redirect()->back()->with(['success' => 'Successfully Deleted']);
                                    }

                                    public function Edit(Request $request){
                                        $type =$request->get('type');
                                        $id = $request->get('id');
                                        $company_id = Auth::user()->company_id;
                                        if($type == "employees"){
                                        $action = $request->get('action');
                                        if($action == "Suspend"){
                                            User::where(['id' => $id, 'company_id' => $company_id])->update([
                                                'status' => 'Suspend'
                                            ]);
                                        }
                                        if($action == "Retire"){
                                            User::where(['id' => $id, 'company_id' => $company_id])->update([
                                                'status' => 'Retire'
                                            ]);
                                        }
                                        if($action == "Active"){
                                            User::where(['id' => $id, 'company_id' => $company_id])->update([
                                                'status' => 'Active'
                                            ]);
                                        }
                                        }
                                        return redirect()->back()->with(['success' => 'Successfully Updated']);
                                    }

                                 }



