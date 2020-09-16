<?php 
namespace App\Http\Controllers\CorpEMT;
use Illuminate\Http\Request;
use App\Models\CorpEMT\UsersModel;
use App\Models\CorpEMT\CompanyModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;

class UsersController extends Controller
{
    use SubscriptionTrait;
    public function __construct()
    {
        $this->user     = new UsersModel;
        $this->company     = new CompanyModel;
    }

    private function ii()
    {
        $company_id = Auth::user()->company_id;
        $list_users     = $this->user->list_users($company_id);
        $list_company     = $this->company->list_company();
        $list_roles     = $this->user->list_roles();
        return view('CorpEMT.add_user', ['list_users'=>$list_users, 'list_company'=>$list_company, 'list_roles'=>$list_roles]);
    }

    public function index()
    {
        if (Auth::check()) {
            $query =  $this->ii();
            return $this->is_corpemt_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    public function add_user(Request $request)
    {
        $name         = $request->fullname;
        $email         = $request->email;
        $password     = $request->password;
        $company     = $request->company;
        $user_role    = $request->user_role;

        //valudating users input//
        $this->validate(
            $request, [
            'fullname'     => 'required',
            'email'     => 'required',
            'password'     => 'required',
            'company'    => 'required',
            'user_role'    => 'required'
            ]
        );

        //model//
        $feedback     = $this->user->add_user($name, $email, $password, $company, $user_role);

        return view('CorpEMT.add_user', ['feedback'=>$feedback]);
    }

}
