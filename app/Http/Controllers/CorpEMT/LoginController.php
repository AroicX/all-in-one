<?php 
namespace App\Http\Controllers\CorpEMT;

use Validator;
use Illuminate\Http\Request;
use Redirect;

//models//
use App\Models\CorpEMT\UsersModel;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->user = new UsersModel;
    }

    
    public function index()
    {
        return view('CorpEMT.login', ['page'=>'Login']);
    }


    //this method verifies user by the details they provide before it logs the in
    public function verify_user(Request $request)
    {
        $email         = $request->email;
        $password     = $request->password;

        //validating user email and password//
        $this->validate(
            $request, [
            'email'     => 'required',
            'password'     => 'required'
            ]
        );

        //check user details if it exist
        $check    = $this->user->check_user($email, $password);
        if ($check > 0) {
            $session_details     = $this->user->user_session_details($email, $password)[0];
            $user_id             = $session_details->id;
            $company_id         = $session_details->company_id;
            $session_token         = md5(uniqid());

            $save_session_details = $this->user->save_session_details($user_id, $session_token);
            if ($save_session_details == true) {
                $request->session()->set('session_token', $session_token);
                $request->session()->set('company_id', $company_id);
                $request->session()->set('user_id', $user_id);
                // 'company_id'=>$company_id, 'user_id'=>$user_id]);
                return redirect('dashboard');
            }
            else
            {
                return redirect('/')->with('alert', 'Session could not be registered, login again!');
            }
        }
        else
        {
            return redirect('/')->with('alert', 'Incorret login details!');
        }
    }


    /*log user out of the application*/
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('message', 'You\'ve successfully logged out!');
    }

}
