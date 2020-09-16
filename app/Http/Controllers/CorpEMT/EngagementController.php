<?php 
namespace App\Http\Controllers\CorpEMT;
use App\Models\CorpEMT\Discount;
use App\Models\CorpEMT\Expenses;
use Illuminate\Http\Request;
use App\Models\CorpEMT\UsersModel;
use App\Http\Controllers\Controller;
use App\Traits\SubscriptionTrait;
use App\Models\CorpEMT\ClientModel;
use App\Models\CorpEMT\DealsModel;
use App\Models\CorpEMT\EngagementModel;
use Illuminate\Support\Facades\Auth;

class EngagementController extends Controller
{
    use SubscriptionTrait;
    public function __construct()
    {
        $this->user         = new UsersModel;
        $this->client         = new ClientModel;
        $this->deal         = new DealsModel;
        $this->engagement     = new EngagementModel;
    }

    public function manage_engagements()
    {
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;

        $user             = $this->user->get_current_user($user_id, $company_id);
        $total_client    = $this->client->total_number_of_clients($company_id);
        $pending_deals     = $this->deal->deal_stage_count($company_id);

        $list_deals     = $this->deal->list_deals($company_id);

        $page = 'Manage Engagement';

        return view('CorpEMT.manage_engagement', ['total_client'=>$total_client, 'user'=>$user, 'page'=>$page, 'pending_deals'=>$pending_deals, 'list_deals'=>$list_deals]);
    }



    public function view_engagement($id)
    {
        $identity = explode('+', base64_decode($id));
        $client_id = $identity[0];
        $deal_id = $identity[1];

        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;

        $user = $this->user->get_current_user($user_id, $company_id);
        $total_client = $this->client->total_number_of_clients($company_id);
        $pending_deals = $this->deal->deal_stage_count($company_id);
        $deal_amount = $this->deal->deal_amount($client_id)->amount;

        $page = 'View Engagement';

        $general_information = $this->engagement->get_basic_information($deal_id, $client_id, $company_id);
        $industry_information = $this->engagement->get_industry_information($deal_id, $client_id, $company_id);
        $financial_information = $this->engagement->get_financial_information($deal_id, $client_id, $company_id);
        $company_information = $this->engagement->get_company_information($deal_id, $client_id, $company_id);
        $management_information = $this->engagement->get_management_information($deal_id, $client_id, $company_id);

        $committee_information = $this->engagement->get_audit_committee_information($deal_id, $client_id, $company_id);
        $engagement_analysis = $this->engagement->engagement_analysis_details($deal_id, $client_id, $company_id);

        $discounts = Discount::all();
        $expenses = Expenses::all();

        return view('CorpEMT.view_engagement', [
            'total_client'=>$total_client,
            'user'=>$user,
            'page'=>$page,
            'pending_deals'=>$pending_deals,
            'deal_id'=>$deal_id,
            'deal_amount' => $deal_amount,
            'client_id'=>$client_id,
            'company_id'=>$company_id,
            'info'=>$general_information,
            'industry'=>$industry_information,
            'finance'=>$financial_information,
            'company'=>$company_information,
            'management'=>$management_information,
            'committee'=>$committee_information,
            'analysis'=>$engagement_analysis,
            'discounts' => $discounts,
            'expenses' => $expenses
        ]);
    }

