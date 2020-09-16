<?php

namespace App\Http\Controllers\CorpFIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth, Validator;
use Response;
use App\Account;
use App\SubAccount;
use App\CorpFinProduct;
use App\CorpFinService;
use App\CorpFinTranPartner;
use Carbon\Carbon;
use App\Models\CorpFIN\FixedAssetRegister;
use App\Http\Controllers\CorpFIN\FixedAssetRegisterController;

class CorpFinCITController extends Controller
{
	/**
	 *
	 *
	 *
	 */
	public static function index()
	{
		$exclude_array = ['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098'];
		$excluded_expenses = self::get_accounts(array(31, 32), $exclude_array, null);
		return view('CorpTax.CIT.cit_computation')->with(['excluded_expenses' => $excluded_expenses]);
	}
    /**
     * @method compute_corpfin_cit
     * compute corpfin cit
     * @return 
     */
    public static function compute_corpfin_cit()
    {	
		// return request()->type;
        $validation = Validator::make(request()->all(),
        [ 
            'to_date' => 'required',
            'from_date' => 'required',
            'type' => 'required',
            
        ]);

        if($validation->fails()){
            return $validation->errors()->all();
        }
        $start = request()->from_date;
    	$end = request()->to_date;
        $start = str_replace('-', '/', $start);
        $end = str_replace('-', '/', $end);
    	$status = request()->status;
    	

		// $sub_accounts = SubAccount::all();
		$accounts = Account::all();
		$cit_array = [];
		$revenue_array = [];
		$direct_cost_array = [];
		$depreciation_array = [];
		$finance_cost_array = [];
		$opex_array = [];
		$grandtotal = 0;
		$direct_cost = 0;
		$revenue = 0;
		$gross_profit = 0;
		$depreciation = 0;
		$finace_cost = 0;
		$opex = 0;
		$gross_profit = 0;
		$profit_before_tax = 0;
		//revenue
		foreach($accounts as $account){
			if($account->id == 27 ){
				$account_name = $account->acct_name;
				$revenue = self::get_account_ledger_total(array($account->id));
				$revenue_array = [
					'account_name' => 'Revenue',
					'sub_account_name' => $account_name,
					'total' => $revenue
				];
				array_push($cit_array, $revenue_array);
	        }
	        //Direct cost
	        if($account->id == 30 ){
				$account_name = $account->acct_name;
				$direct_cost = self::get_account_ledger_total(array($account->id));
				$direct_cost_array = [
					'account_name' => 'Cost of sales',
					'sub_account_name' => $account_name,
					'total' => $direct_cost
				];
				array_push($cit_array, $direct_cost_array);
	        }
	        //indirect cost | operating cost
	        ##excluding all depreciations['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098']
	        if($account->id == 31 ){
				$account_name = $account->acct_name;
				$exclude_array = ['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098'];
				$opex = self::get_account_ledger_total(array($account->id, 32), $exclude_array, null);
				$opex_array = [
					'account_name' => 'Administrative expenses',
					'sub_account_name' => $account_name,
					'total' => $opex
				];
				array_push($cit_array, $opex_array);
	        }
	        // depreciation
	        if($account->id == 31 ){
				$account_name = $account->acct_name;
				$include_array = ['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098'];
				$depreciation = self::get_account_ledger_total(array($account->id, 32), null, $include_array);
				$depreciation_array = [
					'account_name' => 'Administrative expenses',
					'sub_account_name' => 'Depreciation',
					'total' => $depreciation
				];
				array_push($cit_array, $depreciation_array);
	        }
	        // finance cost
	        if($account->id == 33 ){
				$account_name = $account->acct_name;
				$include_array = ['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098'];
				$finace_cost = self::get_account_ledger_total(array($account->id));
				$finance_cost_array = [
					'account_name' => 'Finance Cost',
					'sub_account_name' => 'Interest expense',
					'total' => $finace_cost
				];
				array_push($cit_array, $finance_cost_array);
	        }
	        $gross_profit = floatval($revenue - $direct_cost);
	        $profit_before_tax = floatval($gross_profit - ($opex + $depreciation + $finace_cost));

	        
	    }
	    $accessable_profit = $depreciation + $profit_before_tax;
	    $capital_allowance = self::compute_capital_allowance();

        #edutax = 2% of accessable profit
        //$edu_tax = (0.02 * $accessable_profit);
        #cit comuptation : minimum_tax
        $minimum_tax_array = [];
        $turnover = $revenue;
        if($revenue > 500000)
        {
            $turnover = $revenue - 500000;
        }
        #0.125% of turn over 
        $point_125_percent_turnover = 0.00125 * $turnover;
        #0.5% of gross profit
        $point_5_percent_gross_profit = 0.005 * $gross_profit;
        array_push($minimum_tax_array, $point_5_percent_gross_profit);
        #asset_class_id = 1
        $total_assets = self::get_account_ledger_total(null,null,null, 1);
        #liability class id = 2
        $total_liability = self::get_account_ledger_total(null, null, null, 2);
        $net_asset = $total_assets - $total_liability;
        #0.5% of net asset
        $point_5_percent_net_asset = 0.005 * $net_asset;
        array_push($minimum_tax_array, $point_5_percent_net_asset);

        #paid up capital = capital stock
        $paid_up_capital = self::get_account_ledger_total_without_period(array(22));
        #0.25% of paid up capital
        $point_25_percent_paidup_capital = 0.0025 * $paid_up_capital;
        array_push($minimum_tax_array, $point_25_percent_paidup_capital);
        #0.25% of turnover again
        $point_25_percent_turnover = 0.0025 * $revenue;
        array_push($minimum_tax_array, $point_25_percent_turnover);
        #get the max
        $max = max($minimum_tax_array);
        $minimum_tax = number_format($point_125_percent_turnover + $max, 2, '.', '');
        $minimum_tax = (float) $minimum_tax;
        #cit comuptation : 30% of taxable_profit

        //$total_revenue = self::get_account_ledger_total(array($account->id));
		return response()->json([
            'status' => 'ok',
			'accounts' => $cit_array, 
			'gross_profit' => $gross_profit,
			'revenue_array' => $revenue_array,
			'direct_cost_array' => $direct_cost_array,
			'depreciation_array' => $depreciation_array,
			'finance_cost_array' => $finance_cost_array,
			'opex_array' => $opex_array,
			'profit_before_tax' => $profit_before_tax,
			'accessable_profit' => $accessable_profit,
            'capital_allowance' => $capital_allowance,
			'minimum_tax' => $minimum_tax
		]);
    }

