<?php 
namespace App\Http\Controllers\CorpEMT;
use Redirect;
use Illuminate\Http\Request;
use App\Models\CorpEMT\ClientModel;
use App\Models\CorpEMT\SettingsModel;
use App\Http\Controllers\Controller;
use App\Models\CorpEMT\UsersModel;
use App\Models\CorpEMT\DealsModel;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Traits\SubscriptionTrait;

class ClientController extends Controller
{
    use SubscriptionTrait;

    // TODO set up subscription middleware for this controller
    public function __construct()
    {
        $this->client     = new ClientModel;
        $this->setting  = new SettingsModel;
        $this->user     = new UsersModel;
        $this->deal     = new DealsModel;
    }

    public function action_stream(){
        $page = 'Action Stream';

        $company_id = Auth::user()->company_id;

        $total_client = $this->client->total_number_of_clients($company_id);
        $pending_deals = $this->deal->deal_stage_count($company_id);

        $actions = $this->client->list_actions($company_id);

        return view('CorpEMT/action_stream', compact('actions', 'page', 'total_client', 'pending_deals'));
    }

    public function pending_action(){
        $page = 'Filter: Pending Actions';

        $company_id = Auth::user()->company_id;

        $total_client = $this->client->total_number_of_clients($company_id);
        $pending_deals = $this->deal->deal_stage_count($company_id);

        $actions = $this->client->pending_actions($company_id);

        return view('CorpEMT/pending_action', compact('actions', 'page', 'total_client', 'pending_deals'));
    }

    public function completed_action(){
        $page = 'Filter: Completed Actions';

        $company_id = Auth::user()->company_id;

        $total_client = $this->client->total_number_of_clients($company_id);
        $pending_deals = $this->deal->deal_stage_count($company_id);

        $actions = $this->client->completed_actions($company_id);

        return view('CorpEMT/completed_action', compact('actions', 'page', 'total_client', 'pending_deals'));
    }

    public function manage_client()
    {
            $query = $this->mc();

            // TODO: correct error with subscription accesss
            //return $this->is_corpemt_user_set($query);

            return $query;
    }
  
    private function mc(){
        $company_id = Auth::user()->company_id;
        $owner_id = Auth::user()->id;
        $user_id = Auth::user()->id;

        $page = 'Manage Client';
        
        $total_client     = $this->client->total_number_of_clients($company_id);
        $clients         = $this->client->list_all_clients($company_id, $owner_id);
        $user             = $this->user->get_current_user($user_id, $company_id);
        $pending_deals     = $this->deal->deal_stage_count($company_id);
        return view(
            'CorpEMT.manage_clients', ['user'=>$user, 'clients'=>$clients, 'page'=>$page, 'total_client'=>$total_client, 'user'=>$user,
            'pending_deals'=>$pending_deals]
        );
    }

    public function details($unique_id)
    {
        $query = $this->ds($unique_id);

        // TODO: correct error with subscription accesss
        //return $this->is_corpemt_user_set($query);

        return $query;
    }
    private function ds($unique_id)
    {
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;
        $owner_id     = Auth::user()->id;
        $total_client     = $this->client->total_number_of_clients($company_id);

        $client_id     = $this->client->get_client_id($unique_id, $company_id)->id;

        $sources     = $this->setting->list_lead_sources('source', $company_id);
        $details     = $this->client->details($unique_id, $company_id);

        $actions     = $this->client->list_actions($company_id, $client_id);
        $calls         = $this->client->list_calls($client_id, $company_id);
        $deals      = $this->deal->list_deals($company_id, $client_id);
        $notes         = $this->client->list_notes($client_id, $company_id);
        $user         = $this->user->get_current_user($user_id, $company_id);

        $pending_deals     = $this->deal->deal_stage_count($company_id);

        $page = 'Client Details';

        return view('CorpEMT.client_details', ['details'=>$details, 'sources'=>$sources, 'actions'=>$actions, 'calls'=>$calls, 'deals'=>$deals, 'notes'=>$notes, 'total_client'=>$total_client, 'page'=>$page, 'user'=>$user, 'pending_deals'=>$pending_deals]);
    }

