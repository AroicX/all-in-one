<?php
namespace App\Models\CorpEMT;

use Illuminate\Database\Eloquent\Model;
use DB;

class DealsModel extends Model
{

    protected $deals_table = 'emt_deals',
        $client_table = 'emt_clients',
        $users_table = 'users';

    public function deals_count($company_id, $owner_id = null)
    {
        if (empty($owner_id)) {
            $deals = DB::table($this->deals_table)->where('company_id', $company_id);
        } else {
            $deals = DB::table($this->deals_table)->where(['company_id' => $company_id, 'deal_owner' => $owner_id]);
        }

        return $deals->count();
    }

    public function deal_amount($id){
        return DB::table($this->deals_table)->select('amount')->where('id', $id)->first();
    }

    public function deal_stage_count($company_id, $stage = null){
        if (empty($stage)){
            $deals = DB::table($this->deals_table)->where(['company_id' => $company_id]);
            $deals->where('deal_stage', '!=', 'won');
            $deals->where('deal_stage', '!=', 'lost');
        } else {
            $deals = DB::table($this->deals_table)->where(['company_id' => $company_id, 'deal_stage' => $stage]);
        }

        return $deals->count();
    }

    public function expected_total($company_id, $year){
        $deals = DB::table($this->deals_table)->select('amount')->where(['company_id' => $company_id, 'year' => $year]);
        $deals->where('deal_stage', '!=', 'lost');
        $deals = $deals->get();

        $total = 0;
        foreach ($deals as $deal) {
            $total += $deal->amount;
        }
        return $total;
    }

    public function cash($company_id, $year, $status)
    {
        $deals = DB::table($this->deals_table)->select('amount')->where(['company_id' => $company_id, 'deal_stage' => $status, 'year' => $year]);
        $deals = $deals->get();

        $total = 0;
        foreach ($deals as $deal) {
            $total += $deal->amount;
        }
        return $total;
    }

    public function list_deals($company_id, $client_id = null)
    {
        if (empty($client_id)) {
            $deals = DB::table($this->deals_table)
                ->join($this->client_table, 'emt_deals.client_id', '=', 'emt_clients.id')
                ->join($this->users_table, 'emt_deals.deal_owner', '=', 'users.id')
                ->select(
                    'emt_deals.*',
                    'users.name',
                    'emt_clients.client_company',
                    'emt_clients.unique_id'
                )
                ->where('emt_deals.company_id', $company_id);
        } else {
            $deals = DB::table($this->deals_table)
            ->where(['company_id' => $company_id, 'client_id' => $client_id]);
        }

        $deals->orderBy('id', 'desc');

        return $deals->get();
    }

    public function pending_month_deal($month, $year, $stage, $company_id = null){
        if(is_null($company_id)){
            $query = DB::table($this->deals_table)->where(['month'=>$month, 'year'=>$year, 'deal_stage'=>$stage]);
        }else{
            $query = DB::table($this->deals_table)->where(['month'=>$month, 'year'=>$year, 'deal_stage'=>$stage, 'company_id'=>$company_id]);
        }

        return $query->get();
    }

    public function monthly_stage_deals($month, $year, $stage, $company_id = null){
        if(is_null($company_id)){
            $query = DB::table($this->deals_table)->where(['month'=>$month, 'year'=>$year, 'deal_stage'=>$stage]);
        }else{
            $query = DB::table($this->deals_table)->where(['month'=>$month, 'year'=>$year, 'deal_stage'=>$stage, 'company_id'=>$company_id]);
        }

        return $query->sum('amount');
    }

    public function yearly_stage_deals($year, $stage, $company_id = null){
        if(is_null($company_id)){
            $query = DB::table($this->deals_table)->where(['year'=>$year, 'deal_stage'=>$stage]);
        }else{
            $query = DB::table($this->deals_table)->where(['year'=>$year, 'deal_stage'=>$stage, 'company_id'=>$company_id]);
        }

        return $query->sum('amount');
    }

