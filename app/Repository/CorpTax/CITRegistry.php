<?php
/**
 * Created by PhpStorm.
 * User: dubem
 * Date: 1/15/17
 * Time: 12:27 AM
 */

namespace App\Repository\CorpTax;


use App\Models\CorpTax\TrialBalanceMock;
use Illuminate\Support\Facades\Auth;

class CITRegistry
{
    /**
     * @var TrialBalanceMock
     */
    private $trialBalance;

    /**
     * CITRegistry constructor.
     * @param TrialBalanceMock $trialBalance
     */
    public function __construct(TrialBalanceMock $trialBalance)
    {
        $this->trialBalance = $trialBalance;
    }

    /**
     *
     */
    public function getCompanyProfile()
    {
        /**
         * using Method injection, call the method to get the company profile from CORPFIN
         */


        $dummyData = ['company_name'=> 'okeke and sons',
                    'tax_id'=>'er33433d',
                    'incorporation_date'=>'01/03/2017',
                    'registered_address' =>'22 close umuahia',
                    'state'=>'Lagos',
                    'LGA'=>'Amuwo Odofin',
                    'business_address'=>'01/03/2017',
                    'b_state'=>'Lagos',
                    'b_LGA'=>'Amuwo Odofin',
                    'YOA'=>'2016',
                    'YOAc'=>'2015',
            
        ];

        return $dummyData;
    }

    public function save($trialBalanceData)
    {
        $company_id = Auth::user()->company_id;
        $data = [
            'company_id' =>$company_id,
            'allowable_expenses'=>$trialBalanceData[0],
            'disallowable_expenses'=>$trialBalanceData[1],
            'vatable_revenue'=>$trialBalanceData[2],
            'nonvatable_revenue'=>$trialBalanceData[3],
            'accumulated_depreciation'=>$trialBalanceData[4],
            'cost_of_ppe'=>$trialBalanceData[5],
            'tax_payable'=>$trialBalanceData[6],
            'vat_payable'=>$trialBalanceData[7],
            'share_capital'=>$trialBalanceData[8],
            'reserves'=>$trialBalanceData[9],
            'deferred_tax_liabilities'=>$trialBalanceData[10],
            'deferred_tax_asset'=>$trialBalanceData[11],
            'wht_receivables'=>$trialBalanceData[12],
            'wht_payable'=>$trialBalanceData[13],
            'direct_costs'=>$trialBalanceData[14],
            'others'=>$trialBalanceData[15],
        ];

         return $this->trialBalance->create($data);
    }
}