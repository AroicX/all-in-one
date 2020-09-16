<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\CorpHRM;
use DB;
class ModulesController extends PageController
{
    public function get_module_status($module)
    {
        $this->check_expired_product();
        $today = date('Y-m-d');
        $user_id = Auth::user()->id;
        //$package_id = CorpHRM::retrieve_fxn1("packages","name",$module);
        // 	foreach ($products_id as $key => $product_id){
        // $p_id = $package_id->id;
        // 	$active_user_sub = DB::select( DB::raw("SELECT * FROM subscriptions WHERE user_id = '$user_id' AND status = 'Active' AND package_id = '$p_id' "));
        $active_user_sub = CorpHRM::retrieve_fxn2("subscription", "company_id", "status", $user_id, 'Active');
        if(empty($active_user_sub)) {
            return false;
        }else{
            foreach ($active_user_sub as $key => $active_user) {
                $package_id = $active_user->package_id;
                $lincense_duration = $active_user->duration;

                foreach ($active_user_sub as $key => $date_activated) {

                    $today = date_create($today);
                    $date_activattd = date_create($date_activated->start_date);
                    $date_difference = date_diff($date_activattd, $today);
                    $days_used = $date_difference->format("%a");
                    $lincense_countdown = $lincense_duration - $days_used;

                    $package_details = CorpHRM::retrieve_fxn1("packages", "id", $package_id);

                    foreach ($package_details as $key => $package_detail) 
                    {

                        $sub_packages = explode(',', $package_detail->sub_package_id);
                        $plan_details = explode(',', $package_detail->plan_id);

                        foreach ($sub_packages as $key => $sub_package) 
                        {

                            $sub_package_name = CorpHRM::retrieve_fxn1("sub_packages", "id", $sub_package);    
                
                            if($sub_package_name == $module) {

                                $plan_details = CorpHRM::retrieve_fxn1("plan", "id", $plan_details);

                                if($lincense_countdown < 1) {
                                    //subsciption expired
                                    return false;
                                }
                                elseif($lincense_countdown <= 5) {
                                    //subscription about to expire
                                    foreach ($package_details as $key => $package_detail) {
                                        $data = json_encode(
                                            array(
                                            'status' => "Warning",
                                            'days_left' => $lincense_countdown,
                                            'package' => $package_detail->name,
                                            )
                                        );
                                    }

                                    return $data;
                                }
                                else{
                                    //subscription active
                                    foreach ($product_name as $key => $product_name) {
                                        $data = json_encode(
                                            array(
                                            'status' => "Active",
                                            'days_left' => $lincense_countdown,
                                            'package' => $product_name->name,
                                            )
                                        );
                                        return $data;
                                    }
                                }


                            }
                            else
                            {
                                $data = json_encode(
                                    array(
                                    'status' => "Restricted",
                                    'package' => $module,
                                    )
                                );
                                return $data;
                            }

                        }

                    }
                }
            }
        }

    }

    function check_expired_product()
    {
        $user_id = $user_id = Auth::user()->id;
        $active_products = DB::select(DB::raw("SELECT * FROM subscriptions WHERE user_id = '$user_id' AND status = 'Active' "));
        foreach ($active_products as $key => $active_product) {
            $today = date('Y-m-d');
            $today = date_create($today);
            $lincense_duration = $active_product->duration;
            $date_activattd = date_create($active_product->start_date);
            $date_difference = date_diff($date_activattd, $today);
            $days_used = $date_difference->format("%a");
            $lincense_countdown = $lincense_duration - $days_used;
            if($lincense_countdown < 1) {
                $where = array('user_id' => $user_id,
                           'product_id' =>$active_product->product_id,
                );
                $data = array('status' => "Deactivated", );
                $deactive_account = CorpHRM::update_fxn("subscriptions", $where, $data);
            }
        }
    }

}

