<?php

namespace App\Http\Middleware;
use Auth;
use App\Subscription;
use App\Company;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Route;
use Carbon\Carbon;

class IsPageAccessible
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
        $current_path = Route::getCurrentRoute()->getPath();
        if (Auth::check()) {
            /**
             * Check if initial company setup is done
            */
            if(!$this->check_company_setup_status()){
                if($current_path != "setup"){
                    return redirect('/setup')->with(["warning" => 'Complete company setup to continue']);
                }
                
            }
            /**
             * Check if company has active Subscription
            */
            elseif(!$this->check_company_subscription_status()){
                if($current_path != "subscription"){
                    return redirect('/subscription')->with(["warning" => 'An Active Subscription is required']);
                }
            }
            /**
             * Process User Request
             */
            else{
                return $next($request);
            }
        }
        return $next($request);
    }

    /**
     * Checks if company profile is setup
     * @return bool
     */
    private function check_company_setup_status()
    {
        return (Auth::user()->company_id > 0) ? true : false;
    }

    /**
     * Check if company has any active subscription
     */
    private function check_company_subscription_status()
    {
        $company_id = Auth::user()->company_id;
        $subscriptions = Subscription::where('company_id', $company_id)->get();
        // check if company have any subscrption at all
        if(count($subscriptions) > 0){
            // check any individual sub is active
            $subscriptions = Subscription::where(['company_id'=>$company_id, 'status' => "1"])->get();
            $active_subs = 0;
            foreach($subscriptions as $subscription){
                    // calculation to set the remaining duration of subscription
                    $dateToday = Carbon::today();
                    $lincenseDur = $subscription->duration;
                    $dateActivated = date_create($subscription->date);
                    $dateDiff = date_diff($dateActivated, $dateToday);
                    $daysUsed = $dateDiff->format("%a");
                    $daysLeft = $lincenseDur - $daysUsed;
                    if($daysLeft > 0){
                        $active_subs = $active_subs + 1;
                    }else{
                        Subscription::where(['id'=>$subscription->id])->update(['status' => "0"]);
                    }
            }
            if($active_subs > 0)return true;else return false;
        }else{
            return false;
        }
    }
}
