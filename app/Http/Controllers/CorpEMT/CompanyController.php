<?php
namespace App\Http\Controllers\CorpEMT;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpEMT\CompanyModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;

class CompanyController extends Controller
{
    use SubscriptionTrait;

    public function __construct()
    {
        $this->company = new CompanyModel;
    }

    public function index(){
        if (Auth::check()) {
            $query = $this->ii();

            return $this->is_corpemt_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }

    private function ii(){
        $list_company = $this->company->list_company();
        return view('CorpEMT.add_company', ['list_company' => $list_company]);
    }


    private function a_d(Request $request){
        $name = $request->name;
        $email = $request->email;
        //validation//
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);

        //model//
        $feedback = $this->company->add_company($name, $email);

        return view('CorpEMT.add_company', ['feedback' => $feedback]);
    }

    public function add_company()
    {
        if (Auth::check()) {
            $query = $this->a_d();
            return $this->is_corpemt_user_set($query);
        } else {
            return Redirect::intended('login');
        }
    }
}
