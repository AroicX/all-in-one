<?php 
namespace App\Models\CorpEMT;
use DB;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{

    protected    $client_table     = 'emt_clients',
                $action_table     = 'emt_actions',
                $note_table     = 'emt_notes',
                $call_table        =  'emt_calls';

    public function total_number_of_clients($company_id)
    {
        return DB::table($this->client_table)->where('company_id', $company_id)->count();
    }


    public function details($unique_id, $company_id)
    {
        $client = DB::table($this->client_table)->where(['company_id'=>$company_id, 'unique_id'=>$unique_id]);
        return $client->first();
    }


    public function list_all_clients($company_id)
    {
        $clients = DB::table($this->client_table)->select('client_company', 'name', 'owner', 'unique_id')->where(['company_id'=>$company_id]);
        return $clients->get();
    }


    public function save_client($name, $job_title, $company_name, $phone, $email, $url, $address, $status, $tags, $lead_source, $background, $owner, $option, $company_id, $unique_id)
    {
        $save = DB::table($this->client_table)->insert(['company_id'=>$company_id, 'client_company'=>$company_name, 'name'=>ucwords($name), 'job_title'=>ucfirst($job_title), 'phone'=>$phone, 'email'=>strtolower($email), 'url'=>$url, 'address'=>ucfirst($address), 'status'=>$status, 'tags'=>$tags, 'lead_source'=>$lead_source, 'background'=>ucfirst($background), 'owner'=>$owner, 'option'=>$option, 'unique_id'=>$unique_id]);

        return $save;
    }

    public function update_personal_details($name, $job_title, $phone, $email, $url, $address, $city, $state, $zip, $country, $client_id, $company_id)
    {
        $update = DB::table($this->client_table)->where(['id'=>$client_id, 'company_id'=>$company_id])->update(['name'=>ucwords($name), 'job_title'=>$job_title, 'phone'=>$phone, 'email'=>strtolower($email), 'url'=>$url, 'address'=>ucfirst($address), 'city'=>ucwords($city), 'state'=>ucwords($state), 'zip'=>$zip, 'country'=>ucwords($country)]);

        return $update;
    }



    public function update_other_information_details($status, $tags, $lead_source, $background, $client_id, $company_id)
    {
        $update = DB::table($this->client_table)->where(['id'=>$client_id, 'company_id'=>$company_id])->update(['status'=>$status, 'tags'=>$tags, 'lead_source'=>$lead_source, 'background'=>$background]);
        return $update;
    }



    public function update_client_company_details($name, $description, $phone, $url, $address, $client_id, $company_id)
    {
        $update = DB::table($this->client_table)->where(['id'=>$client_id, 'company_id'=>$company_id])->update(['client_company'=>$name, 'company_description'=>$description, 'company_phone'=>$phone, 'company_url'=>$url, 'company_address'=>$address]);

        return $update;
    }


    public function get_client_id($unique_id, $company_id)
    {    
        $client = DB::table($this->client_table)->select('id')->where(['company_id'=>$company_id, 'unique_id'=>$unique_id]);
        return $client->first();
    }



    public function add_next_action($note, $schedule, $schedule_date, $schedule_time, $client_id, $company_id)
    {
        $date = date('m/d/Y');
        $save = DB::table($this->action_table)->insert(['client_id'=>$client_id, 'company_id'=>$company_id, 'note'=>ucfirst($note), 'schedule'=>$schedule, 'schedule_date'=>$schedule_date, 'schedule_time'=>$schedule_time, 'date_created'=>$date]);

        return $save;
    }


    public function mark_action_as_done($action_id)
    {
        $update = DB::table($this->action_table)->where('id', $action_id)->update(['status'=>'completed']);
        return $update;
    }



    public function list_actions($company_id, $client_id = null){

        if(is_null($client_id)){
            $actions = DB::table($this->action_table)->where('company_id', $company_id);
        }else{
            $actions = DB::table($this->action_table)->select('id', 'note', 'schedule', 'schedule_date', 'schedule_time', 'status', 'date_created', 'date_edited')->where(['client_id'=>$client_id, 'company_id'=>$company_id]);
        }

        $actions->orderBy('id', 'desc');

        return $actions->get();
    }

    public function completed_actions($company_id){
        return DB::table($this->action_table)->where(['status'=>'completed', 'company_id'=>$company_id])->orderBy('schedule_date', 'asc')->get();
    }

    public function pending_actions($company_id){
        return DB::table($this->action_table)->where(['status'=>'pending', 'company_id'=>$company_id])->orderBy('schedule_date', 'asc')->get();
    }

    public function pending_action_count($company_id){
        return DB::table($this->action_table)->where(['status'=>'pending', 'company_id'=>$company_id])->count();
    }



    public function update_existing_action($note, $schedule, $schedule_date, $schedule_time, $action_id)
    {
        $date = date('m/d/Y');
        $update = DB::table($this->action_table)->where('id', $action_id)->update(['note'=>$note, 'schedule'=>$schedule, 'schedule_date'=>$schedule_date, 'schedule_time'=>$schedule_time, 'date_edited'=>$date]);

        return $update;
    }


    public function remove_action($action_id)
    {
        $remove = DB::table($this->action_table)->where('id', $action_id)->delete();
        return $remove;
    }


    public function add_call($feedback, $note, $company_id, $client_id)
    {
        $date = date('m/d/Y');
        $save = DB::table($this->call_table)->insert(['client_id'=>$client_id, 'company_id'=>$company_id, 'feedback'=>$feedback, 'note'=>$note, 'date_created'=>$date]);
        return $save;
    }


    public function edit_call($feedback, $note, $call_id)
    {
        $date = date('m/d/Y');
        $update = DB::table($this->call_table)->where('id', $call_id)->update(['feedback'=>$feedback, 'note'=>$note, 'date_edited'=>$date]);
        return $update;
    }


    public function list_calls($client_id, $company_id)
    {
        $calls = DB::table($this->call_table)->select('id', 'feedback', 'note', 'date_created', 'date_edited')->where(['client_id'=>$client_id, 'company_id'=>$company_id]);
        $calls->orderBy('id', 'desc');

        return $calls->get();
    }


    public function remove_call($call_id)
    {
        $remove = DB::table($this->call_table)->where('id', $call_id)->delete();
        return $remove;
    }


    public function list_notes($client_id, $company_id)
    {
        $notes = DB::table($this->note_table)->select('id', 'note', 'deal_id', 'date_created', 'date_edited')->where(['company_id'=>$company_id, 'client_id'=>$client_id]);
        $notes->orderBy('id', 'desc');
        return $notes->get();
    }


    public function add_note($note, $deal_id, $client_id, $company_id)
    {
        $date = date('m/d/Y');
        $save = DB::table($this->note_table)->insert(['company_id'=>$company_id, 'client_id'=>$client_id, 'deal_id'=>$deal_id, 'note'=>$note, 'date_created'=>$date]);
        return $save;
    }


    public function remove_note($note_id)
    {
        $delete = DB::table($this->note_table)->where('id', $note_id)->delete();
        return $delete;
    }


    public function edit_note($note, $deal_id, $note_id)
    {
        $date = date('m/d/Y');
        $update = DB::table($this->note_table)->where('id', $note_id)->update(['deal_id'=>$deal_id, 'note'=>$note, 'date_edited'=>$date]);
        return $update;
    }
}
