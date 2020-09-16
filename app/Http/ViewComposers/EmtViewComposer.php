<?php
/**
 * Created by PhpStorm.
 * User: Access2emma
 * Date: 22-Feb-17
 * Time: 12:42 AM
 */

namespace App\Http\ViewComposers;
use App\Models\CorpEMT\ClientModel;
use Illuminate\View\View;

class EmtViewComposer
{
    protected $client;

    public function __construct()
    {
        $this->client = new ClientModel;
    }

    public function compose(View $view){
        $company_id = Auth()->user()->company_id;
        $view->with('pending_action', $this->client->pending_action_count($company_id));
    }

}