    public static function get_account_ledger_total(array $account_ids = null, array $exclude_array = null, array $accept_array = null, int $class_id =null)
    {
    	$start = request()->from_date;
    	$end = request()->to_date;
    	$company_id = Auth::user()->company->id;
    	$grandtotal =0;
    	$query = DB::table('corpfin_generalledger')->where('company_id', $company_id)->whereBetween('date', [$start, $end]);
        if(!empty($account_ids))
        {
            $query->whereIn('account_id', $account_ids);
        }
        if(!empty($class_id))
        {
            $query->where('class_id', $class_id);
        }
    	if(!empty($exclude_array)){
    		$query->whereNotIn('account_no', $exclude_array);
    	}
    	if(!empty($accept_array)){
    		$query->whereIn('account_no', $accept_array);
    	}

        $ledgers = $query->get();

    	foreach($ledgers as $ledger){
            $grandtotal += floatval($ledger->Dr + $ledger->Cr);
        }
		return $grandtotal;
    }

    public static function get_account_ledger_total_without_period(array $account_ids = null, array $exclude_array = null, array $accept_array = null, int $class_id =null)
    {
        $start = request()->from_date;
        $end = request()->to_date;
        $company_id = Auth::user()->company->id;
        $grandtotal =0;
        $query = DB::table('corpfin_generalledger')->where('company_id', $company_id);
        if(!empty($account_ids))
        {
            $query->whereIn('account_id', $account_ids);
        }
        if(!empty($class_id))
        {
            $query->where('class_id', $class_id);
        }
        if(!empty($exclude_array)){
            $query->whereNotIn('account_no', $exclude_array);
        }
        if(!empty($accept_array)){
            $query->whereIn('account_no', $accept_array);
        }

        $ledgers = $query->get();

        foreach($ledgers as $ledger){
            $grandtotal += floatval($ledger->Dr + $ledger->Cr);
        }
        return $grandtotal;
    }