    public function all_pending_deal($company_id){
        return DB::table($this->deals_table)
            ->where('company_id', $company_id)
            ->where('deal_stage', '!=', 'won')
            ->where('deal_stage', '!=', 'lost')
            ->get();
    }

    public function won_lost_month_deal($month, $year, $company_id = null){
        if(is_null($company_id)){
            $query = DB::table($this->deals_table)
                ->where(function ($query) use($month, $year) {
                    $query->where(['month'=>$month, 'year'=>$year]);
                })
                ->where(function($query){
                    $query->whereIn('deal_stage', ['won', 'lost']);
                });
        }else{
            $query = DB::table($this->deals_table)
                ->where(function ($query) use($month, $year, $company_id) {
                    $query->where(['month'=>$month, 'year'=>$year, 'company_id'=>$company_id]);
                })
                ->where(function($query){
                    $query->whereIn('deal_stage', ['won', 'lost']);
                });
        }

        return $query->get();
    }

    public function add_deal($name, $amount, $expected_close_date, $deal_stage, $note, $owner, $client_id, $company_id)
    {
        $date_created = date('m/d/Y');
        $month = date('m');
        $year = date('Y');

        $save = DB::table($this->deals_table)->insert([
            'company_id' => $company_id,
            'client_id' => $client_id,
            'deal_owner' => $owner,
            'deal_name' => ucwords($name),
            'amount' => $amount,
            'date_created' => $date_created,
            'expected_close_date' => $expected_close_date,
            'deal_stage' => $deal_stage,
            'note' => ucfirst($note),
            'month' => $month,
            'year' => $year]);

        return $save;
    }

    public function update_deal($name, $amount, $expected_close_date, $deal_stage, $owner, $deal_id)
    {
        $update = DB::table($this->deals_table)->where('id', $deal_id)->update(['deal_owner' => $owner, 'deal_name' => $name, 'amount' => $amount, 'expected_close_date' => $expected_close_date, 'deal_stage' => $deal_stage]);

        return $update;
    }

    public function remove_deal($deal_id)
    {
        $remove = DB::table($this->deals_table)->where('id', $deal_id)->delete();
        return $remove;
    }

    public function deal_per_month($month, $year, $status = null)
    {
        if (!empty($status) AND $status == 'lost') {
            $deals = DB::table($this->deals_table)->where(['deal_stage' => $status, 'month' => $month, 'year' => $year]);
        } else {
            $deals = DB::table($this->deals_table)->where(['month' => $month, 'year' => $year]);
            $deals->where('deal_stage', '!=', 'lost');
        }

        return $deals->count();
    }

    public function monthly_deals($year, $status = null)
    {
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $deals = array();

        foreach ($months as $month) {
            $deals[] = $this->deal_per_month($month, $year, $status);
        }

        return implode(', ', $deals);
    }

    public function graphical_analysis($year)
    {
        return '
		datasets: [
        {
            label: "Deals Pending",
            fillColor: "#00c0ef",
            strokeColor: "#00c0ef",
            pointColor: "#00c0ef",
            pointStrokeColor: "#00c0ef",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#00c0ef",
            data: [' . $this->monthly_deals($year) . ']
        },
        {
            label: "Deals Won",
            fillColor: "#00a65a",
            strokeColor: "#00a65a",
            pointColor: "#00a65a",
            pointStrokeColor: "#00a65a",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#00a65a",
            data: [' . $this->monthly_deals($year, 'won') . ']
        },
        {
            label: "Deals Lost",
            fillColor: "#dd4b39",
            strokeColor: "#dd4b39",
            pointColor: "#dd4b39",
            pointStrokeColor: "#dd4b39",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#dd4b39",
            data: [' . $this->monthly_deals($year, 'lost') . ']
        }
    ]
      ';
    }
}
