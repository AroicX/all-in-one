<?php

namespace App\Http\Controllers\CorpFIN;

use App\Company;
use App\CorpFinProduct;
use App\CorpfinWhttype;
use App\Country;
use App\SubAccount;
use App\Models\CorpFIN\FixedAssetRegister;

use App\Http\Controllers\Controller;
use App\State;
use App\Vat;
use App\Wht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use App\Models\CorpFIN;
use Illuminate\Support\Facades\Input;
use App\Traits\SubscriptionTrait;
use PDF, Excel;
use App\Models\CorpFIN\Markup;
use App\Exports\LedgerExport;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * @method generate_method
     *
     *
     */
   public static function generate_reports()
   {
        if(request()->type == 'balance_sheet')
        {
            return self::View_bs();
        }
        if(request()->type == 'trial_balance')
        {
            return self::view_trial_balance();
        }
        if(request()->type == 'income_statement')
        {
            return self::view_income_statement_report();
        }
        if(request()->type == 'asset_register')
        {
            return self::view_fixed_asset_register_report();
        }
        return $type;
   }
   ////View balance sheet////
    public static  function View_bs()
    {
   
        $start = Carbon::parse(request()->start_date);
        $end = Carbon::parse(request()->end_date);
        // $start_date = date('m-d-Y', strtotime(request()->start_date));
        // $end_date = date('m-d-Y', strtotime(request()->end_date));
        // $start = str_replace('-', '/', $start_date);
        // $end = str_replace('-', '/', $end_date);
        if(Auth::check()){
            $company = Company::find(Auth::user()->company_id);
            $partners = DB::table('corpfin_customers')->where('company_id', $company->id)->get();
            if($company){
                 if(!empty($company->CRN) && !empty($company->FYE)){
                    $sellable = $company->deliverable_type;
                    $ledgers = DB::table('corpfin_generalledger')->where('company_id', $company->id)->whereBetween('date', [$start, $end])->orderBy('date', 'desc')->get()->toArray();
                     $sub_accounts = SubAccount::all();
                     // $pdf = PDF::loadView('CorpFIN.panel.Balancesheet', ['deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers,  'start' => $start, 'end' => $end]);
                     // return $pdf->stream('balancesheet.pdf');
                     return view('CorpFIN.panel.Balancesheet', ['title'=> 'Balance Sheet', 'deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers, 'sub_accounts'=> $sub_accounts, 'start' => $start, 'end' => $end]);

                      // return Excel::create('itsolutionstuff_example', function($excel) use ($ledgers) {
                      //           $excel->sheet('ledger', function($sheet) use ($ledgers)
                      //           {
                      //               $sheet->fromArray($data);
                      //           });
                      //          })->download("xls");
                     //return Excel::download(new LedgerExport(2018), 'posts.xls');
                }
                else{
                     return Redirect::intended('corpfin/setup');
                }
            }
            else{
                    return Redirect::intended('corpfin/setup');
                }
            }
        else{
            return Redirect::intended('login');
        }



    }
    /////End View balance cheet/////
    //trial balance report
    public static function view_trial_balance(){         
        $start = Carbon::parse(request()->start_date);
        $end = Carbon::parse(request()->end_date);
         if(Auth::check()){
            $company = Company::find(Auth::user()->company_id);
            $partners = DB::table('corpfin_customers')->where('company_id', $company->id)->get();
            if($company){
                 if(!empty($company->CRN) && !empty($company->FYE)){
                    $sellable = $company->deliverable_type;
                    $ledgers = DB::table('corpfin_generalledger')->where('company_id', $company->id)->whereBetween('date', [$start, $end])->orderBy('date', 'desc')->get();

                    $sub_accounts = SubAccount::all();
                     // $pdf = PDF::loadView('CorpFIN.panel.trial_balance', ['deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers, 'start' => $start, 'end' => $end]);
                     // return $pdf->stream('balancesheet.pdf');
                     return view('CorpFIN.panel.trial_balance', ['title'=> 'Trial Balance', 'deliverable_type' => $sellable, 'company_details' => $company, 'sub_accounts'=> $sub_accounts, 'ledgers' => $ledgers, 'start' => $start, 'end' => $end]);
                }
                else{
                     return Redirect::intended('corpfin/setup');
                }
            }
            else{
                    return Redirect::intended('corpfin/setup');
                }
            }
        else{
            return Redirect::intended('login');
        }

    }
    //income statement report
    public static function view_income_statement_report(){
        $start = Carbon::parse(request()->start_date);
        $end = Carbon::parse(request()->end_date);
         if(Auth::check()){
            $company = Company::find(Auth::user()->company_id);
            $partners = DB::table('corpfin_customers')->where('company_id', $company->id)->get();
            if($company){
                 if(!empty($company->CRN) && !empty($company->FYE)){
                    $sellable = $company->deliverable_type;
                    $ledgers = DB::table('corpfin_generalledger')->where('company_id', $company->id)->whereBetween('date', [$start, $end])->orderBy('date', 'desc')->get();

                    $sub_accounts = SubAccount::all();
                     // $pdf = PDF::loadView('CorpFIN.panel.trial_balance', ['deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers, 'start' => $start, 'end' => $end]);
                     // return $pdf->stream('balancesheet.pdf');
                     return view('CorpFIN.panel.income_sheet', ['title'=> 'Income Statement', 'deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers, 'sub_accounts'=> $sub_accounts, 'start' => $start, 'end' => $end]);
                }
                else{
                     return Redirect::intended('corpfin/setup');
                }
            }
            else{
                    return Redirect::intended('corpfin/setup');
                }
            }
        else{
            return Redirect::intended('login');
        }

    }

    //income statement report
    public static function view_fixed_asset_register_report(){
        $start = Carbon::parse(request()->start_date);
        $end = Carbon::parse(request()->end_date);
        $total = 0;
        $accum =0;
         if(Auth::check()){
            $company = Company::find(Auth::user()->company_id);
            $partners = DB::table('corpfin_customers')->where('company_id', $company->id)->get();
            if($company){
                 if(!empty($company->CRN) && !empty($company->FYE)){
                    $asset_register = FixedAssetRegister::where('company_id', $company->id)->whereBetween('date', [$start, $end])->with('asset_sub_account')->orderBy('date', 'desc')->get();
                    foreach ($asset_register as $item) {
                        $useful_life_month = self::useful_life_month($item->amount, $item->asset_sub_account->dep_rate);
                        $item['useful_life_month'] = number_format((float)$useful_life_month, 2, '.', '');
                         
                        $item['dep_per_month'] = self::dep_per_month($item->amount, $item->asset_sub_account->dep_rate);
                        $item['no_of_months_expired'] = self::month_diff($item->date, Carbon::now());
                        $item['no_of_months_unexpired'] = $item['useful_life_month'] - self::month_diff($item->date, Carbon::now());
                        $diff_expired_request_date = self::month_diff($item->date, $start) - $item['no_of_months_expired'];
                        $item['deps_for_period'] = $diff_expired_request_date * $item['dep_per_month'];
                        $accum += $item['deps_for_period']; 
                        $item['accum_dep'] = $accum; 
                        $total += $item->amount;
                    }
                    // return $asset_register;
                     return view('CorpFIN.panel.asset_register_report', [ 'title'=> 'Fixed Asset Register', 'company_details' => $company, 'asset_register' => $asset_register, 'start' => $start, 'end' => $end, 'total' => $total ]);
                }
                else{
                     return Redirect::intended('corpfin/setup');
                }
            }
            else{
                    return Redirect::intended('corpfin/setup');
                }
            }
        else{
            return Redirect::intended('login');
        }

    }


    //profit and loss report
    public function view_profit_loss()
    {
      $start_date = date('m-d-Y', strtotime(request()->start_date));
      $end_date = date('m-d-Y', strtotime(request()->end_date));
      $start = str_replace('-', '/', $start_date);
      $end = str_replace('-', '/', $end_date);
      //dd($start);
       if(Auth::check()){
          $company = Company::find(Auth::user()->company_id);
          $partners = DB::table('corpfin_customers')->where('company_id', $company->id)->get();
          if($company){
               if(!empty($company->CRN) && !empty($company->FYE)){
                  $sellable = $company->deliverable_type;
                  $ledgers = DB::table('corpfin_generalledger')->where('company_id', $company->id)->whereBetween('date', [$start, $end])->orderBy('date', 'desc')->get();

                  
                   $pdf = PDF::loadView('CorpFIN.panel.view_profit_loss', ['deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers, 'start' => $start, 'end' => $end]);
                   return $pdf->stream('balancesheet.pdf');
                   //return view('CorpFIN.panel.Balancesheet', ['deliverable_type' => $sellable, 'company_details' => $company, 'ledgers' => $ledgers]);
              }
              else{
                   return Redirect::intended('corpfin/setup');
              }
          }
          else{
                  return Redirect::intended('corpfin/setup');
              }
          }
      else{
          return Redirect::intended('login');
      }
    }
    ////////////////////////////////End Reports////////////////////////////////////
     //////////////////////////////Reports///////////////////////////////////////

    //Todo: not reviewed
    public function reports()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $fetch = DB::select(DB::raw("SELECT * FROM users WHERE  id = '$user_id' "));
            foreach ($fetch as $key => $query) {
                $company_id = $query->company_id;
                $partners = DB::select(DB::raw("SELECT * FROM corpfin_customers WHERE  company_id = '$company_id' "));
                $x = DB::select(DB::raw("SELECT * FROM company WHERE  id = '$company_id' "));
                if ($x) {
                    foreach ($x as $key => $y) {
                        if (!empty($y->CRN) && !empty($y->FYE)) {

                            //get date//
                            $i = $y->FYE;
                            $j = explode('_', $i);
                            $month = $j[0];
                            $day = $j[1];
                            //end get date//
                            $sellable = $y->deliverable_type;
                            return view('CorpFIN.panel.Reports', ['deliverable_type' => $sellable, 'company_details' => $x, 'month' => $month, 'day' => $day]);
                        } else {
                            return Redirect::intended('corpfin/setup');
                        }
                    }
                } else {
                    return Redirect::intended('corpfin/setup');
                }
            }
            return Redirect::intended('corpfin/setup');
        } else {
            //return view('auth.login');
            return Redirect::intended('login');
        }

    }

    /**
     * @method dep_per_month
     * calculate fixed asset depreciation per months
     * @param $amount
     * @param dep_rate (%)
     * @return int
     */
    public static function dep_per_month($amount, int $dep_rate)
    {
       return (($dep_rate/100) * $amount);
       
    }
    /**
     * @method useful_life_month
     * calculate fixed asset useful life in months
     * @param $amount
     * @param dep_rate (%)
     * @return int
     */
    public static function useful_life_month($amount, int $dep_rate)
    {
       return $amount/self::dep_per_month($amount, $dep_rate);
    }
    /**
     * @method month_diff
     * compares 2 dates in months
     * @param $date1
     * @param date2
     * @return int
     */
    public static function month_diff($date1, $date2)
    {
        $to = Carbon::createFromFormat('Y-m-d H:s:i', $date2);
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $date1);
        return $diff_in_months = $to->diffInMonths($from);
    }

}