    private function n_c()
    {
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;

        $sources     = $this->setting->list_lead_sources('source', $company_id);
        $users         = $this->user->list_users($company_id);

        $current_user = $this->user->get_current_user($user_id, $company_id);
        $total_client     = $this->client->total_number_of_clients($company_id);

        $page = 'New Client';
        $user = $this->user->get_current_user($user_id, $company_id);
        $pending_deals     = $this->deal->deal_stage_count($company_id);

        return view('CorpEMT.new_client', ['user'=>$user, 'sources'=>$sources, 'current_user'=>$current_user, 'user_id'=>$user_id, 'users'=>$users, 'page'=>$page, 'total_client'=>$total_client, 'pending_deals'=>$pending_deals]);
    }

    public function new_client()
    {
        $query = $this->n_c();

        // TODO: correct error with subscription accesss
        //return $this->is_corpemt_user_set($query);

        return $query;

    }

    public function add_new_client(Request $request)
    {
        $firstname         = $request->firstname;
        $lastname         = $request->lastname;
        $job_title         = $request->job_title;
        $company         = $request->company;
        $phone             = $request->phonenumber;
        $email             = $request->email;
        $url             = $request->url;
        $address         = $request->address;
        $status         = $request->status;
        $tags             = $request->tags;
        $lead_source     = $request->lead_source;
        $background        = $request->background;
        $owner             = $request->owner;
        // $birthday		= $request->birthday;
        $option         = $request->option;

        //validation//
        $this->validate(
            $request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'company' => 'required',
            'phonenumber' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
            'owner' => 'required',
            ]
        );

        $name = strtolower("$firstname $lastname");
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $unique_id = md5(uniqid());

        $feedback = $this->client->save_client($name, $job_title, $company, $phone, $email, $url, $address, $status, $tags, $lead_source, $background, $owner, $option, $company_id, $unique_id);

         $redirect_to = 'corpemt/client/new';
         $success_redirect = 'corpemt/client/view/'.$unique_id;

