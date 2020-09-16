<?php

namespace App\Http\Controllers\CorpEMT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;

class HomeController extends Controller
{
    use SubscriptionTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $query =  view('CorpEMT.home');
            return $this->is_corpemt_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }
}
