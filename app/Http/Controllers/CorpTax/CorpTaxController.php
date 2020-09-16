<?php

namespace App\Http\Controllers\CorpTax;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Traits\SubscriptionTrait;

class CorpTaxController extends Controller
{
    use SubscriptionTrait;
    /**
     * return the index of CorpTax
     */

    public function getIndex()
    {
        if (Auth::check()) {
            $query = view('CorpTax.overview');
            return $this->is_corptax_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    /**
     * Return corpTax Overview Page
     * 
     * @return mixed
     */
    public function getDashboard()
    {
        if (Auth::check()) {
            $query = view('CorpTax.overview');
            return $this->is_corptax_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
}