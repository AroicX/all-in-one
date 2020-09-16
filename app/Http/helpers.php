<?php
use App\Models\CorpHRM\Access_roles;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\check_corperm_package as ValidatePackage;

if (! function_exists('ModuleCheck')) {
    function ModuleCheck($module){
        $company_id = Auth::user()->company_id;
        $ValidatePackage  = new ValidatePackage();
        if($company_id != "0"){
            $check = $ValidatePackage->check_module($company_id, $module);
            return ($check['status'] == "true") ? true : false;
        }
        return false;
    }
}

if (! function_exists('CorpHRMAccessRoles')) {
	function  CorpHRMAccessRoles($permission){

		$company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        $access_roles = Access_roles::where('company_id', $company_id)->get(); 
        foreach ($access_roles as $access_role){
            $users_id = explode(',',$access_role->users_id);
            if (is_array($users_id)) {
            if(in_array($user_id, $users_id)){
                $role = $access_role->role;
                if($access_role->permissions == "All"){
                    return $next($request);
                }else{
                $permissions = explode(',',$access_role->permissions);
                if(in_array($permission, $permissions)) {

                    return true;
                    //return response('success', 200);
                } else{

                	return false;
                    // return response($permissions, 401);
                }
            	}
            } else {

            	return false;
                //return response('Contact the administrator to assign role', 401);
            }
         }
        }
	}
}

if (! function_exists('split_name')) {
    // uses regex that accepts any word character or hyphen in last name
    function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }
}
?>