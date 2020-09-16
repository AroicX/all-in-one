<?php
/**
 * Created by PhpStorm.
 * User: dubem
 * Date: 1/19/17
 * Time: 8:34 AM
 */

namespace App\Services\CorpTax;


use App\Repository\CorpTax\CITRegistry;
class TrialBalanceManager
{
    protected $entries;
    protected $debit;
    protected $credit;
    /**
     * @var CITRegistry
     */
    private $CITRegistry;


    /**
     * TrialBalanceManager constructor.
     * @param CITRegistry $CITRegistry
     */
    public function __construct(CITRegistry $CITRegistry)
    {
        $this->CITRegistry = $CITRegistry;
    }


    public function mapTrialBalanceEntry($mappings, $excelData)
    {
        $this->entries = $excelData[0];
        $this->debit   = $excelData[1];
        $this->credit  = $excelData[2];
        $trialBalanceData = [];

        foreach($mappings as $map){
             $index = explode(',',$map);
          $trialBalanceData[] =   $this->calculateAmount($index);
        }

       return $this->CITRegistry->save($trialBalanceData)
           ? true
           : false;
    }

    /**
     * @param $index
     * @return int|null
     */
    public function calculateAmount($index){
        $sum = null;

        foreach($index as $value){

            if($this->entries[$value]){
                $credit = empty($this->credit[$value]) ? 0 : $this->credit[$value];
                $debit  = empty($this->debit[$value]) ? 0 : $this->debit[$value];
                $sum += ($credit + $debit);
            }
        }
            return  $sum;

    }

}