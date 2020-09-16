<?php
namespace App\Http\Controllers\CorpEMT;

use Illuminate\Http\Request;
use App\Models\CorpEMT\ClientModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;
use App\Models\CorpEMT\DealsModel;
use App\Models\CorpEMT\UsersModel;

// use App\Http\Middleware\CheckUser;

class DashboardController extends Controller
{
    use SubscriptionTrait;

    public function __construct()
    {
        $this->client = new ClientModel;
        $this->deal = new DealsModel;
        $this->user = new UsersModel;
    }


    public function index()
    {
        $company_id = Auth::user()->company_id;

        $user_id = Auth::user()->id;
        $year = date('Y');

        $page = 'Dashboard';

        $total_client = $this->client->total_number_of_clients($company_id);
        $expected_total = $this->deal->expected_total($company_id, $year);
        $deals_won = $this->deal->cash($company_id, $year, 'won');
        $deals_lost = $this->deal->cash($company_id, $year, 'lost');
        $graphical_data = $this->deal->graphical_analysis($year);

        $user = $this->user->get_current_user($user_id, $company_id);
        $pending_deals = $this->deal->deal_stage_count($company_id);


        $query = view('CorpEMT.dashboard', ['user' => $user, 'page' => $page, 'total_client' => $total_client, 'expected_total' => $expected_total, 'deals_won' => $deals_won, 'deals_lost' => $deals_lost, 'year' => $year, 'graphical_data' => $graphical_data, 'pending_deals' => $pending_deals]);

        // TODO: correct error with subscription accesss
        //return $this->is_corpemt_user_set($query);

        return $query;
    }

}
