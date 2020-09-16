<?php
namespace App\Http\Controllers\CorpHRM;
use App\Traits\SubscriptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\claims\ClaimMaster;
use App\Models\CorpHRM\claims\ClaimApplication;
use App\Models\CorpHRM\EmployeeProfile;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\corphrm_email_templates;
use App\Models\CorpHRM\Access_roles;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Company;

class ClaimController extends Controller
{
    use SubscriptionTrait;
    public function getClaimMaster(Request $request)
    {   
        if (Auth::check()) {
            $grades = Grade::where('company_id',Auth::user()->company_id)->get();
            if($request->get('action') == "edit" || $request->get('action') == "Edit"){
                if($request->get('id')){
                $master = ClaimMaster::where(['id'=> $request->get('id'), 'company_id' => Auth::user()->company_id])->first();
                return view('CorpHRM.Claim.claim_master',['master' => $master, 'grades' => $grades, 'action' => "Edit"]);  
                }else{
                    return view('CorpHRM.Claim.claim_master',['grades' => $grades,'action' => "New"]);
                }
            }

            return view('CorpHRM.Claim.claim_master',['grades' => $grades,'action' => "New"]);

        }else{
        
         return Redirect::intended('login');
        }
    }

    public function addClaimMaster(Request $request){
		//todo: Validate
        if (Auth::check()) {
            $check = ClaimMaster::where(['grade_id'=> $request->grade, 'company_id' => Auth::user()->company_id])->first();
            if($check){
                return redirect('corphrm/claim_master/new')->with('error', 'claim master already done for grade!');
                //Redirect::back()->with('error', 'claim master already registerd!');
            }else{
                
                $db = new ClaimMaster();
                $db->name = $request->claim_name;
                $db->grade_id = $request->grade;
                $db->max_limit = $request->claim_max_limit;
                $db->company_id = Auth::user()->company_id;
            	$db->save();
                $success = true;
               return redirect()->back()->with(['success' => 'Successfully Created']);
               //view('CorpHRM.Claim.claim_master',compact('success'));
            }

        }else{
        
         return Redirect::intended('login');
        }

    }

    public function getClaimApplication(Request $request)
    {   
        if (Auth::check()) {
            $claims = ClaimMaster::get();
            $count = ClaimApplication::where(['company_id' => Auth::user()->company_id])->get();
            $trans_id = count($count) + 1;
            $user_id = Auth::user()->id;
            $EmployeeProfile = EmployeeProfile::where('user_id',$user_id)->first();
            $company_id = Auth::user()->company_id;
            $action = "New";
            $claimmaster = ClaimMaster::where(['company_id' => $company_id, 'grade_id' => $EmployeeProfile['grade']])->first();
            if($request->get('action') == "edit" || $request->get('action') == "Edit"){
                if($request->get('id')){
                    $action = "Edit";
                    $app = ClaimApplication::where(['id'=> $request->get('id'), 'company_id' => Auth::user()->company_id])->first();
                    $employee = User::where('id',$app['employee_id'])->first();
                    $app = [
                        'transaction_id' => $app['transaction_id'],
                        'transaction_date' => $app['transaction_date'],
                        'employee_name' => $employee['name'],
                        'claims_date' => $app['claims_date'],
                        'expense_type' => $app['expense_type'],
                        'amount' => $app['amount'],
                        'purpose' => $app['purpose']
                    ];
                    return view('CorpHRM.Claim.claim_application', ['claimmaster' => $claimmaster, 'trans_id' => $trans_id,'action' => $action,'app' => $app]);
                }else{
                    return view('CorpHRM.Claim.claim_application', compact('claimmaster', 'trans_id','action'));
                }
                }else{
                    return view('CorpHRM.Claim.claim_application', compact('claimmaster', 'trans_id','action'));
                }
        }else{
        
         return Redirect::intended('login');
        }
    }

    public function addClaimApplication(Request $request, $id){
    	//todo: Validate
        if (Auth::check()) {
            $check = ClaimMaster::where('id',$request->claimmaster_id)->first();
            if($request->amount > $check['max_limit']){
                return redirect('corphrm/claim_application/new')->with('error', 'claim Limit exceeded!');
                //Redirect::back()->with('error', 'claim Limit exceeded!');
            }else{

        		$db = new ClaimApplication();
            	$db->transaction_date = date('Y-m-d H:i:s');//$request->transaction_date;
            	$db->transaction_id = $id;
            	$db->employee_id = Auth::user()->id;
                $db->claimmaster_id = $request->claimmaster_id;
            	$db->claims_date = $request->claim_date;
            	$db->expense_type = $request->expense_type;
            	$db->amount = $request->amount;
            	$db->purpose = $request->purpose;
        		$db->company_id = Auth::user()->company_id;
            	$request->file('doc')->store('uploads');
            	$db->save();
            }
        	$success = true;
        	$claimmaster = ClaimMaster::get();
            $trans_id = rand(1,1000000);
            return redirect()->back()->with(['success' => 'Successfully Created']);
        //	return view('CorpHRM.Claim.claim_application',compact('success','trans_id','claimmaster'));
        }else{
        
         return Redirect::intended('login');
        }

    }

