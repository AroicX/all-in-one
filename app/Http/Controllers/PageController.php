<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use Response;
use Validator;
use Input;
use Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;


class PageController extends SubscriptionController
{
    public function dashboard(){

        if (Auth::check()) {
            return view('panel.Dashboard');
        } else {
            return Redirect::intended('login');
        }
    }

    public function error_404(){
        return print_r("ERROR 404");
    }

    public function profile(){
        if (Auth::check()) {
            return view('panel.Profile');
        } else {
            return Redirect::intended('login');
        }
    }

    public function general_update(Request $request){
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $where = array('id' => $user_id);
            $data = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            );
            $query = DB::table('users')->where($where)->update($data);
            if ($query) {
                return json_encode(['result' => 'success']);
            } else {
                return json_encode(['result' => 'fail']);
            }
        } else {
            return json_encode(['result' => 'login']);
        }
    }

    public function password_update(Request $request){
        if (Auth::Check()) {
            $current_password = Auth::User()->password;
            if (Hash::check($request->input('old_password'), $current_password)) {
                $user_id = Auth::User()->id;
                $password = Hash::make($request->input('password'));;
                $where = array(
                    'id' => $user_id
                );
                $data = array(
                    'password' => $password
                );
                $query = DB::table('users')->where($where)->update($data);
                if ($query) {
                    return json_encode(['result' => 'success']);
                } else {
                    return json_encode(['result' => 'fail']);
                }
            } else {
                $error = "Current password is Incorrect!";
                return json_encode(['result' => 'val_fail', 'error' => $error]);
            }

        } else {
            return json_encode(['result' => 'login']);
        }
    }

    public function picture_update(Request $request){
        if (Auth::Check()) {


            // return $request->all();
            $user_id = Auth::user()->id;

            // $validator = Validator::make($request->image,
            //     [
            //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //     ],
            //     [
            //         'image.required' => 'Select Picture to Upload',
            //         'image.image' => 'Select a valid Image & Try Again!',
            //         'image.max' => 'Image size cannot exceed 2MB!',
            //         'image.mimes' => 'Image format not supported!',
            //     ]
            // );
           
              
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/images/users'), $imageName);
                $where = array(
                    'id' => $user_id
                );
                $data = array(
                    'pic' => 'uploads/images/users/' . $imageName . ''
                );
                $query = DB::table('users')->where($where)->update($data);
                if ($query) {
                    return json_encode(['result' => 'success']);
                } else {
                    return json_encode(['result' => 'fail']);
                }
         
        } else {
            return json_encode(['result' => 'login']);
        }
    }

    public function view_users(){
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $users = DB::select(DB::raw("SELECT * FROM users where company_id = '$company_id'"));
            // return $users;
            return view('panel.view_users', ['users' => $users]);
        } else {
            return Redirect::intended('login');
        }
    }

    public function new_user()
    {
        if (Auth::check()) {
            return view('panel.add_user');
        } else {
            return Redirect::intended('login');
        }
    }

    public function post_new_user(Request $request)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
            $validator = Validator::make(Input::all(),
                [
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'phone' => 'required',
                ],
                [
                    'email.unique' => 'Email Address Already Registered!',
                    'name.required' => 'Individual / Incorporation name is Required',
                    'phone.required' => 'Phone-Number is required',
                ]
            );
            if ($validator->fails()) {
                $messages = json_encode($validator->messages());
                return json_encode(['result' => 'val_fail', 'error' => $messages]);
            } else {

                $data = array(
                    'company_id' => $company_id,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'activated' => $request->input('status'),
                    'level' => '1',
                    'pic' => "resources/uploads/user.jpg",
                    'Corpfin_menutype' => "",
                    'password' => Hash::make($password),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => "",
                    'remember_token' => ""
                );
                $customer_id = DB::table('users')->insertGetId($data);
                if ($customer_id) {

                    return json_encode(['result' => 'success']);

                } else {

                    return json_encode(['result' => 'fail']);

                }
            }
        } else {
            return json_encode(['result' => 'login']);
        }
    }

    public function del($page, $id)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;

            ///////////User delete///////////
            if ($page == "user") {
                $where = array('company_id' => $company_id, 'id' => $id);
                $query = DB::table('users')->where($where)->delete();
                if ($query) {
                    return json_encode(['result' => 'success']);
                } else {
                    return json_encode(['result' => 'fail']);
                }
            }
//////////End user delete/////////


        } else {
            return json_encode(['result' => 'login']);
        }
    }

}
