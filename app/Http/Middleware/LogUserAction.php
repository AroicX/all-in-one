<?php

namespace App\Http\Middleware;

use App\Models\LogUserActions;
use Auth;
use Closure;

class LogUserAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $module, $action)
     {  
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        $db = new LogUserActions();
        $db->company_id = $company_id;
        $db->user_id = $user_id;
        $db->module = $module;
        $db->action = $action;
        $db->save();

    
        return $next($request);
      }

}