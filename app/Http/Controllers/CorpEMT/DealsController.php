<?php 
namespace App\Http\Controllers\CorpEMT;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;
use App\Models\CorpEMT\ClientModel;
use App\Models\CorpEMT\UsersModel;
use App\Models\CorpEMT\DealsModel;

class DealsController extends Controller
{
    use SubscriptionTrait;

    // TODO set the subscription middleware for this controller
    public function __construct()
    {
        $this->client     = new ClientModel;
        $this->user     = new UsersModel;
        $this->deals     = new DealsModel;
    }
    public function index(){
        $page = 'Deals';

        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;

        $user             = $this->user->get_current_user($user_id, $company_id);
        $total_client     = $this->client->total_number_of_clients($company_id);
        $list_deals     = $this->deals->list_deals($company_id);

        $pending_deals     = $this->deals->deal_stage_count($company_id);

        $query = view('CorpEMT.deals', ['user'=>$user, 'total_client'=>$total_client, 'page'=>$page, 'list_deals'=>$list_deals, 'pending_deals'=>$pending_deals]);

        // TODO: correct error with subscription accesss
        //return $this->is_corpemt_user_set($query);

        return $query;
    }

    public function pipeline(){
        $company_id = Auth::user()->company_id;

        //default display information
        $month = date('m');
        $year = date('Y');
        $stage = '10';

        $total_client     = $this->client->total_number_of_clients($company_id);
        $list_deals     = $this->deals->pending_month_deal($month, $year, $stage, $company_id);
        $all_pending_deal = $this->deals->all_pending_deal($company_id);
        $stage_month_deal = $this->deals->monthly_stage_deals($month, $year, $stage, $company_id);
        $stage_year_deal = $this->deals->yearly_stage_deals($year, $stage, $company_id);

        $pending_deals     = $this->deals->deal_stage_count($company_id);
        $won_lost_month_deal = $this->deals->won_lost_month_deal($month, $year, $company_id);

        return view('CorpEMT.pipeline', compact('total_client', 'pending_deals', 'stage_month_deal', 'stage_year_deal','list_deals', 'won_lost_month_deal', 'all_pending_deal', 'company_id'));
    }

    public function pipeline_api_get_info($month, $year, $stage, $company_id = 0){
        $month_deals = $this->deals->monthly_stage_deals($month, $year, $stage, $company_id);
        $stage_year_deal = $this->deals->yearly_stage_deals($year, $stage, $company_id);

        return ['status'=>true, 'month_deal'=>$month_deals, 'year_deal'=>$stage_year_deal];
    }

}