    /**
     * @method get_accounts
     *
     *
     */
    public static function get_accounts(array $account_ids, array $exclude_array = null, array $accept_array = null)
    {
    	$company_id = Auth::user()->company->id;
    	$query = SubAccount::whereIn('account_id', $account_ids);
    	if(!empty($exclude_array)){
    		$query->whereNotIn('sub_account_no', $exclude_array);
    	}
    	if(!empty($accept_array)){
    		$query->whereIn('sub_account_no', $accept_array);
    	}
    	$ledgers = $query->get();
		return $ledgers;
    }


    /**
     * @method get_account_ledgers
     *
     *
     */
    public static function get_account_ledgers($account_no)
    {
    	$start = request()->from_date;
    	$end = request()->to_date;
    	$company_id = Auth::user()->company->id;
    	$query = DB::table('corpfin_generalledger')->where('company_id', $company_id)->where('account_no', $account_no)/*->whereBetween('date', [$start, $end])*/->get();
    	
		return response()->json(['status' => 'success', 'data' => $query ]);
    }
    /**
     * compute capoital allowance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public static function compute_capital_allowance()
    {
    	$start = request()->from_date;
    	$end = request()->to_date;
        $company_id = Auth::user()->company->id;
        $query =  FixedAssetRegister::where('company_id', $company_id)->with('asset_sub_account')->whereBetween('date', [$start, $end])->get();
        $capital_allowance = 0;
        // $percentage_diff = 0;
        foreach ($query as $fixed_asset) {
        	if($fixed_asset->disposed == 0)
        	{
        		#calculate initial allowance
        		if($fixed_asset->capital_allowance_completed == 0)
        		{
        			$percentage = $fixed_asset->asset_sub_account->initial_allowance;
        			$percentage_diff = self::percentage_calculator($fixed_asset->asset_sub_account->initial_allowance, $fixed_asset->amount);
        		}
        		#calculate annual allowance
        		if($fixed_asset->capital_allowance_completed > 0 && $fixed_asset->capital_allowance_completed < 100)
        		{
        			$diff = $fixed_asset->capital_allowance_completed;
        			$percentage = 100 - $fixed_asset->asset_sub_account->annual_allowance;
        			if($fixed_asset->asset_sub_account->annual_allowance >= $diff)
        			{
        				$percentage = $diff;
        				$percentage_diff = self::percentage_calculator($diff, $fixed_asset->amount);
        			}else{
        				$percentage = $fixed_asset->asset_sub_account->annual_allowance;
        				$percentage_diff = self::percentage_calculator($fixed_asset->asset_sub_account->annual_allowance, $fixed_asset->amount);
        			}
        		}
        		#calculate annual allowance
        		if($fixed_asset->capital_allowance_completed == 100)
        		{
        			$percentage = 0;
        			$percentage_diff = 0;
        		}
        		/*$request = new Request([
			        'id'   => $fixed_asset->id,
			        'capital_allowance_completed'  => $percentage,
			    ]);
        		FixedAssetRegisterController::update($request);*/
        	}

        	$capital_allowance += $percentage_diff;
        }
        return $capital_allowance;
        
    }

    /**
     * calculates percentage.
     *@method percentage_calculator
     * @param  \Illuminate\Http\Request  $request
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public static function percentage_calculator($percentage, $amount)
    {
    	return (($percentage/100) * $amount);
    }



}
