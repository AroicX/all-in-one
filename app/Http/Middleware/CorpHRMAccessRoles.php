<?php

namespace App\Http\Middleware;

use App\Models\CorpHRM\Access_roles;
use Illuminate\Support\Facades\Auth;
use Closure;

class CorpHRMAccessRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page)
    {   

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
                if(in_array($page, $permissions)) {

                    return $next($request);
                    //return response('success', 200);
                } else{
                    return redirect()->back()->with(["error" => 'No access right!']);
                    // return response("No access right", 401);
                }
            }
            } else {

                return redirect()->back()->with(["error" => 'Contact the administrator to assign role!']);
                //return response('Contact the administrator to assign role', 401);
            }
         }
        }

        return $next($request);
    }
}
