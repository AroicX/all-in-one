<?php

namespace App\Http\Middleware;

use App\Models\CorpHRM;
use App\Subscription;
use Auth;
use Closure;

class CorpFINMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->company_id) {
            static::check_expired_product();
            $status = Subscription::where(function($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->whereIn('product_id', [1, 2, 3])
                    ->where('status', 1);
            })->get();

            if($status->count()) {
                $check = Subscription::where(function($q) {
                    $q->where('company_id', Auth::user()->company_id)
                        ->whereIn('product_id', [1, 2, 3]);
                })->get();

                if(!$check->count())
                {
                    return redirect('dashboard');
                }
            }
            else
            {
                return redirect('subscription');
            }
        }
        else
        {
            return redirect('setup');
        }

        return $next($request);
    }


    static function check_expired_product()
    {
        $company_id = Auth::user()->company_id;
        $active_packages = Subscription::where('company_id', $company_id);
        foreach ($active_packages as $key => $active_package) {
            $today = date('Y-m-d');
            $today = date_create($today);
            $lincense_duration = $active_package->duration;
            $date_activattd = date_create($active_package->date);
            $date_difference = date_diff($date_activattd, $today);
            $days_used = $date_difference->format("%a");
            $lincense_countdown = $lincense_duration - $days_used;
            if($lincense_countdown < 1) {
                $where = array('company_id' => $company_id,
                    'package_id' =>$active_package->package_id,
                );
                $data = array('status' => 0, );
                CorpHRM::update_fxn("subscription", $where, $data);
            }
        }
    }


}