        if ($feedback === true) {
            return redirect($success_redirect)->with('success', 'Client successfully added');
        } else {
            return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        }
    }

    public function update_personal_details(Request $request){
        $name         = $request->name;
        $job_title     = $request->job_title;
        $phone         = $request->phone;
        $email         = $request->email;
        $url         = $request->url;
        $address     = $request->address;
        $state         = $request->state;
        $country     = $request->country;
        $city        = $request->city;
        $zip         = $request->zip;

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->validate(
            $request, [
            'name' => 'required',
            'job_title'=> 'required',
               'phone' => 'required',
               'email' => 'required',
               'address' => 'required',
            ]
        );


        $this->client->update_personal_details($name, $job_title, $phone, $email, $url, $address, $city, $state, $zip, $country, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        // exit(print_r($feedback));

        // if ($feedback === TRUE) 
        // {
        // 	return redirect($redirect_to)->with('success', 'Personal details successfully updated');
        // }
        // else
        // {
        // 	return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        // }
        return redirect($redirect_to);
    }

    public function update_company_details(Request $request)
    {
        $name             = $request->company_name;
        $description     = $request->company_description;
        $phone             = $request->company_phone;
        $url             = $request->company_website;
        $address         = $request->company_address;


        $this->validate(
            $request, [
            'company_name' => 'required',
            'company_description'=> 'required',
               'company_phone' => 'required',
               'company_website' => 'required',
               'company_address' => 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->client->update_client_company_details($name, $description, $phone, $url, $address, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function update_other_information(Request $request){

        $status     = $request->status;
        $tags         = $request->tags;
        $source     = $request->source;
        $background = $request->background;


        $this->validate(
            $request, [
            'status' => 'required',
            'tags'=> 'required',
               'source' => 'required',
               'background' => 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->client->update_other_information_details($status, $tags, $source, $background, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function add_action(Request $request)
    {
        $note         = $request->note;
        $schedule     = $request->schedule;
        $date         = $request->date;
        $time         = $request->time;

        $this->validate(
            $request, [
            'note' => 'required',
            'schedule'=> 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->client->add_next_action($note, $schedule, $date, $time, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }

    public function update_action(Request $request){
        $note         = $request->note;
        $schedule     = $request->schedule;
        $date         = $request->date;
        $time         = $request->time;

        $this->validate(
            $request, [
            'note' => 'required',
            'schedule'=> 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;
        $action_id     = $request->action_id;

        $this->client->update_existing_action($note, $schedule, $date, $time, $action_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function action_completed(Request $request)
    {
        $action_id = $request->action_id;
        $unique_id     = $request->unique_id;

        $this->client->mark_action_as_done($action_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function delete_action(Request $request)
    {
        $action_id = $request->action_id;
        $unique_id     = $request->unique_id;

        $this->client->remove_action($action_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function add_call(Request $request)
    {
        $feedback    = $request->feedback;
        $note        = $request->note;

        $this->validate(
            $request, [
            'feedback' => 'required',
            'note'=> 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->client->add_call($feedback, $note, $company_id, $client_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }

    public function edit_call(Request $request)
    {
        $feedback    = $request->feedback;
        $note        = $request->note;

        $this->validate(
            $request, [
            'feedback' => 'required',
            'note'=> 'required',
            ]
        );

        $call_id    = $request->call_id;
        $unique_id     = $request->unique_id;

        $this->client->edit_call($feedback, $note, $call_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }

    public function delete_call(Request $request)
    {
        $call_id     = $request->call_id;
        $unique_id     = $request->unique_id;

        $this->client->remove_call($call_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function add_deal(Request $request)
    {
        $name         = $request->deal_name;
        $amount     = $request->deal_amount;
        $close_date = $request->expected_close_date;
        $stage         = $request->deal_stage;
        $note         = $request->note;

        $this->validate(
            $request, [
            'deal_name' => 'required',
            'deal_amount'=> 'required',
            'expected_close_date' => 'required',
            'deal_stage' => 'required',
            'note' => 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;
        $owner         = Auth::user()->id;

        $this->deal->add_deal($name, $amount, $close_date, $stage, $note, $owner, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }

    public function edit_deal(Request $request){
        $name         = $request->deal_name;
        $amount     = $request->deal_amount;
        $close_date = $request->expected_close_date;
        $stage         = $request->deal_stage;
        $note         = $request->note;

        $this->validate(
            $request, [
            'deal_name' => 'required',
            'deal_amount'=> 'required',
            'expected_close_date' => 'required',
            'deal_stage' => 'required',
            'note' => 'required',
            ]
        );

        $deal_id     = $request->deal_id;
        $unique_id     = $request->unique_id;
        $owner         = Auth::user()->id;

           $this->deal->update_deal($name, $amount, $close_date, $stage, $owner, $deal_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }

    public function delete_deal(Request $request)
    {
        $deal_id     = $request->deal_id;
        $unique_id     = $request->unique_id;

        $this->deal->remove_deal($deal_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function add_note(Request $request)
    {
        $note = $request->note;
        $deal_id = $request->deal;

        $this->validate(
            $request, [
            'note' => 'required',
            ]
        );

        $client_id     = $request->client_id;
        $unique_id     = $request->unique_id;
        $company_id = $request->company_id;

        $this->client->add_note($note, $deal_id, $client_id, $company_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);

    }
    public function edit_note(Request $request){
        $note = $request->note;
        $deal_id = $request->deal_id;

        $this->validate(
            $request, [
            'note' => 'required',
            ]
        );

         $note_id     = $request->note_id;
        $unique_id     = $request->unique_id;

         $this->client->edit_note($note, $deal_id, $note_id);

         $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

    public function delete_note(Request $request){
        $note_id     = $request->note_id;
        $unique_id     = $request->unique_id;

        $this->client->remove_note($note_id);

        $redirect_to = 'corpemt/client/view/'.$unique_id;

        return redirect($redirect_to);
    }

}
