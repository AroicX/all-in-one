<?php 
namespace App\Http\Controllers\CorpEMT;
use Illuminate\Http\Request;
use App\Models\CorpEMT\SettingsModel;
use App\Models\CorpEMT\UsersModel;
use App\Models\CorpEMT\ClientModel;
use App\Models\CorpEMT\DealsModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;

class SettingsController extends Controller
{
    use SubscriptionTrait;
    public function __construct()
    {
        $this->setting     = new SettingsModel;
        $this->user     = new UsersModel;
        $this->client     = new ClientModel;
        $this->deal     = new DealsModel;
    }


    private function se()
    {
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;
        $sources = $this->setting->list_lead_sources('source', $company_id);
        $user     = $this->user->get_current_user($user_id, $company_id);
        $total_client = $this->client->total_number_of_clients($company_id);
        $pending_deals     = $this->deal->deal_stage_count($company_id);

        $page = 'Lead Source';

        return view('CorpEMT.lead_source', ['sources'=>$sources, 'total_client'=>$total_client, 'user'=>$user, 'page'=>$page, 'pending_deals'=>$pending_deals]);
    }

    public function source()
    {
        if (Auth::check()) {
            $query = $this->se();
            return $this->is_corpemt_user_set($query); 
        }
        else
        {
            return Redirect::intended('login');
        }
    }


    // 	public function filter()
    // 	{
    // 				       if (Auth::check()){
    // $query =  view('CorpEMT.filter');
    //  return $this->is_corpemt_user_set($query); 
    //  }
    // else
    // {
    // return Redirect::intended('login');
    // }
    // 	}




    public function save_lead_source(Request $request)
    {
        $title     = $request->title;

        //validation//
        $this->validate(
            $request, [
            'title' => 'required',
            ]
        );


        $identity     = 'source';
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;    
        $feedback = $this->setting->save_setting($title, $identity, $company_id);

        $redirect_to = 'corpemt/setting/source';

        if ($feedback === true) {
            return redirect($redirect_to)->with('success', 'Lead Source successfully added');
        }
        else
        {
            return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        }
    }



    public function save_filter(Request $request)
    {
        $title     = $request->title;

        //validation//
        $this->validate(
            $request, [
            'title' => 'required',
            ]
        );


        $identity     = 'filter';
        $company_id = Auth::user()->company_id;
        $user_id     = Auth::user()->id;        
        $feedback = $this->setting->save_setting($title, $identity, $company_id);

        $redirect_to = 'corpemt/setting/filter';

        if ($feedback === true) {
            return redirect($redirect_to)->with('success', 'Filter successfully added');
        }
        else
        {
            return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        }
    }



    public function remove_source(Request $request)
    {
        $source_id     = $request->id;
        $feedback     = $this->setting->remove_setting($source_id);

        $redirect_to = 'corpemt/setting/source';

        if ($feedback === true) {
            return redirect($redirect_to)->with('success', 'Lead Source successfully removed');
        }
        else
        {
            return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        }
    }



    public function remove_filter(Request $request)
    {
        $source_id     = $request->id;
        $feedback     = $this->setting->remove_setting($source_id);

        $redirect_to = 'corpemt/setting/filter';

        if ($feedback === true) {
            return redirect($redirect_to)->with('success', 'Filter successfully removed');
        }
        else
        {
            return redirect($redirect_to)->with('error', 'An error occured, process could not be completed');
        }
    }


}