    public function save_basic_details(Request $request)
    {
        $address     = $request->address;
        $city         = $request->city;
        $country     = $request->country;
        $email         = $request->email;
        $attention    = $request->attention;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($address) || empty($city) || empty($country) || empty($email) || empty($attention)) {
            return redirect($redirect_to)->with('error', 'All general information fields are required');
        } else {
            $this->engagement->save_basic_information($deal_id, $client_id, trim($address), $city, $country, $attention, $email, $company_id);
            return redirect($redirect_to)->with('success', 'Industry information successfully saved');
        }
    }

    public function save_industry_details(Request $request)
    {
        $operation         = $request->operation;
        $prod_and_serv     = $request->product_and_services;
        $requirement     = $request->requirement;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($operation) || empty($prod_and_serv) || empty($requirement)) {
            return redirect($redirect_to)->with('error', 'All industry details are required');
        }
        else
        {
            $this->engagement->save_industry_information($operation, $prod_and_serv, $requirement, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Industry information successfully saved');
        }
    }

    public function save_financial_details(Request $request)
    {
        $historical_info     = $request->financial_info;
        $assets             = $request->assets;
        $liabilities         = $request->liabilities;
        $revenue_and_market = $request->revenue_and_market;
        $liquidity             = $request->liquidity;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($historical_info) || empty($assets) || empty($liabilities) || empty($revenue_and_market) || empty($liquidity)) {
            return redirect($redirect_to)->with('error', 'All financial highlight details are required');
        }
        else
        {
            $this->engagement->save_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Financial information successfully saved');
        }
    }

    public function save_company_details(Request $request)
    {
        $company_type         = $request->company_type;
        $potential_client     = $request->potential_client;
        $cac                 = empty($request->cac) ? 'no' : $request->cac;
        $share_capital        = $request->share_capital;
        $structure             = $request->structure;
        $go_public             = empty($request->go_public) ? 'no' : $request->go_public; 

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($company_type)) {
            return redirect($redirect_to)->with('error', 'Kindly select company type');
        }
        else if($company_type == 'private' && empty($go_public)) {
            return redirect($redirect_to)->with('error', 'Does the company expect to become public within two years?');
        }
        else
        {
            $this->engagement->save_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Company Analysis successfully saved');
        }

    }

    public function save_management_details(Request $request)
    {
        $title         = $request->title;
        $fullname     = $request->fullname;
        $position    = $request->position;
        $experience = $request->exeprience;
        $discuss    = $request->discuss;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($title) || empty($fullname) || empty($position) || empty($experience) || empty($discuss)) {
            return redirect($redirect_to)->with('error', 'You are expected to fill all required fields before adding management');
        }
        else
        {
            $this->engagement->save_management_information($title, $fullname, $position, $discuss, $experience, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Management successfully added');
        }

    }

    public function edit_management_details(Request $request)
    {
        $title         = $request->title;
        $fullname     = $request->fullname;
        $position    = $request->position;
        $experience = $request->experience;
        $discuss    = $request->discuss;

        $management_id     = $request->management_id;
        $client_id     = $request->client_id;
        $deal_id     = $request->deal_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($title) || empty($fullname) || empty($position) || empty($experience) || empty($discuss)) {
            return redirect($redirect_to)->with('error', 'You are expected to fill all required fields before adding management');
        }
        else
        {
            $this->engagement->update_management_information($title, $fullname, $position, $discuss, $experience, $management_id);

            return redirect($redirect_to)->with('success', 'Management successfully updated');
        }

    }

    public function save_committee_details(Request $request)
    {
        $fullname     = $request->fullname;
        $position    = $request->position;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($fullname) || empty($position)) {
            return redirect($redirect_to)->with('error', 'Kindly enter the fullname and position of the audit committee member');
        }
        else
        {
            $this->engagement->save_audit_committee_information($fullname, $position, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Audit committee successfully added');
        }

    }

    public function edit_committee_details(Request $request)
    {
        $fullname     = $request->fullname;
        $position    = $request->position;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $committee_id = $request->committee_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);


        if (empty($fullname) || empty($position)) {
            return redirect($redirect_to)->with('error', 'Kindly enter the fullname and position of the audit committee member');
        }
        else
        {
            $this->engagement->update_audit_committee_information($fullname, $position, $committee_id);

            return redirect($redirect_to)->with('success', 'Audit committee details successfully updated');
        }

    }

    public function delete_committee(Request $request)
    {
        $check     = $request->check;
        $client_id     = $request->client_id;
        $deal_id     = $request->deal_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($check)) {
            return redirect($redirect_to)->with('error', 'Kindly select the audit committee member(s) you want removed');
        }
        else
        {
            $this->engagement->delete_audit_committee($check);

            return redirect($redirect_to)->with('success', 'Audit committee member successfully removed');
        }    

    }

    public function delete_management(Request $request)
    {
        $check     = $request->check;
        $client_id     = $request->client_id;
        $deal_id     = $request->deal_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($check)) {
            return redirect($redirect_to)->with('error', 'Kindly select the a member of the management you want removed');
        }
        else
        {
            $this->engagement->delete_management($check);

            return redirect($redirect_to)->with('success', 'Member of the management successfully removed');
        }    

    }

    public function save_budget_proposal(Request $request)
    {
        $amount = $request->amount;
        $agreed = $request->agreed;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($amount) || empty($agreed)) {
            return redirect($redirect_to)->with('error', 'Kindly enter the proposed budget amount and agreed fee');
        }
        elseif(!is_numeric($amount) || !is_numeric($agreed)) {
            return redirect($redirect_to)->with('error', 'The proposed budget and agreed fee should be digits');
        }
        else
        {
            $this->engagement->save_proposed_budget($amount, $agreed, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Proposed budget and agreed fee successfully saved');
        }
    }

    public function save_analysis_item(Request $request)
    {
        $fullname = $request->fullname;
        $designation = $request->designation;
        $hours = $request->hours;
        $rate = $request->rate;

        $deal_id     = $request->deal_id;
        $client_id     = $request->client_id;
        $company_id = $request->company_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($fullname) || empty($designation) || $hours <= 0 || $rate <= 0) {
            return redirect($redirect_to)->with('error', 'Kindly fill all required field before adding item to engagement analysis');
        } else if(!is_numeric($hours) || !is_numeric($rate)) {
            return redirect($redirect_to)->with('error', 'Hours and Rate should br digit');
        } else {
            $this->engagement->save_engagement_analysis($fullname, $designation, $hours, $rate, $deal_id, $client_id, $company_id);

            return redirect($redirect_to)->with('success', 'Item successfully added to engagement analysis');
        }
    }

    public function add_discount(Request $request){

        // validate the input
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required|integer',
            'deal_id' => 'required|integer',
            'client_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($request->client_id.'+'.$request->deal_id);

        if(Discount::create($request->all())){
            return redirect($redirect_to)->with('success', 'Discount successfully added to engagement analysis');
        }else{
            return redirect($redirect_to)->with('error', 'Discount could\'t be added. Please try again later');
        }
    }

    public function add_expense(Request $request){
        // validate the input
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required|integer',
            'deal_id' => 'required|integer',
            'client_id' => 'required|integer',
            'company_id' => 'required|integer',
        ]);

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($request->client_id.'+'.$request->deal_id);

        if(Expenses::create($request->all())){
            return redirect($redirect_to)->with('success', 'Discount successfully added to engagement analysis');
        }else{
            return redirect($redirect_to)->with('error', 'Discount could\'t be added. Please try again later');
        }
    }

    public function delete_item(Request $request)
    {
        $check     = $request->item;
        $client_id     = $request->client_id;
        $deal_id     = $request->deal_id;

        $redirect_to = 'corpemt/engagement/manage/'.base64_encode($client_id.'+'.$deal_id);

        if (empty($check)) {
            return redirect($redirect_to)->with('error', 'Kindly select the item you want removed');
        }
        else
        {
            $this->engagement->delete_item($check);

            return redirect($redirect_to)->with('success', 'Item successfully removed');
        }    

    }
}
