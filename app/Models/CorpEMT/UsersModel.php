<?php
namespace App\Models\CorpEMT;

use Illuminate\Database\Eloquent\Model;
use DB;

class UsersModel extends Model
{

    protected $users_table = 'users';


    // public function add_user($fullname, $email, $password, $company, $user_role)
    // {
    // 	$users = DB::table($this->users_table)->where('email', $email);
    // 	$count = $users->count();

    // 	if ($count < 1)
    // 	{
    // 		$save = DB::table($this->users_table)->insert(['name'=>ucwords($fullname), 'email'=>strtolower($email), 'password'=>$password, 'company_id'=>$company, 'role_id'=>$user_role]);
    // 		return $save;
    // 	}
    // 	else
    // 	{
    // 		return 'exist';
    // 	}
    // }


    public function get_current_user($user_id, $company_id)
    {
        $user = DB::table($this->users_table)->select('name')->where(['id' => $user_id, 'company_id' => $company_id]);
        return $user->first();
    }


    public function list_users($company_id){
        $where = array(
            'company_id' => $company_id,
            'level' => 4,
            'activated' => 1,
        );
        $users = DB::table($this->users_table)->select('id', 'name')->where($where);
        return $users->get();
    }

//     public function list_roles()
//     {
//     	$roles = DB::table($this->user_roles_table)->select('*')->get();
//     	return $roles;
//     }


    // public function check_user($email, $password)
    // {
    // 	$user = DB::table($this->users_table)->where(['email' => $email, 'password' => $password]);
    // 	$count = $user->count();
    // 	return $count;
    // }


    // public function check_user_session($user_id, $token)
    // {
    // 	$check = DB::table($this->user_session_table)->where(['user_id' => $user_id, 'token'=>$token]);
    // 	$count = $check->count();
    // 	return $count;
    // }


    // public function user_session_details($email, $password)
    // {
    // 	$user = DB::table($this->users_table)->select('id', 'company_id')->where(['email' => $email, 'password' => $password])->limit(1);
    // 	return $user->get();
    // }


    // public function save_session_details($user_id, $token)
    // {
    // 	$check = DB::table($this->user_session_table)->where('user_id', $user_id);
    // 	$count = $check->count();

    // 	if ($count > 0)
    // 	{
    // 		return $this->_update_user_session($user_id, $token);
    // 	}
    // 	else
    // 	{
    // 		return $this->_save_new_session($user_id, $token);
    // 	}
    // }


    // private function _save_new_session($user_id, $token)
    // {
    // 	$date = date('Y-m-d H:i:s');
    // 	$save = DB::table($this->user_session_table)->insert(['user_id'=>$user_id, 'token'=>$token, 'last_login'=>$date, 'last_seen'=>$date]);
    // 	return $save;
    // }


    // private function _update_user_session($user_id, $token)
    // {
    // 	$date = date('Y-m-d H:i:s');
    // 	$update = DB::table($this->user_session_table)->where('user_id', $user_id)->update(['token'=>$token, 'last_login'=>$date, 'last_seen'=>$date]);
    // 	return $update;
    // }

}