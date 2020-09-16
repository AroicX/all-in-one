<?php

namespace App\Http\Controllers\Auth;

use App\Models\Activation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\CorpHRM\Access_roles;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Models\Role;
use Carbon\Carbon;
use App\inventory\Warehouse;
use App\Traits\GenerateCodeTrait;
use App\Jobs\AccountActivationJob;

class RegisterController extends Controller
{
    use GenerateCodeTrait;
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {

        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'fullname'            => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required|min:6|max:20',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'fullname.required'   => 'First Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]
        );

        return $validator;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function register(Request $request){

        $this->validator($request->all())->validate();
        $token = $this->generate_code('activations','11','token');
        $today = Carbon::today();
        $user_data =  [
            'name' => $request->input('fullname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'company_id' => 0,
            'pic' => "resources/uploads/user.jpg",
            'activated' => 0,
            'phone' => "",
            'address' => "",
            'corpfin_menutype' => ""
        ];

        // Send Activation Email
        $recepient = $request->input('email');
        $name = $request->input('fullname');
        // $email_job = (new AccountActivationJob($recepient, $name, $token))->delay(Carbon::now()->addSeconds(3));
        // dispatch($email_job);
        // $activation_mail = $this->activation_email($recepient, $name, $token);
        // if($activation_mail){
            // Create User Account
            $user =  User::create($user_data);
            //save activation token
            $this->store_activation($user, $token, $today);
        // }else{
        //     return redirect('/register')->with('message', 'Error sending activation Email. Check Email and try again')->with('status', 'error');
        // }

        return redirect($this->redirectPath())->with('message', 'Check Email to complete Registration')
        ->with('status', 'success');
    }

    public function store_activation($user,$token,$today)
    {
        $user_id = $user->id;

        $activation = array(
        'user_id'=>$user_id,
        'token'=>$token,
         'created_at'=>$today,
         'status'=>0
        );

        Activation::create($activation);
    }


    public function activation_email($recepient,$name,$token)
    {
        $data = [
            'name'=>$name,
            'token'=>$token,
            'recepient'=>$recepient
        ];
        Mail::send(

            'Mail.Account_activation', $data, function ($message) use ($recepient, $name) {
                $message->to($recepient, $name)->subject('Activate Account');
                $message->from('noreply@corperm.com', 'CorpERM');
            }
        );
        if(Mail::failures()){
            return false;
        }else{
            return true;
        }
    }


    public function Complete_registration($token)
    {
        $exist = Activation::where(['token' => $token, 'status' => "0"])->get();

        if (count($exist) > 0) {
            $activation_detail = Activation::where('token',$token)->first();
            Activation::where('id',$activation_detail['id'])->update(['status' => "1"]);
            User::where('id',$activation_detail['user_id'])->update(['activated' => "1"]);
            return redirect($this->redirectPath())
            ->with('message', 'Congratulations! Your registration complete. You may now login')
            ->with('status', 'success');
        }
        else{

            return Redirect::intended('login')
                ->with('message', 'Invalid Registration Token')
                ->with('status', 'danger')
                ->withInput();

        }
    }

}