    public function getAllClaims()
    {   
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $claims = ClaimApplication::where('company_id',$company_id)->get();
            $branches = Branch::where(['company_id' => $company_id])->get();
            return view('CorpHRM.Claim.list_claim',['claims' => $claims, 'branches' => $branches,'type' => "All"]);
        }else{
        
         return Redirect::intended('login');
        }
    }

    public function getMyClaims()
    {   
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $user_id = Auth::user()->id;
            $claims = ClaimApplication::where(['company_id'=>$company_id, 'employee_id' => $user_id])->get();

            return view('CorpHRM.Claim.list_claim',['claims' => $claims,'type' => "My"]);
        }else{
        
         return Redirect::intended('login');
        }
    }

    public function getAllClaimsMaster()
    {   
        if (Auth::check()) {
            $company_id =  Auth::user()->company_id;
            $claimsmaster = ClaimMaster::where('company_id',$company_id)->get();

            return view('CorpHRM.Claim.list_claimmaster',['claimsmaster' => $claimsmaster]);

        }else{
        
         return Redirect::intended('login');
        }
    }

    public function UpdateClaim(Request $request)
    {   
        if (Auth::check()) {
            $id = $request->get('id');
            $status = $request->get('status');

            if($status == "Level1"){
                ClaimApplication::where('id',$id)->update(['status' => "1",'approved_by' => Auth::user()->id]);
            }
            if($status == "Level2"){
                ClaimApplication::where('id',$id)->update(['status' => "2",'approved_by' => Auth::user()->id]);
            }
            if($status == "Cancel"){
                ClaimApplication::where('id',$id)->update(['status' => "0",'approved_by' => Auth::user()->id]);
            }
            return redirect()->back()->with('success', 'Action successful');
        }else{
        
         return Redirect::intended('login');
        }

    }

    public function edit(Request $request){
   
        $id = $request->id;
        $cat = $request->get('cat');
        $company_id = Auth::user()->company_id;

            if($cat == "master"){
                ClaimMaster::where(['id' => $id, 'company_id' => $company_id])->update([
                    'name' => $request->claim_name,
                    'grade_id' => $request->grade,
                    'max_limit' => $request->claim_max_limit
                ]);
            }
            if($cat == "app"){
                ClaimApplication::where(['id' => $id, 'company_id' => $company_id])->update([
                'transaction_id' => $id,
                'claimmaster_id' => $request->claimmaster_id,
            	'claims_date' => $request->claim_date,
            	'expense_type' => $request->expense_type,
            	'amount' => $request->amount,
                'purpose' => $request->purpose
                ]);     
            }
            return redirect()->back()->with(['success' => 'Successfully Updated']);

  
    
    }

    public function delete(Request $request){
        $id = $request->get('id');
        $cat = $request->get('cat');
        $company_id = Auth::user()->company_id;
        if($cat == "master"){
            $count = ClaimApplication::where(['claimmaster_id' => $id, 'company_id' => $company_id])->get();
            if(count($count) > 0){
                return redirect()->back()->with(['success' => 'Unable to delete! Master is currently used by some Applications']);
            }else{
                ClaimMaster::where(['id' => $id, 'company_id' => $company_id])->delete();
            }
        }
        if($cat == "app"){
            return redirect()->back()->with(['success' => 'Unable to delete! currently processing application']);
            //ClaimApplication::where(['id' => $id, 'company_id' => $company_id])->delete();  
        }
        return redirect()->back()->with(['success' => 'Successfully Deleted']);
    }

    /*
    *Email Templates
    */
    public function claim_app_admin_template(){

        $company_id = Auth::user()->company_id;
        $template = corphrm_email_templates::where(['company_id' => $company_id, 'category' => "claim_app_admin"])->first();
        $title = $template['title'];
        $body = $template['body'];
        $company_details = Company::where('id',$company_id)->first();
        $access_roles = Access_roles::where(['company_id' => $company_id])->get();
        foreach($access_roles as $access_role){
            $exploded_permission = explode(',',$access_role->permissions);
            if(array_search()){
                $exploded_users = explode(',',$access_role->users_id);
                foreach($exploded_users as $user_id){
                    $user = User::where(['id' => $user_id,'status' => "Active"])->first();
                    $this->claim_app_email('noreply@corperm.pro', $company_details['name'], $user['email'], $user['name'],$title);                
                }
            }
        }

    }

    public function claim_app_user_template(){

        $company_id = Auth::user()->company_id;
        $template = corphrm_email_templates::where(['company_id' => $company_id, 'category' => "claim_app_user"])->first();
        $title = $template['title'];
        $body = $template['body'];
        $company_details = Company::where('id',$company_id)->first();
        $access_roles = Access_roles::where(['company_id' => $company_id])->get();
        foreach($access_roles as $access_role){
            $exploded_permission = explode(',',$access_role->permissions);
            if(array_search()){
                $exploded_users = explode(',',$access_role->users_id);
                foreach($exploded_users as $user_id){
                    $user = User::where(['id' => $user_id,'status' => "Active"])->first();
                    $this->claim_app_email('noreply@corperm.pro', $company_details['name'], $user['email'], $user['name'],$title);                
                }
            }
        }
 
    }

    private function claim_app_email($from_email,$from_name,$to_email,$to_name,$title,$content){
        Mail::send(
            'CorpPay.emails.mail', ['title'=>$title,'content'=>$content], function ($message) use ($from_email,$from_name,$to_email,$to_name) {
                //get $method->from() parameter from the company table
                $message->from($from_email, $from_name);
                $message->to($to_email);
            }
        );
    }
 
}
