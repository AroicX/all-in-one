<?php

namespace App\Traits;

use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorpHRM;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Validator;
use Illuminate\Support\Facades\Input;

trait SubscriptionTrait
{
    public function confirm_user_status($query)
    {

        if(Auth::user()->company_id) {
            if($this->get_subscription_status()) {
                return $query;
            }
            else
            {
                return redirect('subscription');
            }
        }
        else
        {
            //return false;
            return redirect('setup');
        }


    }



    ///////////////END COMPANY SETUP STATUS///////////////
    public function get_subscription_status()
    {

        $this->check_expired_product();
        $today = date('Y-m-d');
        $company_id = Auth::user()->company_id;
        $active_user_sub = CorpHRM::retrieve_fxn2("subscription", "company_id", "status", $company_id, '1');

        if(empty($active_user_sub)) {
            return false;
        }
        else
        {
            return true;
        }
    }

    function check_expired_product()
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
                $deactive_account = CorpHRM::update_fxn("subscription", $where, $data);
            }
        }
    } 

    //////////Get States///////////
    public function Get_states($country_id)
    {
        $fetch = DB::select(DB::raw("SELECT * FROM states WHERE  country_id = '$country_id' "));
        return Response::json($fetch);
    }
    ////////////End get States/////////////

    ////////////////////////Check Active Corpfin User //////////////////////////////////////
    public function is_corpfin_user_set($url)
    {
        $company_id = Auth::user()->company_id;
        if(Auth::user()->company_id) {

            if($this->get_subscription_status()) {
                $check = Subscription::where(function($q) use($company_id) {
                        $q->where('company_id', $company_id)
                            ->whereIn('product_id', [1, 2, 3]);
                    })->get();

                if($check->count()) {
                    return $url;
                }
                else
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
            //return false;
            return redirect('setup');
        }
    }
    /////////////////////////End Active Corpfin User query ////////////////////////////////////

    ////////////////////////Check Active CorpHRM User //////////////////////////////////////
    public function is_corphrm_user_set($query)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            //if($this->check_company_setup_status()) {
                if($this->get_subscription_status()) {   
                    $check = DB::select(
                        DB::raw(
                            "SELECT * FROM subscription WHERE company_id = '$company_id' 
  AND product_id = '4' OR product_id = '5' OR product_id = '6' "
                        )
                    );
                    if($check) {
                        return $query;
                    }
                    else
                    {
                        return Redirect::intended('dashboard'); 
                    }
                }
                else
                {
                    return Redirect::intended('subscription'); 
                }
            //}
            //else
           // {
                //return false;
            //    return Redirect::intended('setup');
            //}
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////////////////////End Active CorpHRM User query ////////////////////////////////////

    ////////////////////////Check Active CorpTAX User //////////////////////////////////////
    public function is_corptax_user_set($query)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            //if($this->check_company_setup_status()) {
                if($this->get_subscription_status()) {   
                    $check = DB::select(
                        DB::raw(
                            "SELECT * FROM subscription WHERE company_id = '$company_id' 
  AND product_id = '13' OR product_id = '14' OR product_id = '15' "
                        )
                    );
                    if($check) {
                        return $query;
                    }
                    else
                    {
                        return Redirect::intended('dashboard'); 
                    }
                }
                else
                {
                    return Redirect::intended('subscription'); 
                }
            //}
           // else
           // {
                //return false;
          //      return Redirect::intended('setup');
          //  }
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////////////////////End Active CorpTAX User query ////////////////////////////////////

    ////////////////////////Check Active CorpEMT User //////////////////////////////////////
    public function is_corpemt_user_set($query)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            if($this->check_company_setup_status()) {
                if($this->get_subscription_status()) {   
                    $check = DB::select(
                        DB::raw(
                            "SELECT * FROM subscription WHERE company_id = '$company_id' 
  AND product_id = '10' OR product_id = '11' OR product_id = '12' "
                        )
                    );
                    if($check) {
                        return $query;
                    }
                    else
                    {
                        return Redirect::intended('dashboard'); 
                    }
                } else {
                    return Redirect::intended('subscription'); 
                }
            } else {
                //return false;
                return Redirect::intended('setup');
            }
        } else {
            return Redirect::intended('login');
        }
    }
    /////////////////////////End Active CorpEMT User query ////////////////////////////////////

    ////////////////////////Check Active CorpPAY User //////////////////////////////////////
    public function is_corppay_user_set($query)
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            if($this->check_company_setup_status()) {
                if($this->get_subscription_status()) {   
                    $check = DB::select(
                        DB::raw(
                            "SELECT * FROM subscription WHERE company_id = '$company_id' 
  AND product_id = '13' OR product_id = '14' OR product_id = '15' "
                        )
                    );
                    if($check) {
                        return $query;
                    }
                    else
                    {
                        return Redirect::intended('dashboard'); 
                    }
                }
                else
                {
                    return Redirect::intended('subscription'); 
                }
            }
            else
            {
                //return false;
                return Redirect::intended('setup');
            }
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    /////////////////////////End Active Corppay User query ////////////////////////////////////

    public function is_corpfin_avaliable()
    {
        $company_id = Auth::user()->company_id;
        $check1 = DB::select(
            DB::raw(
                "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '1' "
            )
        );
        if($check1) {
            return true;
        }
        else
        {
            $check2 = DB::select(
                DB::raw(
                    "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '2'"
                )
            );
            if($check2) {
                return true;
            }
            else
            {
                $check3 = DB::select(
                    DB::raw(
                        "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '3'"
                    )
                );
                if($check3) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public function is_corphrm_avaliable()
    {
        $company_id = Auth::user()->company_id;
        $check1 = DB::select(
            DB::raw(
                "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '4' "
            )
        );
        if($check1) {
            return true;
        }
        else
        {
            $check2 = DB::select(
                DB::raw(
                    "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '5'"
                )
            );
            if($check2) {
                return true;
            }
            else
            {
                $check3 = DB::select(
                    DB::raw(
                        "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '6'"
                    )
                );
                if($check3) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public function is_corptax_avaliable()
    {
        $company_id = Auth::user()->company_id;
        $check1 = DB::select(
            DB::raw(
                "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '7' "
            )
        );
        if($check1) {
            return true;
        }
        else
        {
            $check2 = DB::select(
                DB::raw(
                    "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '8'"
                )
            );
            if($check2) {
                return true;
            }
            else
            {
                $check3 = DB::select(
                    DB::raw(
                        "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '9'"
                    )
                );
                if($check3) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public function is_corpemt_avaliable()
    {
        $company_id = Auth::user()->company_id;
        $check1 = DB::select(
            DB::raw(
                "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '10' "
            )
        );
        if($check1) {
            return true;
        }
        else
        {
            $check2 = DB::select(
                DB::raw(
                    "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '11'"
                )
            );
            if($check2) {
                return true;
            }
            else
            {
                $check3 = DB::select(
                    DB::raw(
                        "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '12'"
                    )
                );
                if($check3) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }


    public function is_corppay_avaliable()
    {
        $company_id = Auth::user()->company_id;
        $check1 = DB::select(
            DB::raw(
                "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '13' "
            )
        );
        if($check1) {
            return true;
        }
        else
        {
            $check2 = DB::select(
                DB::raw(
                    "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '14'"
                )
            );
            if($check2) {
                return true;
            }
            else
            {
                $check3 = DB::select(
                    DB::raw(
                        "SELECT * FROM subscription WHERE company_id = '$company_id' AND status='1'
  AND product_id = '15'"
                    )
                );
                if($check3) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }   
    }

}
